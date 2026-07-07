<?php
declare(strict_types=1);

/**
 * Repository Intelligence Layer (Mission 010)
 *
 * Manifest compilation, context packages, dependency validation, and lookup.
 * Repository artifacts remain canonical; JSON outputs are disposable views.
 */

final class RepositoryIntelligence
{
    private string $root;

    /** @var list<array<string, mixed>> */
    private array $missions;

    /** @var array<string, mixed> */
    private array $organization;

    /** @var array<string, mixed>|null */
    private ?array $registry;

    /** @var list<array<string, mixed>> */
    private array $assets = [];

    /** @var array<string, array<string, mixed>> */
    private array $assetsById = [];

    /** @var array<string, array<string, mixed>> */
    private array $assetsByPath = [];

    public function __construct(
        string $root,
        array $missions,
        array $organization,
        ?array $registry
    ) {
        $this->root = $root;
        $this->missions = $missions;
        $this->organization = $organization;
        $this->registry = $registry;
        $this->indexAssets();
    }

    /** @return array<string, mixed> */
    public function compileManifest(?array $dependencyReport = null): array
    {
        $manifestSource = $this->loadYamlFile($this->root . '/system/manifest.yaml');
        $refs = is_array($manifestSource['references'] ?? null) ? $manifestSource['references'] : [];

        $completed = array_values(array_filter(
            $this->missions,
            static fn(array $m): bool => ($m['status_category'] ?? '') === 'complete'
        ));

        $active = array_values(array_filter(
            $this->missions,
            static fn(array $m): bool => in_array($m['status_category'] ?? '', ['in_progress', 'active'], true)
        ));

        $paused = array_values(array_filter(
            $this->missions,
            static fn(array $m): bool => ($m['status_category'] ?? '') === 'paused'
        ));

        $archVersion = $this->extractArchitectureVersion();
        $assetMeta = $this->registry['asset_registry'] ?? [];
        $depReport = $dependencyReport ?? $this->compileDependencyReport();
        $health = $this->computeRepositoryHealth($depReport);

        return [
            'compiled_at' => gmdate('c'),
            'source' => 'system/manifest.yaml',
            'subsystem' => 'repository-manifest',
            'ai_dos_version' => 'V2-in-progress',
            'references' => $refs,
            'current_mission' => $this->organization['current_mission'] ?? null,
            'next_mission' => $this->organization['next_mission'] ?? null,
            'completed_missions' => array_map(static fn(array $m): array => [
                'id' => $m['id'],
                'title' => $m['title'],
                'path' => $m['path'] ?? null,
            ], $completed),
            'active_missions' => array_map(static fn(array $m): array => [
                'id' => $m['id'],
                'title' => $m['title'],
                'status' => $m['status'] ?? null,
            ], $active),
            'paused_missions' => array_map(static fn(array $m): array => [
                'id' => $m['id'],
                'title' => $m['title'],
                'status' => $m['status'] ?? null,
            ], $paused),
            'architecture_version' => $archVersion,
            'compiler_version' => $this->organization['compiler_version'] ?? null,
            'asset_registry_version' => $assetMeta['version'] ?? null,
            'repository_health' => $health,
            'generated_artifact_versions' => $this->generatedArtifactVersions(),
        ];
    }

    /** @return array<string, mixed> */
    public function compileContextPackages(): array
    {
        $source = $this->loadYamlFile($this->root . '/system/context-packages.yaml');
        $packages = [];
        $raw = is_array($source['packages'] ?? null) ? $source['packages'] : [];

        foreach ($raw as $pkg) {
            if (!is_array($pkg) || !isset($pkg['id'])) {
                continue;
            }

            $files = $this->resolvePackageFiles($pkg);
            $packages[] = [
                'id' => (string) $pkg['id'],
                'name' => (string) ($pkg['name'] ?? $pkg['id']),
                'purpose' => (string) ($pkg['purpose'] ?? ''),
                'file_count' => count($files),
                'files' => $files,
            ];
        }

        return [
            'compiled_at' => gmdate('c'),
            'source' => 'system/context-packages.yaml',
            'package_count' => count($packages),
            'packages' => $packages,
        ];
    }

    /** @return array<string, mixed> */
    public function compileDependencyReport(): array
    {
        $issues = [];

        foreach ($this->assets as $asset) {
            $id = (string) ($asset['id'] ?? '');
            $path = $asset['path'] ?? null;
            $generated = !empty($asset['generated']);

            if (is_string($path) && $path !== '' && !$generated) {
                $full = $this->root . '/' . ltrim($path, '/');
                $isDir = str_ends_with($path, '/');
                if ($isDir) {
                    if (!is_dir(rtrim($full, '/'))) {
                        $issues[] = $this->issue('broken_path', $id, "Directory not found: {$path}");
                    }
                } elseif (!is_file($full)) {
                    $issues[] = $this->issue('broken_path', $id, "File not found: {$path}");
                }
            }

            foreach ($asset['depends_on'] ?? [] as $depId) {
                if (!isset($this->assetsById[$depId])) {
                    $issues[] = $this->issue('missing_asset', $id, "depends_on references unknown asset: {$depId}");
                }
            }

            foreach ($asset['outputs'] ?? [] as $outId) {
                if (!isset($this->assetsById[$outId])) {
                    $issues[] = $this->issue('missing_output', $id, "outputs references unknown asset: {$outId}");
                }
            }

            $url = $asset['public_url'] ?? null;
            if (is_string($url) && $url !== '' && !filter_var($url, FILTER_VALIDATE_URL)) {
                $issues[] = $this->issue('invalid_url', $id, "Malformed public URL: {$url}");
            }
        }

        $cycles = $this->detectCircularDependencies();
        foreach ($cycles as $cycle) {
            $issues[] = $this->issue('circular_dependency', $cycle[0], 'Cycle: ' . implode(' → ', $cycle));
        }

        $errorCount = count(array_filter($issues, static fn(array $i): bool => ($i['severity'] ?? '') === 'error'));
        $warnCount = count($issues) - $errorCount;

        return [
            'compiled_at' => gmdate('c'),
            'source' => 'system/assets.yaml',
            'asset_count' => count($this->assets),
            'issue_count' => count($issues),
            'error_count' => $errorCount,
            'warning_count' => $warnCount,
            'status' => $errorCount > 0 ? 'unhealthy' : ($warnCount > 0 ? 'warnings' : 'healthy'),
            'issues' => $issues,
            'repair_policy' => 'report_only',
        ];
    }

    /**
     * @param array<string, mixed> $manifest
     * @param array<string, mixed> $contextPackages
     * @param array<string, mixed> $dependencyReport
     * @param array<string, mixed>|null $decisions
     * @param array<string, mixed>|null $executionEngine
     * @return array<string, mixed>
     */
    public function compileRepository(
        array $manifest,
        array $contextPackages,
        array $dependencyReport,
        ?array $decisions = null,
        ?array $executionEngine = null
    ): array {
        $pathToPackages = $this->buildPathToPackagesIndex($contextPackages);
        $generatedBy = $this->buildReverseOutputsIndex();
        $dependedOnBy = $this->buildReverseDependsOnIndex();

        $byId = [];
        $byPath = [];
        $byType = [];

        foreach ($this->assets as $asset) {
            $id = (string) ($asset['id'] ?? '');
            $path = is_string($asset['path'] ?? null) ? (string) $asset['path'] : null;
            $record = $this->lookupRecord(
                $asset,
                $path !== null ? ($pathToPackages[$path] ?? []) : [],
                $generatedBy[$id] ?? [],
                $dependedOnBy[$id] ?? []
            );

            if ($id !== '') {
                $byId[$id] = $record;
            }
            if ($path !== null && $path !== '') {
                $byPath[$path] = $record;
            }
            $type = (string) ($asset['type'] ?? 'unknown');
            $byType[$type] ??= [];
            if ($id !== '') {
                $byType[$type][] = $id;
            }
        }

        return [
            'compiled_at' => gmdate('c'),
            'subsystem' => 'repository-intelligence',
            'capabilities' => [
                'repository_manifest',
                'context_packages',
                'dependency_validation',
                'repository_lookup',
                'decision_records',
                'execution_engine',
            ],
            'sources' => [
                'manifest' => 'system/manifest.yaml',
                'assets' => 'system/assets.yaml',
                'context_packages' => 'system/context-packages.yaml',
                'decisions' => 'decisions/*.md',
                'execution_engine' => 'system/execution-engine.yaml',
            ],
            'manifest_summary' => [
                'repository_health' => $manifest['repository_health'] ?? null,
                'compiler_version' => $manifest['compiler_version'] ?? null,
                'asset_registry_version' => $manifest['asset_registry_version'] ?? null,
            ],
            'dependency_status' => $dependencyReport['status'] ?? 'unknown',
            'context_package_count' => $contextPackages['package_count'] ?? 0,
            'decision_count' => $decisions['decision_count'] ?? 0,
            'execution_engine' => $executionEngine !== null ? [
                'source' => 'system/execution-engine.yaml',
                'compiled' => 'site/data/execution-engine.json',
                'status' => $executionEngine['status'] ?? null,
                'plan_count' => $executionEngine['execution_plans']['plan_count'] ?? 0,
                'role_count' => $executionEngine['worker_roles']['role_count'] ?? 0,
            ] : null,
            'lookup' => [
                'by_id' => $byId,
                'by_path' => $byPath,
                'by_type' => $byType,
            ],
            'query_support' => [
                'where_is' => 'lookup.by_path[path] or lookup.by_id[id] — path, type, status',
                'what_generates_this' => 'lookup.*.generated_by — assets whose outputs include this id',
                'what_depends_on_this' => 'lookup.*.depended_on_by — assets that list this id in depends_on',
                'who_created_this' => 'lookup.*.created_by — mission or actor from assets.yaml',
                'is_editable' => 'lookup.*.editable — safe_to_edit mirror',
                'public_url' => 'lookup.*.public_url — null when not public',
                'context_package_contains' => 'lookup.*.context_packages — package ids from context-packages.yaml',
            ],
            'execution_queries' => $executionEngine['query_answers'] ?? null,
            'query_examples' => $this->buildQueryExamples(),
        ];
    }

    private function indexAssets(): void
    {
        $raw = $this->registry['asset_registry']['assets'] ?? [];
        if (!is_array($raw)) {
            return;
        }

        $this->assets = $raw;
        foreach ($raw as $asset) {
            if (!is_array($asset)) {
                continue;
            }
            $id = (string) ($asset['id'] ?? '');
            if ($id !== '') {
                $this->assetsById[$id] = $asset;
            }
            $path = $asset['path'] ?? null;
            if (is_string($path) && $path !== '') {
                $this->assetsByPath[$path] = $asset;
            }
        }
    }

    /** @param array<string, mixed> $pkg @return list<string> */
    private function resolvePackageFiles(array $pkg): array
    {
        $files = [];
        foreach ($pkg['includes'] ?? [] as $inc) {
            if (!is_string($inc)) {
                continue;
            }
            $full = $this->root . '/' . ltrim($inc, '/');
            if (is_file($full)) {
                $files[] = $inc;
            }
        }

        foreach ($pkg['globs'] ?? [] as $glob) {
            if (!is_string($glob)) {
                continue;
            }
            $pattern = $this->root . '/' . ltrim($glob, '/');
            foreach (glob($pattern) ?: [] as $match) {
                if (is_file($match)) {
                    $files[] = ltrim(str_replace($this->root . '/', '', $match), '/');
                }
            }
        }

        sort($files);

        return array_values(array_unique($files));
    }

    /** @return list<list<string>> */
    private function detectCircularDependencies(): array
    {
        $cycles = [];
        $visited = [];
        $stack = [];

        $visit = function (string $id) use (&$visit, &$visited, &$stack, &$cycles): void {
            if (isset($stack[$id])) {
                $cycle = array_keys($stack);
                $start = array_search($id, $cycle, true);
                if ($start !== false) {
                    $cycles[] = array_merge(array_slice($cycle, $start), [$id]);
                }

                return;
            }
            if (isset($visited[$id])) {
                return;
            }

            $visited[$id] = true;
            $stack[$id] = true;
            $asset = $this->assetsById[$id] ?? null;
            if ($asset !== null) {
                foreach ($asset['depends_on'] ?? [] as $dep) {
                    if (is_string($dep) && $dep !== '') {
                        $visit($dep);
                    }
                }
            }
            unset($stack[$id]);
        };

        foreach (array_keys($this->assetsById) as $id) {
            $visit($id);
        }

        return $cycles;
    }

    /** @param array<string, mixed> $depReport @return array<string, mixed> */
    private function computeRepositoryHealth(array $depReport): array
    {
        return [
            'status' => $depReport['status'] ?? 'unknown',
            'issue_count' => $depReport['issue_count'] ?? 0,
            'error_count' => $depReport['error_count'] ?? 0,
            'warning_count' => $depReport['warning_count'] ?? 0,
            'asset_count' => $depReport['asset_count'] ?? count($this->assets),
        ];
    }

    /** @return array<string, mixed> */
    private function generatedArtifactVersions(): array
    {
        $paths = [
            'missions.json' => 'site/data/missions.json',
            'organization.json' => 'site/data/organization.json',
            'manifest.json' => 'site/data/manifest.json',
            'context-packages.json' => 'site/data/context-packages.json',
            'dependency-report.json' => 'site/data/dependency-report.json',
            'repository.json' => 'site/data/repository.json',
            'decisions.json' => 'site/data/decisions.json',
            'execution-engine.json' => 'site/data/execution-engine.json',
            'index.html' => 'site/index.html',
            'styles.css' => 'site/styles.css',
        ];

        $versions = [];
        foreach ($paths as $name => $rel) {
            $full = $this->root . '/' . $rel;
            if (is_file($full)) {
                $versions[$name] = [
                    'path' => $rel,
                    'modified_at' => gmdate('c', (int) filemtime($full)),
                    'bytes' => filesize($full),
                ];
            } else {
                $versions[$name] = ['path' => $rel, 'status' => 'not_yet_generated'];
            }
        }

        return $versions;
    }

    private function extractArchitectureVersion(): ?string
    {
        $file = $this->root . '/missions/007-design-v2/architecture.md';
        if (!is_file($file)) {
            return null;
        }

        $content = (string) file_get_contents($file);
        if (preg_match('/\*\*Version:\*\*\s*(.+)$/mi', $content, $m)) {
            return trim($m[1]);
        }

        return null;
    }

    /** @return array<string, mixed> */
    private function buildQueryExamples(): array
    {
        $compiler = $this->assetsById['compiler-compile-php'] ?? null;
        $orgJson = $this->assetsById['site-data-organization-json'] ?? null;

        $generatorsOfOrg = [];
        foreach ($this->assets as $asset) {
            foreach ($asset['outputs'] ?? [] as $out) {
                if ($out === 'site-data-organization-json') {
                    $generatorsOfOrg[] = $asset['id'];
                }
            }
        }

        return [
            'where_is_the_compiler' => $compiler !== null ? [
                'asset_id' => $compiler['id'],
                'path' => $compiler['path'],
                'public_url' => $compiler['public_url'] ?? null,
                'editable' => $compiler['editable'] ?? null,
            ] : ['status' => 'needs-verification'],
            'what_generates_organization_json' => [
                'asset_id' => 'site-data-organization-json',
                'generated_by' => $generatorsOfOrg,
                'path' => $orgJson['path'] ?? 'site/data/organization.json',
            ],
            'which_mission_created_asset_registry' => [
                'asset_id' => 'asset-registry',
                'answer' => 'Mission 009 (see assets.yaml created_by)',
            ],
            'what_depends_on_compiler' => $this->reverseDependsOn('compiler-compile-php'),
            'is_organization_json_editable' => [
                'asset_id' => 'site-data-organization-json',
                'editable' => $orgJson['editable'] ?? false,
                'note' => 'Regenerate via php compiler/compile.php',
            ],
            'public_url_mission_control' => [
                'asset_id' => 'site-index-html',
                'public_url' => ($this->assetsById['site-index-html'] ?? [])['public_url'] ?? null,
            ],
        ];
    }

    /** @return array<string, mixed> */
    private function reverseDependsOn(string $targetId): array
    {
        $dependents = [];
        foreach ($this->assets as $asset) {
            if (in_array($targetId, $asset['depends_on'] ?? [], true)) {
                $dependents[] = $asset['id'];
            }
        }

        return ['asset_id' => $targetId, 'depended_on_by' => $dependents];
    }

    /**
     * @param array<string, mixed> $asset
     * @param list<string> $contextPackages
     * @param list<string> $generatedBy
     * @param list<string> $dependedOnBy
     * @return array<string, mixed>
     */
    private function lookupRecord(
        array $asset,
        array $contextPackages = [],
        array $generatedBy = [],
        array $dependedOnBy = []
    ): array {
        $createdBy = $asset['created_by'] ?? $asset['created_by_mission'] ?? null;

        return [
            'id' => $asset['id'] ?? null,
            'type' => $asset['type'] ?? null,
            'name' => $asset['name'] ?? null,
            'path' => $asset['path'] ?? null,
            'public_url' => $asset['public_url'] ?? null,
            'editable' => $asset['editable'] ?? null,
            'generated' => $asset['generated'] ?? null,
            'status' => $asset['status'] ?? null,
            'created_by' => $createdBy,
            'depends_on' => $asset['depends_on'] ?? [],
            'depended_on_by' => $dependedOnBy,
            'outputs' => $asset['outputs'] ?? [],
            'generated_by' => $generatedBy,
            'context_packages' => $contextPackages,
        ];
    }

    /**
     * @param array<string, mixed> $contextPackages
     * @return array<string, list<string>>
     */
    private function buildPathToPackagesIndex(array $contextPackages): array
    {
        $index = [];
        foreach ($contextPackages['packages'] ?? [] as $pkg) {
            if (!is_array($pkg)) {
                continue;
            }
            $pkgId = (string) ($pkg['id'] ?? '');
            if ($pkgId === '') {
                continue;
            }
            foreach ($pkg['files'] ?? [] as $file) {
                if (!is_string($file) || $file === '') {
                    continue;
                }
                $index[$file] ??= [];
                if (!in_array($pkgId, $index[$file], true)) {
                    $index[$file][] = $pkgId;
                }
            }
        }

        return $index;
    }

    /** @return array<string, list<string>> */
    private function buildReverseOutputsIndex(): array
    {
        $index = [];
        foreach ($this->assets as $asset) {
            $generatorId = (string) ($asset['id'] ?? '');
            if ($generatorId === '') {
                continue;
            }
            foreach ($asset['outputs'] ?? [] as $outputId) {
                if (!is_string($outputId) || $outputId === '') {
                    continue;
                }
                $index[$outputId] ??= [];
                if (!in_array($generatorId, $index[$outputId], true)) {
                    $index[$outputId][] = $generatorId;
                }
            }
        }

        return $index;
    }

    /** @return array<string, list<string>> */
    private function buildReverseDependsOnIndex(): array
    {
        $index = [];
        foreach ($this->assets as $asset) {
            $dependentId = (string) ($asset['id'] ?? '');
            if ($dependentId === '') {
                continue;
            }
            foreach ($asset['depends_on'] ?? [] as $targetId) {
                if (!is_string($targetId) || $targetId === '') {
                    continue;
                }
                $index[$targetId] ??= [];
                if (!in_array($dependentId, $index[$targetId], true)) {
                    $index[$targetId][] = $dependentId;
                }
            }
        }

        return $index;
    }

  /** @return array<string, mixed> */
    private function issue(string $type, string $assetId, string $message): array
    {
        $severity = in_array($type, ['broken_path', 'missing_asset', 'missing_output', 'circular_dependency'], true)
            ? 'error'
            : 'warning';

        return [
            'type' => $type,
            'severity' => $severity,
            'asset_id' => $assetId,
            'message' => $message,
        ];
    }

    /** @return array<string, mixed> */
    private function loadYamlFile(string $path): array
    {
        if (!is_file($path)) {
            return [];
        }

        $content = (string) file_get_contents($path);
        if (function_exists('yaml_parse')) {
            $parsed = yaml_parse($content);
            if (is_array($parsed)) {
                return $parsed;
            }
        }

        return [];
    }
}
