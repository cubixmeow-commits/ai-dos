<?php
declare(strict_types=1);

/**
 * AI-DOS Repository Compiler (PHP)
 *
 * Reads organizational source code from the repository and generates
 * disposable Mission Control artifacts under site/.
 *
 * CLI: php compiler/compile.php
 */

require_once __DIR__ . '/RepositoryIntelligence.php';
require_once __DIR__ . '/DecisionRecords.php';
require_once __DIR__ . '/ExecutionEngine.php';

final class RepositoryCompiler
{
    private string $root;
    private string $siteDir;
    private string $dataDir;

    /** @var list<array<string, mixed>> */
    private array $missions = [];

    /** @var list<string> */
    private array $webLog = [];

    /** @var list<string> */
    private array $webErrors = [];

    public function __construct(?string $root = null)
    {
        $this->root = $root ?? dirname(__DIR__);
        $this->siteDir = $this->root . '/site';
        $this->dataDir = $this->siteDir . '/data';
    }

    public function run(): int
    {
        $this->missions = $this->scanMissions();
        usort($this->missions, static fn(array $a, array $b): int => (int) $a['id'] <=> (int) $b['id']);

        $organization = $this->buildOrganization();

        if (!$this->ensureDirectories()) {
            return 1;
        }

        $registry = $this->loadAssetRegistry();
        $intelligence = new RepositoryIntelligence(
            $this->root,
            $this->missions,
            $organization,
            $registry
        );

        $dependencyReport = $intelligence->compileDependencyReport();
        $manifest = $intelligence->compileManifest($dependencyReport);
        $contextPackages = $intelligence->compileContextPackages();
        $decisions = (new DecisionRecords($this->root))->compile();
        $executionEngine = (new ExecutionEngine($this->root))->compile($contextPackages, $organization);
        $repository = $intelligence->compileRepository($manifest, $contextPackages, $dependencyReport, $decisions, $executionEngine);

        $this->missions = $this->sanitizeForJson($this->missions);
        $organization = $this->sanitizeForJson($organization);
        $manifest = $this->sanitizeForJson($manifest);
        $contextPackages = $this->sanitizeForJson($contextPackages);
        $dependencyReport = $this->sanitizeForJson($dependencyReport);
        $repository = $this->sanitizeForJson($repository);
        $decisions = $this->sanitizeForJson($decisions);
        $executionEngine = $this->sanitizeForJson($executionEngine);

        $writes = [
            'missions.json' => $this->missions,
            'organization.json' => $organization,
            'manifest.json' => $manifest,
            'context-packages.json' => $contextPackages,
            'dependency-report.json' => $dependencyReport,
            'repository.json' => $repository,
            'decisions.json' => $decisions,
            'execution-engine.json' => $executionEngine,
        ];

        foreach ($writes as $file => $data) {
            $json = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
            if ($json === false) {
                $this->errorln("Failed to encode {$file}: " . json_last_error_msg());
                return 1;
            }
            file_put_contents($this->dataDir . '/' . $file, $json . "\n");
        }

        file_put_contents($this->siteDir . '/index.html', $this->renderIndexHtml());
        file_put_contents($this->siteDir . '/styles.css', $this->renderStylesCss());

        $this->writeln('Compiled ' . count($this->missions) . ' missions to site/data/');
        $this->writeln('Generated repository intelligence, decisions, execution-engine.json');
        $this->writeln('Generated site/index.html and site/styles.css');

        return 0;
    }

    private function writeln(string $message): void
    {
        if (PHP_SAPI === 'cli') {
            fwrite(STDOUT, $message . "\n");
            return;
        }

        $this->webLog[] = $message;
    }

    private function errorln(string $message): void
    {
        if (PHP_SAPI === 'cli') {
            fwrite(STDERR, $message . "\n");
            return;
        }

        $this->webErrors[] = $message;
    }

    /** @return list<string> */
    public function getWebLog(): array
    {
        return $this->webLog;
    }

    /** @return list<string> */
    public function getWebErrors(): array
    {
        return $this->webErrors;
    }

    /** @return list<array<string, mixed>> */
    private function scanMissions(): array
    {
        $missions = [];
        $pattern = $this->root . '/missions/*/mission.md';

        foreach (glob($pattern) ?: [] as $missionFile) {
            $dir = dirname($missionFile);
            $folder = basename($dir);

            if (!preg_match('/^(\d{3})-(.+)$/', $folder, $matches)) {
                continue;
            }

            $id = $matches[1];
            $slug = $matches[2];
            $missionContent = (string) file_get_contents($missionFile);
            $reportFile = $dir . '/report.md';
            $reportContent = is_file($reportFile) ? (string) file_get_contents($reportFile) : '';

            $title = $this->extractTitle($missionContent, $reportContent, $id);
            $executedBy = $this->extractField($missionContent, 'Executed by');
            $missionStatusLine = $this->extractField($missionContent, 'Status');
            $reportStatusLine = $reportContent !== '' ? $this->extractField($reportContent, 'Status') : '';

            $status = $this->normalizeStatus($missionStatusLine, $reportStatusLine, $id);
            $confidence = $this->extractConfidence($reportContent);
            $summary = $this->extractSummary($missionContent, $reportContent);
            $approvalQuestion = $this->extractApprovalQuestion($reportContent);
            $whatLearned = $this->extractSection($reportContent, 'What AI-DOS Learned');
            $nextMission = $this->extractNextMission($approvalQuestion, $reportContent);

            $missions[] = [
                'id' => $id,
                'slug' => $slug,
                'title' => $title,
                'status' => $status['label'],
                'status_category' => $status['category'],
                'path' => 'missions/' . $folder,
                'summary' => $summary,
                'approval_question' => $approvalQuestion,
                'what_ai_dos_learned' => $whatLearned,
                'executed_by' => $executedBy,
                'confidence' => $confidence,
                'next_mission' => $nextMission,
                'has_report' => $reportContent !== '',
                'artifacts' => $this->listArtifacts($dir),
            ];
        }

        return $missions;
    }

    /** @return array<string, mixed> */
    private function buildOrganization(): array
    {
        $completed = array_values(array_filter(
            $this->missions,
            static fn(array $m): bool => ($m['status_category'] ?? '') === 'complete'
        ));

        $paused = array_values(array_filter(
            $this->missions,
            static fn(array $m): bool => ($m['status_category'] ?? '') === 'paused'
        ));

        $inProgress = array_values(array_filter(
            $this->missions,
            static fn(array $m): bool => in_array($m['status_category'] ?? '', ['in_progress', 'active'], true)
        ));

        $backlog = is_file($this->root . '/tasks/Backlog.md')
            ? (string) file_get_contents($this->root . '/tasks/Backlog.md')
            : '';

        $nextFromBacklog = $this->extractBacklogNextMission($backlog);
        $mission007 = $this->findMission('007');
        $mission008 = $this->findMission('008');

        $currentMission = null;
        if ($mission008 !== null && ($mission008['status_category'] ?? '') !== 'complete') {
            $currentMission = [
                'id' => '008',
                'title' => $mission008['title'] ?? 'Build the Repository Compiler',
                'status' => $mission008['status'] ?? 'in progress',
            ];
        } elseif (count($inProgress) > 0) {
            $m = $inProgress[0];
            $currentMission = [
                'id' => $m['id'],
                'title' => $m['title'],
                'status' => $m['status'],
            ];
        }

        $nextMission = $nextFromBacklog;

        $mission007Approval = 'unknown';
        if ($mission007 !== null) {
            $statusText = strtolower((string) ($mission007['status'] ?? ''));
            if (str_contains($statusText, 'approved')) {
                $mission007Approval = 'approved';
            } elseif (str_contains($statusText, 'complete')) {
                $mission007Approval = 'complete_pending_operator_record';
            } else {
                $mission007Approval = 'pending';
            }
        }

        $registry = $this->loadAssetRegistry();

        $organization = [
            'compiled_at' => gmdate('c'),
            'compiler' => 'Repository Compiler (PHP)',
            'compiler_version' => '1.5.0-mission-012',
            'current_mission' => $currentMission,
            'next_mission' => $nextMission,
            'completed_mission_count' => count($completed),
            'paused_missions' => array_map(static function (array $m): array {
                return [
                    'id' => $m['id'],
                    'title' => $m['title'],
                    'status' => $m['status'],
                    'reason' => $m['id'] === '006'
                        ? 'Phase B — operator-executed validation (interviews and smoke test)'
                        : 'blocked on operator',
                ];
            }, $paused),
            'active_strategy' => $this->extractActiveStrategy(),
            'canonical_branch' => 'main',
            'governance_model' => 'Merge-to-main is durable approval; chat approval is advisory only (Standards §2).',
            'source_of_truth_statement' => 'Repository artifacts are canonical. Compiler outputs under site/ are generated views and must not invent facts.',
            'mission_007_v2_architecture' => [
                'status' => $mission007Approval,
                'title' => $mission007['title'] ?? 'Design AI-DOS V2',
            ],
            'strategic_pivot' => 'AI-DOS itself is the primary product. Portfolio Projects use a product-agnostic workflow; Mission 006 validates the first candidate (P001).',
            'repository_compiler_concept' => 'The repository is the source code of the organization. The Repository Compiler (PHP) transforms that source into human-readable Mission Control interfaces.',
            'command_center_url' => $this->deploymentUrl('site/'),
            'compiler_url' => $this->deploymentUrl('compiler/compile.php'),
            'deployment_note' => 'Command Center is the public entry point. Compiler is CLI/CI build tool — not the dashboard.',
        ];

        if ($registry !== null) {
            $organization['asset_registry'] = [
                'source' => $registry['asset_registry']['source'] ?? 'system/assets.yaml',
                'version' => $registry['asset_registry']['version'] ?? null,
                'asset_count' => $registry['asset_registry']['asset_count'] ?? 0,
                'full_lookup' => 'site/data/repository.json',
            ];
        }

        return $organization;
    }

    private function deploymentUrl(string $path): string
    {
        $base = 'https://cubixmeow.com/ai-dos/';
        if ($path === 'site/') {
            return $base . 'site/';
        }

        return $base . ltrim($path, '/');
    }

    /**
     * Load Asset Registry (system/assets.yaml).
     *
     * @return array{asset_registry: array<string, mixed>}|null
     */
    private function loadAssetRegistry(): ?array
    {
        $assetsFile = $this->root . '/system/assets.yaml';
        if (!is_file($assetsFile)) {
            return null;
        }

        $parsed = $this->parseRegistryYaml((string) file_get_contents($assetsFile));
        if ($parsed === null) {
            return null;
        }

        $meta = is_array($parsed['meta'] ?? null) ? $parsed['meta'] : [];
        $rawAssets = $parsed['assets'] ?? $parsed['entries'] ?? [];

        if (!is_array($rawAssets)) {
            $rawAssets = [];
        }

        $assets = [];
        foreach ($rawAssets as $asset) {
            if (!is_array($asset)) {
                continue;
            }
            $summary = $this->summarizeAssetForJson($asset);
            if ($summary !== null) {
                $assets[] = $summary;
            }
        }

        $assetRegistry = [
            'source' => 'system/assets.yaml',
            'registry' => (string) ($meta['registry'] ?? 'asset-registry'),
            'parse_status' => count($assets) > 0 ? 'ok' : 'empty',
            'version' => $meta['version'] ?? null,
            'deployment_root' => $meta['deployment_root'] ?? null,
            'last_updated' => $meta['last_updated'] ?? null,
            'asset_count' => count($assets),
            'assets' => $assets,
        ];

        return ['asset_registry' => $assetRegistry];
    }

    /**
     * @return array<string, mixed>|null
     */
    private function summarizeAssetForJson(array $asset): ?array
    {
        $path = $asset['source']['path'] ?? $asset['path'] ?? null;
        if ($path === null && !isset($asset['id'])) {
            return null;
        }

        $publicUrl = $asset['public']['url'] ?? $asset['public_url'] ?? null;
        $editable = $asset['editable'] ?? $asset['safe_to_edit'] ?? true;
        $generated = $asset['generated'] ?? (($asset['source_or_generated'] ?? '') === 'generated');
        $createdBy = $asset['created_by'] ?? $asset['created_by_mission'] ?? null;

        return [
            'id' => (string) ($asset['id'] ?? ''),
            'type' => (string) ($asset['type'] ?? ''),
            'name' => (string) ($asset['name'] ?? ''),
            'path' => $path !== null ? (string) $path : null,
            'status' => (string) ($asset['status'] ?? ''),
            'public_url' => $publicUrl,
            'editable' => (bool) $editable,
            'generated' => (bool) $generated,
            'created_by' => $createdBy !== null ? (string) $createdBy : null,
            'depends_on' => array_values(array_filter(
                is_array($asset['depends_on'] ?? null) ? $asset['depends_on'] : [],
                static fn(mixed $v): bool => is_string($v) && $v !== ''
            )),
            'outputs' => array_values(array_filter(
                is_array($asset['outputs'] ?? null) ? $asset['outputs'] : [],
                static fn(mixed $v): bool => is_string($v) && $v !== ''
            )),
        ];
    }

    /**
     * @return array<string, mixed>|null
     */
    private function parseRegistryYaml(string $content): ?array
    {
        if (function_exists('yaml_parse')) {
            $yaml = yaml_parse($content);
            if (is_array($yaml)) {
                return $yaml;
            }
        }

        return $this->parseAssetRegistryYamlSubset($content);
    }

    /**
     * Minimal YAML parser for AI-DOS asset registry (flat assets, shallow nesting).
     *
     * @return array<string, mixed>|null
     */
    private function parseAssetRegistryYamlSubset(string $content): ?array
    {
        $meta = [];
        $assets = [];
        $current = null;
        $section = null;
        $nested = null;

        foreach (preg_split('/\r\n|\r|\n/', $content) ?: [] as $line) {
            if (preg_match('/^\s*#/', $line)) {
                continue;
            }

            if (preg_match('/^meta:\s*$/', $line)) {
                $section = 'meta';
                $current = null;
                $nested = null;
                continue;
            }

            if (preg_match('/^(assets|entries):\s*/', $line)) {
                $section = 'assets';
                $current = null;
                $nested = null;
                continue;
            }

            if (preg_match('/^\s*-\s+id:\s*(.+)$/', $line, $m)) {
                if ($current !== null && $section === 'assets') {
                    $assets[] = $current;
                }
                $current = ['id' => $this->parseYamlScalar(trim($m[1]))];
                $nested = null;
                continue;
            }

            if (preg_match('/^\s*-\s+path:\s*(.+)$/', $line, $m)) {
                if ($current !== null && $section === 'assets') {
                    $assets[] = $current;
                }
                $current = ['path' => $this->parseYamlScalar(trim($m[1]))];
                $nested = null;
                continue;
            }

            if (preg_match('/^\s{2}(source|public):\s*$/', $line, $m)) {
                $nested = $m[1];
                if ($current !== null) {
                    $current[$nested] = [];
                }
                continue;
            }

            if (preg_match('/^\s{2,}([a-z_]+):\s*(.*)$/', $line, $m)) {
                $key = $m[1];
                $value = $this->parseYamlScalar(trim($m[2]));

                if ($section === 'meta') {
                    $meta[$key] = $value;
                    continue;
                }

                if ($section !== 'assets' || $current === null) {
                    continue;
                }

                if ($nested !== null && in_array($key, ['path', 'url'], true)) {
                    $current[$nested][$key] = $value;
                    continue;
                }

                if (in_array($key, ['safe_to_edit', 'editable', 'generated'], true)) {
                    $current[$key] = $value === true || $value === 'true';
                    continue;
                }

                if (in_array($key, ['depends_on', 'outputs'], true)) {
                    continue;
                }

                $current[$key] = $value;
                $nested = null;
            }

            if ($current !== null && $section === 'assets' && preg_match('/^\s{4}-\s+(.+)$/', $line, $m)) {
                $listKey = $nested === null ? 'depends_on' : null;
                if ($listKey === null) {
                    if (isset($current['depends_on']) && !isset($current['_outputs_mode'])) {
                        $current['depends_on'][] = trim($m[1]);
                    } elseif (isset($current['_outputs_mode'])) {
                        $current['outputs'][] = trim($m[1]);
                    }
                }
            }

            if ($current !== null && preg_match('/^\s{2}depends_on:\s*$/', $line)) {
                $current['depends_on'] = [];
                $current['_outputs_mode'] = false;
                $nested = null;
            }

            if ($current !== null && preg_match('/^\s{2}outputs:\s*$/', $line)) {
                $current['outputs'] = [];
                $current['_outputs_mode'] = true;
                $nested = null;
            }

            if ($current !== null && preg_match('/^\s{4}-\s+(\S+)/', $line, $m)) {
                if (!empty($current['_outputs_mode'])) {
                    $current['outputs'][] = $m[1];
                } elseif (isset($current['depends_on']) && is_array($current['depends_on'])) {
                    $current['depends_on'][] = $m[1];
                }
            }
        }

        if ($current !== null && $section === 'assets') {
            unset($current['_outputs_mode']);
            $assets[] = $current;
        }

        foreach ($assets as &$asset) {
            unset($asset['_outputs_mode']);
            if (!isset($asset['path']) && isset($asset['source']['path'])) {
                $asset['path'] = $asset['source']['path'];
            }
        }
        unset($asset);

        return ['meta' => $meta, 'assets' => $assets, 'entries' => $assets];
    }

    /** @return string|bool|null */
    private function parseYamlScalar(string $raw): string|bool|null
    {
        if ($raw === 'null' || $raw === '') {
            return null;
        }

        if ($raw === 'true') {
            return true;
        }

        if ($raw === 'false') {
            return false;
        }

        if (
            (str_starts_with($raw, '"') && str_ends_with($raw, '"'))
            || (str_starts_with($raw, "'") && str_ends_with($raw, "'"))
        ) {
            return substr($raw, 1, -1);
        }

        return $raw;
    }

    /** @param mixed $value */
    private function sanitizeForJson(mixed $value): mixed
    {
        if (is_array($value)) {
            $clean = [];
            foreach ($value as $key => $item) {
                $clean[$key] = $this->sanitizeForJson($item);
            }

            return $clean;
        }

        if (is_string($value)) {
            if (function_exists('mb_convert_encoding')) {
                return mb_convert_encoding($value, 'UTF-8', 'UTF-8');
            }

            return (string) preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]/u', '', $value);
        }

        return $value;
    }

    private function ensureDirectories(): bool
    {
        foreach ([$this->siteDir, $this->dataDir] as $dir) {
            if (!is_dir($dir) && !mkdir($dir, 0755, true)) {
                $this->errorln("Failed to create directory: {$dir}");
                return false;
            }
        }

        return true;
    }

    private function extractTitle(string $missionContent, string $reportContent, string $id): string
    {
        foreach ([$missionContent, $reportContent] as $content) {
            if (preg_match('/^#\s+Mission\s+' . preg_quote($id, '/') . '(?:\s+Report)?:\s*(.+)$/mi', $content, $m)) {
                return trim($m[1]);
            }
        }

        return 'Mission ' . $id;
    }

    private function extractField(string $content, string $field): ?string
    {
        if (preg_match('/^\*\*' . preg_quote($field, '/') . ':\*\*\s*(.+)$/mi', $content, $m)) {
            return trim($m[1]);
        }

        return null;
    }

    /** @return array{label: string, category: string} */
    private function normalizeStatus(?string $missionStatus, ?string $reportStatus, string $id): array
    {
        $text = strtolower(trim(($reportStatus ?? '') . ' ' . ($missionStatus ?? '')));

        if ($id === '006' && (str_contains($text, 'phase b') || str_contains($text, 'in progress'))) {
            return [
                'label' => 'Paused — Phase B (operator validation)',
                'category' => 'paused',
            ];
        }

        if (str_contains($text, 'approved')) {
            return ['label' => trim($reportStatus ?? $missionStatus ?? 'Complete — approved'), 'category' => 'complete'];
        }

        if (str_contains($text, 'complete')) {
            return ['label' => trim($reportStatus ?? $missionStatus ?? 'Complete'), 'category' => 'complete'];
        }

        if (str_contains($text, 'in progress') || str_contains($text, 'phase a') || str_contains($text, 'phase c')) {
            return ['label' => trim($missionStatus ?? $reportStatus ?? 'In progress'), 'category' => 'in_progress'];
        }

        if (str_contains($text, 'planned')) {
            return ['label' => 'Planned', 'category' => 'planned'];
        }

        if ($reportStatus !== null && $reportStatus !== '') {
            return ['label' => $reportStatus, 'category' => 'unknown'];
        }

        if ($missionStatus !== null && $missionStatus !== '') {
            return ['label' => $missionStatus, 'category' => 'unknown'];
        }

        return ['label' => 'Unknown', 'category' => 'unknown'];
    }

    private function extractConfidence(string $reportContent): ?string
    {
        if ($reportContent === '') {
            return null;
        }

        if (preg_match('/\*\*Decision confidence:\s*(High|Medium|Low)\*\*/i', $reportContent, $m)) {
            return ucfirst(strtolower($m[1]));
        }

        if (preg_match('/^## Decision confidence:\s*\*\*(High|Medium|Low)\*\*/mi', $reportContent, $m)) {
            return ucfirst(strtolower($m[1]));
        }

        return null;
    }

    private function extractSummary(string $missionContent, string $reportContent): string
    {
        if ($reportContent !== '') {
            if (preg_match('/## Executive summary\s*\n+([\s\S]*?)(?=\n## |\z)/', $reportContent, $m)) {
                return $this->firstMeaningfulParagraph($m[1]);
            }

            if (preg_match('/## What was changed and why\s*\n+([\s\S]*?)(?=\n## |\z)/', $reportContent, $m)) {
                return $this->firstMeaningfulParagraph($m[1]);
            }

            if (preg_match('/## What was created, and why each file exists\s*\n+([\s\S]*?)(?=\n## |\z)/', $reportContent, $m)) {
                $fromTable = $this->firstTableSummary($m[1]);
                if ($fromTable !== '') {
                    return $fromTable;
                }
                return $this->firstMeaningfulParagraph($m[1]);
            }

            if (preg_match('/## What changed\s*\n+([\s\S]*?)(?=\n## |\z)/', $reportContent, $m)) {
                return $this->firstMeaningfulParagraph($m[1]);
            }
        }

        if (preg_match('/## Objective\s*\n+([\s\S]*?)(?=\n## |\z)/', $missionContent, $m)) {
            return $this->firstMeaningfulParagraph($m[1]);
        }

        if (preg_match('/## Why this mission exists\s*\n+([\s\S]*?)(?=\n## |\z)/', $missionContent, $m)) {
            return $this->firstMeaningfulParagraph($m[1]);
        }

        return '';
    }

    private function firstMeaningfulParagraph(string $text): string
    {
        $lines = preg_split('/\r\n|\r|\n/', trim($text)) ?: [];
        $buffer = [];

        foreach ($lines as $line) {
            $line = trim($line);
            if ($line === '' || str_starts_with($line, '|') || str_starts_with($line, '---')) {
                if ($buffer !== []) {
                    break;
                }
                continue;
            }
            if (str_starts_with($line, '#')) {
                continue;
            }
            $buffer[] = $line;
            if (str_ends_with($line, '.') || str_ends_with($line, '?')) {
                break;
            }
        }

        $paragraph = trim(preg_replace('/\s+/', ' ', implode(' ', $buffer)) ?? '');
        if (strlen($paragraph) > 320) {
            $paragraph = substr($paragraph, 0, 317) . '...';
        }

        return $paragraph;
    }

    private function firstTableSummary(string $text): string
    {
        foreach (preg_split('/\r\n|\r|\n/', $text) ?: [] as $line) {
            $line = trim($line);
            if (!str_starts_with($line, '|')) {
                continue;
            }
            if (preg_match('/^\|[^|]+\|([^|]+)\|/', $line, $m)) {
                $cell = trim($m[1]);
                if ($cell !== '' && !str_contains(strtolower($cell), 'why it exists') && !str_contains(strtolower($cell), '---')) {
                    if (strlen($cell) > 320) {
                        $cell = substr($cell, 0, 317) . '...';
                    }
                    return $cell;
                }
            }
        }

        return '';
    }

    private function extractApprovalQuestion(string $reportContent): ?string
    {
        if ($reportContent === '') {
            return null;
        }

        preg_match_all('/^Approve\s+.+?\? Y\/N\s*$/mi', $reportContent, $matches);
        $candidates = $matches[0] ?? [];

        for ($i = count($candidates) - 1; $i >= 0; $i--) {
            $line = trim($candidates[$i]);
            $lineStart = strpos($reportContent, $line);
            if ($lineStart === false) {
                continue;
            }
            $prefix = substr($reportContent, max(0, $lineStart - 80), 80);
            if (str_contains($prefix, '~~')) {
                continue;
            }
            return $line;
        }

        return null;
    }

    private function extractNextMission(?string $approvalQuestion, string $reportContent): ?string
    {
        if ($approvalQuestion !== null && preg_match('/Approve Mission\s+(\d{3}):\s*(.+?)\?/i', $approvalQuestion, $m)) {
            return 'Mission ' . $m[1] . ': ' . trim($m[2]);
        }

        if (preg_match('/\*\*Next:\*\*\s*Mission\s+(\d{3})\s*[—-]\s*(.+)$/mi', $reportContent, $m)) {
            return 'Mission ' . $m[1] . ': ' . trim($m[2]);
        }

        return null;
    }

    private function extractSection(string $content, string $heading): ?string
    {
        if ($content === '') {
            return null;
        }

        $pattern = '/## ' . preg_quote($heading, '/') . '\s*\n+([\s\S]*?)(?=\n## |\n---\s*\n|\z)/';
        if (!preg_match($pattern, $content, $m)) {
            return null;
        }

        $section = trim($m[1]);
        if (str_starts_with($section, 'This mission changed AI-DOS itself')) {
            $section = preg_replace('/^This mission changed AI-DOS itself[^\n]*\n+/i', '', $section) ?? $section;
        }

        if (strlen($section) > 1200) {
            $section = substr($section, 0, 1197) . '...';
        }

        return $section !== '' ? $section : null;
    }

    /** @return list<string> */
    private function listArtifacts(string $dir): array
    {
        $artifacts = [];
        $optional = ['architecture.md', 'evidence-ledger.md', 'phase-a-thresholds.md', 'research.md', 'evaluation.md'];

        foreach ($optional as $file) {
            if (is_file($dir . '/' . $file)) {
                $artifacts[] = basename($dir) . '/' . $file;
            }
        }

        return $artifacts;
    }

    /** @return array<string, mixed>|null */
    private function findMission(string $id): ?array
    {
        foreach ($this->missions as $mission) {
            if (($mission['id'] ?? '') === $id) {
                return $mission;
            }
        }

        return null;
    }

    /** @return array{id: string, title: string, source: string}|null */
    private function extractBacklogNextMission(string $backlog): ?array
    {
        if (preg_match('/## Next:\s*Mission\s+(\d{3})\s*(?:—|–|-)\s*(.+)$/miu', $backlog, $m)) {
            return [
                'id' => $m[1],
                'title' => trim($m[2]),
                'source' => 'tasks/Backlog.md',
            ];
        }

        return null;
    }

    private function extractActiveStrategy(): string
    {
        $identityFile = $this->root . '/company/Identity.md';
        if (!is_file($identityFile)) {
            return 'AI-DOS is the primary product — a Git-native operating system for AI-assisted software development.';
        }

        $content = (string) file_get_contents($identityFile);
        if (preg_match('/## §1 What AI-DOS Is\s*\n+([\s\S]*?)(?=\n## |\z)/', $content, $m)) {
            return $this->firstMeaningfulParagraph($m[1]);
        }

        return 'AI-DOS is the primary product — a Git-native operating system for AI-assisted software development.';
    }

    private function renderIndexHtml(): string
    {
        $generated = gmdate('Y-m-d H:i:s') . ' UTC';

        return <<<HTML
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>AI-DOS | Mission Control</title>
  <meta name="description" content="AI-DOS Mission Control — compiled from repository source." />
  <link rel="stylesheet" href="styles.css?v=mission012" />
</head>
<body>
  <div class="noise" aria-hidden="true"></div>
  <div class="grid-overlay" aria-hidden="true"></div>

  <header class="hero" id="hero">
    <p class="kicker">MISSION CONTROL // COMPILED</p>
    <h1>AI-DOS</h1>
    <p class="subtitle">Repository source → PHP compiler → this interface.</p>
    <p class="support" id="strategy-line">Loading organization state…</p>
    <div class="hero-badges" id="hero-badges"></div>
  </header>

  <main>
    <section class="frame" id="architecture-stack">
      <h2>Architecture</h2>
      <p class="lead">Repository memory → intelligence → execution (planned) → compilation → operator.</p>
      <ol class="arch-stack" id="arch-stack"></ol>
    </section>

    <section class="frame" id="deployment-section">
      <h2>Deployment</h2>
      <div class="deploy-grid" id="deploy-grid"></div>
    </section>

    <section class="frame" id="compiler-concept">
      <h2>Repository Compiler (PHP)</h2>
      <p class="lead" id="compiler-lead"></p>
      <p class="canonical-note" id="source-truth"></p>
    </section>

    <section class="frame" id="current-state">
      <h2>Current State</h2>
      <div class="state-grid" id="state-grid"></div>
    </section>

    <section class="frame" id="timeline-section">
      <h2>Mission Timeline</h2>
      <ol class="timeline" id="mission-timeline"></ol>
    </section>

    <section class="frame" id="paused-section" hidden>
      <h2>Paused Missions</h2>
      <ul class="paused-list" id="paused-list"></ul>
    </section>

    <section class="frame">
      <h2>Governance Flow</h2>
      <ul class="flow">
        <li>Proposed</li>
        <li>Executed</li>
        <li>Reviewed</li>
        <li>Approved</li>
        <li>Merged</li>
        <li>Canonical</li>
      </ul>
      <p class="governance-note" id="governance-note"></p>
    </section>

    <section class="frame" id="next-section">
      <h2>Next Mission</h2>
      <div class="next-card" id="next-card"></div>
    </section>

    <section class="frame" id="execution-section">
      <h2>Execution Engine</h2>
      <p class="lead" id="execution-lead">Plans only — operator approves; workers execute manually.</p>
      <div class="intel-grid" id="execution-grid"></div>
      <h3 class="subhead">Worker Roles</h3>
      <ul class="role-list" id="role-list"></ul>
      <h3 class="subhead">Execution Flow</h3>
      <ol class="flow-list" id="execution-flow"></ol>
      <h3 class="subhead">Latest Execution Plan</h3>
      <div class="intel-card" id="execution-plan-card"></div>
      <h3 class="subhead">Build Status</h3>
      <div class="intel-card" id="build-status-card"></div>
    </section>

    <section class="frame" id="decisions-section">
      <h2>Decision Records</h2>
      <p class="lead">Durable architectural decisions in <code>decisions/</code> — compiled to decisions.json.</p>
      <ul class="decision-list" id="decision-list"></ul>
    </section>

    <section class="frame" id="intelligence-section">
      <h2>Repository Intelligence</h2>
      <p class="lead">Manifest, context packages, dependency health, and asset lookup — all from compiled JSON.</p>
      <div class="intel-grid" id="intel-grid"></div>
    </section>

    <section class="frame" id="manifest-section">
      <h2>Repository Manifest</h2>
      <div class="intel-card" id="manifest-card"></div>
    </section>

    <section class="frame" id="context-section">
      <h2>Context Packages</h2>
      <ul class="context-list" id="context-list"></ul>
    </section>

    <section class="frame" id="dependency-section">
      <h2>Dependency Health</h2>
      <div class="intel-card" id="dependency-card"></div>
      <ul class="issue-list" id="issue-list"></ul>
    </section>

    <section class="frame" id="relationships-section">
      <h2>Asset Relationships</h2>
      <ul class="relation-list" id="relation-list"></ul>
    </section>
  </main>

  <footer>
    <p class="canonical-line">Generated view only. Repository artifacts remain canonical.</p>
    <p>Compiled at <span id="compiled-at">{$generated}</span> by Repository Compiler (PHP)</p>
    <p>Source: <code>/missions/</code>, <code>/company/</code>, <code>/tasks/Backlog.md</code></p>
  </footer>

  <script>
    const categoryClass = {
      complete: 'status-complete',
      paused: 'status-paused',
      in_progress: 'status-active',
      active: 'status-active',
      planned: 'status-planned',
      unknown: 'status-unknown'
    };

    function el(tag, className, text) {
      const node = document.createElement(tag);
      if (className) node.className = className;
      if (text !== undefined) node.textContent = text;
      return node;
    }

    function markdownish(text) {
      if (!text) return '';
      return text.replace(/\\*\\*(.+?)\\*\\*/g, '<strong>$1</strong>');
    }

    async function loadMissionControl() {
      const endpoints = [
        'data/missions.json',
        'data/organization.json',
        'data/manifest.json',
        'data/context-packages.json',
        'data/dependency-report.json',
        'data/repository.json',
        'data/decisions.json',
        'data/execution-engine.json'
      ];

      const responses = await Promise.all(endpoints.map((e) => fetch(e)));
      if (!responses[0].ok || !responses[1].ok) {
        document.getElementById('strategy-line').textContent =
          'Failed to load compiled data. Run: php compiler/compile.php';
        return;
      }

      const missions = await responses[0].json();
      const org = await responses[1].json();
      const manifest = responses[2].ok ? await responses[2].json() : null;
      const contextPkgs = responses[3].ok ? await responses[3].json() : null;
      const depReport = responses[4].ok ? await responses[4].json() : null;
      const repository = responses[5].ok ? await responses[5].json() : null;
      const decisions = responses[6].ok ? await responses[6].json() : null;
      const execution = responses[7].ok ? await responses[7].json() : null;

      const stack = document.getElementById('arch-stack');
      const layers = [
        { name: 'Repository', detail: 'Git on main — canonical source of truth', status: 'active' },
        { name: 'Knowledge', detail: 'Missions, decisions, commits, company docs', status: 'active' },
        { name: 'Intelligence', detail: 'Manifest, lookup, context packages, validation', status: 'active' },
        { name: 'Execution', detail: 'Mission plans, roles, context routing — no auto-run', status: 'active' },
        { name: 'Compilation', detail: 'PHP Repository Compiler → site/', status: 'active' },
        { name: 'Operator', detail: 'Mission Control — merge-based approval', status: 'active' }
      ];
      layers.forEach((layer) => {
        const li = el('li', layer.status === 'planned' ? 'arch-planned' : 'arch-active');
        li.appendChild(el('strong', null, layer.name));
        if (layer.status === 'planned') {
          li.appendChild(el('span', 'arch-badge', 'Planned'));
        }
        li.appendChild(el('p', 'muted', layer.detail));
        stack.appendChild(li);
      });

      const deployGrid = document.getElementById('deploy-grid');
      const addDeploy = (label, value, note) => {
        const row = el('p');
        row.appendChild(el('span', null, label));
        const strong = el('strong', null, value);
        row.appendChild(strong);
        deployGrid.appendChild(row);
        if (note) {
          deployGrid.appendChild(el('p', 'muted', note));
        }
      };
      addDeploy('Visitors & operator', org.command_center_url || 'https://cubixmeow.com/ai-dos/site/', 'Public entry point — bookmark this URL.');
      addDeploy('Compiler (build)', org.compiler_url || 'https://cubixmeow.com/ai-dos/compiler/compile.php', org.deployment_note || 'CLI/CI build tool — not the dashboard.');
      addDeploy('How compile runs', 'php compiler/compile.php or GitHub Actions on push/PR', 'Regenerates site/data/*.json and Mission Control HTML.');

      document.getElementById('compiler-lead').innerHTML = markdownish(org.repository_compiler_concept || '');
      document.getElementById('source-truth').textContent = org.source_of_truth_statement || '';
      document.getElementById('strategy-line').textContent = org.strategic_pivot || org.active_strategy || '';
      document.getElementById('governance-note').textContent = org.governance_model || '';
      if (org.compiled_at) {
        document.getElementById('compiled-at').textContent = org.compiled_at;
      }

      const badges = document.getElementById('hero-badges');
      badges.appendChild(el('span', 'badge', 'CANONICAL: REPOSITORY'));
      badges.appendChild(el('span', 'badge', 'BRANCH: ' + (org.canonical_branch || 'main')));
      if (org.current_mission) {
        badges.appendChild(el('span', 'badge badge-active', 'ACTIVE: M' + org.current_mission.id));
      }

      const stateGrid = document.getElementById('state-grid');
      const addState = (label, value) => {
        const row = el('p');
        row.appendChild(el('span', null, label));
        row.appendChild(el('strong', null, value));
        stateGrid.appendChild(row);
      };

      addState('Completed missions', String(org.completed_mission_count ?? missions.filter(m => m.status_category === 'complete').length));
      addState('Governance', 'Merge-to-main approval');
      addState('Mission 007 V2 architecture', (org.mission_007_v2_architecture && org.mission_007_v2_architecture.status) || 'unknown');
      if (org.current_mission) {
        addState('Current mission', 'M' + org.current_mission.id + ' — ' + org.current_mission.title);
      }
      if (org.next_mission) {
        addState('Next mission', 'M' + org.next_mission.id + ' — ' + org.next_mission.title);
      }

      const timeline = document.getElementById('mission-timeline');
      missions.forEach((mission) => {
        const item = el('li', 'dossier ' + (categoryClass[mission.status_category] || 'status-unknown'));
        const meta = el('div', 'meta');
        meta.appendChild(el('span', 'mission-id', 'M' + mission.id));
        meta.appendChild(el('span', 'status', mission.status || 'Unknown'));
        item.appendChild(meta);
        item.appendChild(el('h3', null, mission.title));
        if (mission.summary) {
          item.appendChild(el('p', 'outcome', mission.summary));
        }
        if (mission.what_ai_dos_learned) {
          const learned = el('p', 'learned');
          learned.innerHTML = '<strong>Learned:</strong> ' + markdownish(mission.what_ai_dos_learned.split('\\n')[0].replace(/^[-*]\\s*/, ''));
          item.appendChild(learned);
        }
        if (mission.confidence) {
          item.appendChild(el('p', 'confidence-tag', 'Decision confidence: ' + mission.confidence));
        }
        timeline.appendChild(item);
      });

      if (org.paused_missions && org.paused_missions.length > 0) {
        document.getElementById('paused-section').hidden = false;
        const list = document.getElementById('paused-list');
        org.paused_missions.forEach((paused) => {
          const li = el('li');
          li.appendChild(el('strong', null, 'M' + paused.id + ' — ' + paused.title));
          li.appendChild(document.createTextNode(': ' + (paused.reason || paused.status)));
          list.appendChild(li);
        });
      }

      const nextCard = document.getElementById('next-card');
      if (org.next_mission) {
        nextCard.appendChild(el('p', 'next-id', 'Mission ' + org.next_mission.id));
        nextCard.appendChild(el('p', 'next-title', org.next_mission.title));
        nextCard.appendChild(el('p', 'next-source', 'Source: ' + (org.next_mission.source || 'tasks/Backlog.md')));
      } else {
        nextCard.appendChild(el('p', null, 'No next mission declared in Backlog.md'));
      }

      if (execution) {
        const eGrid = document.getElementById('execution-grid');
        const addExec = (label, value) => {
          const row = el('p');
          row.appendChild(el('span', null, label));
          row.appendChild(el('strong', null, value));
          eGrid.appendChild(row);
        };
        addExec('Status', execution.status || 'unknown');
        addExec('Capabilities', String((execution.capabilities || []).length));
        addExec('Work unit types', String((execution.work_unit_types || []).length));
        addExec('Execution plans', String(execution.execution_plans?.plan_count ?? 0));
        if (execution.routing_guide?.cursor) {
          addExec('Cursor', (execution.routing_guide.cursor.operator_note || 'implementation'));
        }
        if (execution.routing_guide?.claude_code) {
          addExec('Claude Code', (execution.routing_guide.claude_code.operator_note || 'architecture'));
        }

        const roleList = document.getElementById('role-list');
        (execution.worker_roles?.roles || []).forEach((role) => {
          const li = el('li');
          li.appendChild(el('strong', null, role.name || role.id));
          const tools = (role.practical_tools || []).map((t) => t.id).join(', ');
          li.appendChild(document.createTextNode(' — ' + (role.capabilities || []).slice(0, 2).join(', ') + (tools ? ' [' + tools + ']' : '')));
          roleList.appendChild(li);
        });

        const flowList = document.getElementById('execution-flow');
        (execution.execution_flow || []).forEach((step) => {
          const li = el('li');
          li.appendChild(el('strong', null, (step.step || '') + '. ' + (step.name || '')));
          li.appendChild(document.createTextNode(' — ' + (step.actor || step.output || '')));
          flowList.appendChild(li);
        });

        const planCard = document.getElementById('execution-plan-card');
        const plan = execution.latest_execution_plan;
        if (plan) {
          planCard.appendChild(el('p', null, plan.title || plan.id));
          planCard.appendChild(el('p', 'muted', 'Status: ' + (plan.status || 'unknown') + ' · ' + (plan.work_units || []).length + ' work units'));
          if (plan.routing_summary) {
            const cc = (plan.routing_summary.claude_code?.units || []).length;
            const cu = (plan.routing_summary.cursor?.units || []).length;
            planCard.appendChild(el('p', null, 'Routing: Claude Code ' + cc + ' units · Cursor ' + cu + ' units'));
          }
          if (plan.source_path) {
            planCard.appendChild(el('p', 'muted', 'Source: ' + plan.source_path));
          }
        } else {
          planCard.appendChild(el('p', 'muted', 'No execution plan in repository.'));
        }

        const buildCard = document.getElementById('build-status-card');
        const bs = execution.build_status || {};
        buildCard.appendChild(el('p', null, 'Engine: ' + (bs.execution_engine || 'unknown')));
        buildCard.appendChild(el('p', null, 'Autonomous execution: ' + (bs.autonomous_execution ? 'yes' : 'no')));
        buildCard.appendChild(el('p', null, 'Multi-agent history: ' + (bs.multi_agent_execution_occurred ? 'yes' : 'no')));
        if (execution.next_product_mission) {
          const npm = execution.next_product_mission;
          buildCard.appendChild(el('p', null, 'Next product mission: M' + (npm.mission_id || '?') + ' — ' + (npm.title || '')));
        }
        if (bs.note) {
          buildCard.appendChild(el('p', 'muted', bs.note));
        }
      }

      if (decisions && decisions.decisions) {
        const dList = document.getElementById('decision-list');
        decisions.decisions.slice(0, 7).forEach((d) => {
          const li = el('li');
          li.appendChild(el('strong', null, d.id + ' — ' + (d.title || d.slug)));
          li.appendChild(document.createTextNode(' [' + (d.status || 'unknown') + ']'));
          if (d.decision) {
            const summary = d.decision.split('\\n')[0].slice(0, 120);
            li.appendChild(el('p', 'muted', summary + (d.decision.length > 120 ? '…' : '')));
          }
          dList.appendChild(li);
        });
      }

      if (manifest) {
        const intelGrid = document.getElementById('intel-grid');
        const addIntel = (label, value) => {
          const row = el('p');
          row.appendChild(el('span', null, label));
          row.appendChild(el('strong', null, value));
          intelGrid.appendChild(row);
        };
        addIntel('Repository health', (manifest.repository_health && manifest.repository_health.status) || 'unknown');
        addIntel('Compiler', manifest.compiler_version || 'unknown');
        addIntel('Asset registry', String(manifest.asset_registry_version ?? 'unknown'));
        addIntel('Architecture', manifest.architecture_version || 'unknown');
        addIntel('Context packages', contextPkgs ? String(contextPkgs.package_count) : '—');
        addIntel('Decisions', decisions ? String(decisions.decision_count ?? 0) : '—');

        const mCard = document.getElementById('manifest-card');
        mCard.appendChild(el('p', null, 'Completed: ' + (manifest.completed_missions ? manifest.completed_missions.length : 0)));
        if (manifest.current_mission) {
          mCard.appendChild(el('p', null, 'Current: M' + manifest.current_mission.id + ' — ' + manifest.current_mission.title));
        }
        if (manifest.next_mission) {
          mCard.appendChild(el('p', null, 'Next: M' + manifest.next_mission.id + ' — ' + manifest.next_mission.title));
        }
        mCard.appendChild(el('p', 'muted', 'Source: system/manifest.yaml → manifest.json'));
      }

      if (contextPkgs && contextPkgs.packages) {
        const list = document.getElementById('context-list');
        contextPkgs.packages.forEach((pkg) => {
          const li = el('li');
          li.appendChild(el('strong', null, pkg.name || pkg.id));
          li.appendChild(document.createTextNode(' — ' + (pkg.file_count || 0) + ' files'));
          if (pkg.purpose) {
            li.appendChild(el('p', 'muted', pkg.purpose));
          }
          list.appendChild(li);
        });
      }

      if (depReport) {
        const dCard = document.getElementById('dependency-card');
        dCard.appendChild(el('p', null, 'Status: ' + (depReport.status || 'unknown')));
        dCard.appendChild(el('p', null, 'Issues: ' + (depReport.issue_count || 0) + ' (' + (depReport.error_count || 0) + ' errors)'));
        dCard.appendChild(el('p', 'muted', depReport.repair_policy || 'report_only'));
        const issueList = document.getElementById('issue-list');
        (depReport.issues || []).slice(0, 8).forEach((issue) => {
          const li = el('li', issue.severity === 'error' ? 'issue-error' : 'issue-warn');
          li.textContent = (issue.asset_id || '?') + ': ' + issue.message;
          issueList.appendChild(li);
        });
        if ((depReport.issues || []).length > 8) {
          issueList.appendChild(el('li', 'muted', '…and ' + (depReport.issues.length - 8) + ' more in dependency-report.json'));
        }
      }

      if (repository && repository.lookup && repository.lookup.by_id) {
        const relList = document.getElementById('relation-list');
        const compiler = repository.lookup.by_id['compiler-compile-php'];
        if (compiler) {
          const li = el('li');
          li.appendChild(el('strong', null, 'compiler-compile-php'));
          li.appendChild(document.createTextNode(' → outputs: ' + (compiler.outputs || []).join(', ')));
          relList.appendChild(li);
        }
        const orgAsset = repository.lookup.by_id['site-data-organization-json'];
        if (orgAsset) {
          const li = el('li');
          li.appendChild(el('strong', null, 'site-data-organization-json'));
          li.appendChild(document.createTextNode(' ← depends on: ' + (orgAsset.depends_on || []).join(', ')));
          relList.appendChild(li);
        }
        const site = repository.lookup.by_id['site-index-html'];
        if (site) {
          const li = el('li');
          li.appendChild(el('strong', null, 'site-index-html'));
          li.appendChild(document.createTextNode(' ← depends on: ' + (site.depends_on || []).join(', ')));
          relList.appendChild(li);
        }
      }
    }

    loadMissionControl();
  </script>
</body>
</html>
HTML;
    }

    private function renderStylesCss(): string
    {
        $existing = $this->siteDir . '/styles.css';
        if (is_file($existing)) {
            $css = (string) file_get_contents($existing);
        } else {
            $css = '';
        }

        $additions = <<<'CSS'

/* Mission Control — Repository Compiler generated additions */
.lead { margin: 0 0 0.75rem; color: var(--text); }
.canonical-note, .governance-note { color: var(--muted); margin: 0.5rem 0 0; font-size: 0.92rem; }
.status-complete .status { color: var(--green); }
.status-paused .status { color: var(--warn); }
.status-active .status, .status-active.dossier { border-color: rgba(87, 228, 255, 0.45); }
.badge-active { color: var(--cyan); border-color: rgba(87, 228, 255, 0.5); }
.paused-list { margin: 0; padding-left: 1.1rem; color: var(--muted); }
.paused-list li { margin-bottom: 0.45rem; }
.next-card { border: 1px solid var(--line); border-radius: 10px; padding: 0.85rem 1rem; background: rgba(10, 20, 35, 0.55); }
.next-id { margin: 0; font-family: "JetBrains Mono", Consolas, monospace; color: var(--cyan); font-size: 0.82rem; }
.next-title { margin: 0.35rem 0; font-size: 1.05rem; }
.next-source { margin: 0; color: var(--muted); font-size: 0.85rem; }
.confidence-tag { color: var(--warn); font-size: 0.86rem; margin-top: 0.35rem; }
.intel-grid { display: grid; gap: 0.35rem; }
.intel-grid p, .intel-card p { margin: 0.35rem 0; color: var(--text); }
.intel-card { border: 1px solid var(--line); border-radius: 10px; padding: 0.85rem 1rem; background: rgba(10, 20, 35, 0.55); }
.context-list, .relation-list, .issue-list { margin: 0; padding-left: 1.1rem; color: var(--muted); }
.context-list li, .relation-list li, .issue-list li { margin-bottom: 0.5rem; }
.issue-error { color: #ff6b6b; }
.issue-warn { color: var(--warn); }
.arch-stack { margin: 0; padding-left: 1.1rem; list-style: decimal; }
.arch-stack li { margin-bottom: 0.65rem; color: var(--text); }
.arch-planned { opacity: 0.85; }
.arch-badge { margin-left: 0.5rem; font-size: 0.72rem; color: var(--warn); border: 1px solid var(--warn); padding: 0.1rem 0.4rem; border-radius: 4px; text-transform: uppercase; }
.deploy-grid p { margin: 0.35rem 0; color: var(--text); }
.deploy-grid span { display: block; font-size: 0.82rem; color: var(--muted); margin-bottom: 0.15rem; }
.decision-list { margin: 0; padding-left: 1.1rem; color: var(--muted); }
.decision-list li { margin-bottom: 0.55rem; }
.role-list, .flow-list { margin: 0; padding-left: 1.1rem; color: var(--muted); }
.role-list li, .flow-list li { margin-bottom: 0.45rem; }
.subhead { margin: 1rem 0 0.5rem; font-size: 0.95rem; color: var(--cyan); }
.muted { color: var(--muted); font-size: 0.88rem; margin: 0.25rem 0 0; }
CSS;

        if (!str_contains($css, 'Mission Control — Repository Compiler')) {
            $css .= $additions;
        }

        return $css;
    }
}

$compiler = new RepositoryCompiler();
$exitCode = $compiler->run();

if (PHP_SAPI !== 'cli') {
    header('Content-Type: text/html; charset=utf-8');
    $siteUrl = '../site/';
    if ($exitCode === 0) {
        $lines = array_map(
            static fn(string $line): string => '<li>' . htmlspecialchars($line, ENT_QUOTES, 'UTF-8') . '</li>',
            $compiler->getWebLog()
        );
        echo '<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8" />';
        echo '<meta name="viewport" content="width=device-width, initial-scale=1.0" />';
        echo '<title>AI-DOS Compiler</title>';
        echo '<style>body{font-family:system-ui,sans-serif;max-width:36rem;margin:2rem auto;padding:0 1rem;line-height:1.5}';
        echo 'a.btn{display:inline-block;margin-top:1rem;padding:.75rem 1rem;background:#0a2540;color:#fff;text-decoration:none;border-radius:8px}';
        echo 'ul{padding-left:1.2rem}</style></head><body>';
        echo '<h1>Repository Compiler</h1><p>Compile succeeded.</p><ul>' . implode('', $lines) . '</ul>';
        echo '<p><strong>Command Center (dashboard):</strong></p>';
        echo '<p><a class="btn" href="' . htmlspecialchars($siteUrl, ENT_QUOTES, 'UTF-8') . '">Open Mission Control</a></p>';
        echo '<p style="color:#666;font-size:.9rem">Bookmark <code>/ai-dos/site/</code> — not this compiler URL.</p>';
        echo '</body></html>';
    } else {
        $errors = $compiler->getWebErrors();
        echo '<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8" /><title>Compile failed</title></head><body>';
        echo '<h1>Compile failed</h1>';
        foreach ($errors as $err) {
            echo '<p>' . htmlspecialchars($err, ENT_QUOTES, 'UTF-8') . '</p>';
        }
        echo '</body></html>';
    }
}

exit($exitCode);
