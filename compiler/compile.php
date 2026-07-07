#!/usr/bin/env php
<?php
/**
 * AI-DOS Repository Compiler (PHP)
 *
 * Reads organizational source code from the repository and generates
 * disposable Mission Control artifacts under site/.
 */

declare(strict_types=1);

final class RepositoryCompiler
{
    private string $root;
    private string $siteDir;
    private string $dataDir;

    /** @var list<array<string, mixed>> */
    private array $missions = [];

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

        $this->missions = $this->sanitizeForJson($this->missions);
        $organization = $this->sanitizeForJson($organization);

        $missionsJson = json_encode($this->missions, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        $organizationJson = json_encode($organization, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

        if ($missionsJson === false || $organizationJson === false) {
            fwrite(STDERR, "Failed to encode JSON: " . json_last_error_msg() . "\n");
            return 1;
        }

        file_put_contents($this->dataDir . '/missions.json', $missionsJson . "\n");
        file_put_contents($this->dataDir . '/organization.json', $organizationJson . "\n");
        file_put_contents($this->siteDir . '/index.html', $this->renderIndexHtml());
        file_put_contents($this->siteDir . '/styles.css', $this->renderStylesCss());

        fwrite(STDOUT, "Compiled " . count($this->missions) . " missions to site/data/\n");
        fwrite(STDOUT, "Generated site/index.html and site/styles.css\n");

        return 0;
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
        if ($nextMission === null && $mission008 !== null) {
            $nextMission = [
                'id' => '009',
                'title' => 'V2 Foundation & Sequencing Reconciliation',
                'source' => 'missions/007-design-v2/report.md',
            ];
        }

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

        $fileIndex = $this->loadFileIndex();

        $organization = [
            'compiled_at' => gmdate('c'),
            'compiler' => 'Repository Compiler (PHP)',
            'compiler_version' => '1.1.0-mission-009',
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
        ];

        if ($fileIndex !== null) {
            $organization['file_index'] = $fileIndex;
        }

        return $organization;
    }

    /**
     * Load and summarize system/file-index.yaml for organization.json.
     *
     * Uses the PHP yaml extension when available; otherwise a minimal subset
     * parser for this repository's flat entry list (no nested structures).
     *
     * @return array<string, mixed>|null
     */
    private function loadFileIndex(): ?array
    {
        $file = $this->root . '/system/file-index.yaml';
        if (!is_file($file)) {
            return null;
        }

        $content = (string) file_get_contents($file);
        $parsed = null;

        if (function_exists('yaml_parse')) {
            $yaml = yaml_parse($content);
            if (is_array($yaml)) {
                $parsed = $yaml;
            }
        }

        if ($parsed === null) {
            $parsed = $this->parseFileIndexYamlSubset($content);
        }

        if ($parsed === null || !isset($parsed['entries']) || !is_array($parsed['entries'])) {
            return [
                'source' => 'system/file-index.yaml',
                'parse_status' => 'failed',
                'entry_count' => 0,
                'entries' => [],
            ];
        }

        $meta = is_array($parsed['meta'] ?? null) ? $parsed['meta'] : [];
        $entries = [];

        foreach ($parsed['entries'] as $entry) {
            if (!is_array($entry) || !isset($entry['path'])) {
                continue;
            }

            $entries[] = [
                'path' => (string) $entry['path'],
                'type' => (string) ($entry['type'] ?? ''),
                'status' => (string) ($entry['status'] ?? ''),
                'public_url' => $entry['public_url'] ?? null,
                'safe_to_edit' => (bool) ($entry['safe_to_edit'] ?? true),
                'source_or_generated' => (string) ($entry['source_or_generated'] ?? ''),
            ];
        }

        return [
            'source' => 'system/file-index.yaml',
            'parse_status' => 'ok',
            'version' => $meta['version'] ?? null,
            'deployment_root' => $meta['deployment_root'] ?? null,
            'last_updated' => $meta['last_updated'] ?? null,
            'entry_count' => count($entries),
            'entries' => $entries,
        ];
    }

    /**
     * Minimal YAML parser for AI-DOS file-index.yaml (flat maps only).
     *
     * @return array<string, mixed>|null
     */
    private function parseFileIndexYamlSubset(string $content): ?array
    {
        $meta = [];
        $entries = [];
        $current = null;
        $section = null;

        foreach (preg_split('/\r\n|\r|\n/', $content) ?: [] as $line) {
            if (preg_match('/^\s*#/', $line)) {
                continue;
            }

            if (preg_match('/^meta:\s*$/', $line)) {
                $section = 'meta';
                $current = null;
                continue;
            }

            if (preg_match('/^entries:\s*$/', $line)) {
                $section = 'entries';
                $current = null;
                continue;
            }

            if (preg_match('/^\s*-\s+path:\s*(.+)$/', $line, $m)) {
                if ($current !== null && $section === 'entries') {
                    $entries[] = $current;
                }
                $current = ['path' => $this->parseYamlScalar(trim($m[1]))];
                continue;
            }

            if (preg_match('/^\s{2,}([a-z_]+):\s*(.*)$/', $line, $m)) {
                $key = $m[1];
                $value = $this->parseYamlScalar(trim($m[2]));

                if ($section === 'meta') {
                    $meta[$key] = $value;
                } elseif ($section === 'entries' && $current !== null) {
                    if ($key === 'safe_to_edit') {
                        $current[$key] = $value === true || $value === 'true';
                    } else {
                        $current[$key] = $value;
                    }
                }
            }
        }

        if ($current !== null && $section === 'entries') {
            $entries[] = $current;
        }

        return ['meta' => $meta, 'entries' => $entries];
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
                fwrite(STDERR, "Failed to create directory: {$dir}\n");
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
  <link rel="stylesheet" href="styles.css?v=mission008" />
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
      const [missionsRes, orgRes] = await Promise.all([
        fetch('data/missions.json'),
        fetch('data/organization.json')
      ]);

      if (!missionsRes.ok || !orgRes.ok) {
        document.getElementById('strategy-line').textContent =
          'Failed to load compiled data. Run: php compiler/compile.php';
        return;
      }

      const missions = await missionsRes.json();
      const org = await orgRes.json();

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
CSS;

        if (!str_contains($css, 'Mission Control — Repository Compiler')) {
            $css .= $additions;
        }

        return $css;
    }
}

exit((new RepositoryCompiler())->run());
