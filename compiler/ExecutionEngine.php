<?php
declare(strict_types=1);

/**
 * Execution Engine compiler (Mission 012)
 *
 * Reads system/execution-engine.yaml, worker-roles.yaml, and execution-plans/
 * Emits site/data/execution-engine.json (disposable view).
 */

final class ExecutionEngine
{
    private string $root;

    public function __construct(string $root)
    {
        $this->root = $root;
    }

    /**
     * @param array<string, mixed>|null $contextPackages compiled context-packages.json shape
     * @param array<string, mixed> $organization
     * @return array<string, mixed>
     */
    public function compile(?array $contextPackages, array $organization): array
    {
        $engine = $this->loadYaml($this->root . '/system/execution-engine.yaml');
        $roles = $this->loadYaml($this->root . '/system/worker-roles.yaml');
        $plans = $this->loadExecutionPlans();

        $latestPlan = $this->selectLatestPlan($plans);
        $nextMission = $organization['next_mission'] ?? null;

        return [
            'compiled_at' => gmdate('c'),
            'source' => 'system/execution-engine.yaml',
            'subsystem' => 'execution-engine',
            'status' => (string) ($engine['meta']['status'] ?? 'unknown'),
            'version' => (int) ($engine['meta']['version'] ?? 1),
            'philosophy' => $engine['philosophy'] ?? [],
            'capabilities' => $engine['capabilities'] ?? [],
            'work_unit_types' => $engine['work_unit_types'] ?? [],
            'execution_flow' => $engine['execution_flow'] ?? [],
            'context_routing' => $engine['context_routing'] ?? [],
            'explicit_non_goals' => $engine['explicit_non_goals'] ?? [],
            'worker_roles' => [
                'source' => 'system/worker-roles.yaml',
                'role_count' => count($roles['roles'] ?? []),
                'roles' => $roles['roles'] ?? [],
                'tool_summary' => $roles['tool_summary'] ?? [],
            ],
            'context_packages_available' => [
                'source' => 'system/context-packages.yaml',
                'package_count' => $contextPackages['package_count'] ?? 0,
                'packages' => array_map(static function (array $pkg): array {
                    return [
                        'id' => $pkg['id'] ?? null,
                        'name' => $pkg['name'] ?? null,
                        'purpose' => $pkg['purpose'] ?? null,
                        'file_count' => $pkg['file_count'] ?? 0,
                    ];
                }, is_array($contextPackages['packages'] ?? null) ? $contextPackages['packages'] : []),
            ],
            'execution_plans' => [
                'source' => 'system/execution-plans/',
                'plan_count' => count($plans),
                'plans' => $plans,
            ],
            'latest_execution_plan' => $latestPlan,
            'next_product_mission' => $this->buildNextProductMission($nextMission, $plans),
            'build_status' => $this->buildStatus($engine, $plans),
            'routing_guide' => $this->buildRoutingGuide($roles),
            'query_answers' => $this->buildQueryAnswers($engine, $roles, $plans, $contextPackages),
        ];
    }

    /** @return array<string, mixed> */
    private function buildStatus(array $engine, array $plans): array
    {
        return [
            'execution_engine' => (string) ($engine['meta']['status'] ?? 'unknown'),
            'autonomous_execution' => false,
            'multi_agent_execution_occurred' => false,
            'worker_history_available' => false,
            'execution_plan_count' => count($plans),
            'note' => 'Plans are recommendations only. No autonomous runs.',
        ];
    }

    /**
     * @param array<string, mixed> $roles
     * @return array<string, mixed>
     */
    private function buildRoutingGuide(array $roles): array
    {
        $toolSummary = is_array($roles['tool_summary'] ?? null) ? $roles['tool_summary'] : [];

        return [
            'cursor' => $toolSummary['cursor'] ?? null,
            'claude_code' => $toolSummary['claude-code'] ?? null,
            'rule' => 'Assign work units to roles first; map roles to tools via worker-roles.yaml.',
        ];
    }

    /**
     * @param array<string, mixed> $engine
     * @param array<string, mixed> $roles
     * @param list<array<string, mixed>> $plans
     * @param array<string, mixed>|null $contextPackages
     * @return array<string, mixed>
     */
    private function buildQueryAnswers(
        array $engine,
        array $roles,
        array $plans,
        ?array $contextPackages
    ): array {
        $uiRole = null;
        foreach ($roles['roles'] ?? [] as $role) {
            if (is_array($role) && ($role['id'] ?? '') === 'frontend-builder') {
                $uiRole = $role;
                break;
            }
        }

        $planIds = array_values(array_filter(array_map(
            static fn(array $p): ?string => is_string($p['id'] ?? null) ? $p['id'] : null,
            $plans
        )));

        return [
            'how_does_ai_dos_execute_work' => [
                'answer' => 'Execution Engine produces plans in system/execution-plans/. Operator approves; workers execute manually.',
                'source' => 'system/execution-engine.yaml#execution_flow',
            ],
            'what_worker_should_build_ui' => [
                'answer' => $uiRole !== null
                    ? ($uiRole['name'] ?? 'Frontend Builder') . ' — practical tool: cursor (preferred)'
                    : 'frontend-builder role',
                'source' => 'system/worker-roles.yaml',
            ],
            'which_context_package_for_ui' => [
                'answer' => $engine['context_routing']['ui']['context_packages'] ?? ['website-context'],
                'source' => 'system/execution-engine.yaml#context_routing',
            ],
            'what_execution_plans_exist' => [
                'answer' => $planIds,
                'source' => 'system/execution-plans/',
            ],
            'context_package_count' => $contextPackages['package_count'] ?? 0,
        ];
    }

    /** @return list<array<string, mixed>> */
    private function loadExecutionPlans(): array
    {
        $plans = [];
        $pattern = $this->root . '/system/execution-plans/*.{yaml,yml}';

        foreach (glob($pattern, GLOB_BRACE) ?: [] as $file) {
            $parsed = $this->loadYaml($file);
            if ($parsed === []) {
                continue;
            }
            $parsed['source_path'] = 'system/execution-plans/' . basename($file);
            $plans[] = $parsed;
        }

        usort($plans, static fn(array $a, array $b): int => strcmp(
            (string) ($a['id'] ?? ''),
            (string) ($b['id'] ?? '')
        ));

        return $plans;
    }

    /**
     * @param list<array<string, mixed>> $plans
     * @return array<string, mixed>|null
     */
    private function selectLatestPlan(array $plans): ?array
    {
        foreach ($plans as $plan) {
            if (($plan['status'] ?? '') === 'proposed') {
                return $plan;
            }
        }

        return $plans[0] ?? null;
    }

    /**
     * @param mixed $nextMission
     * @param list<array<string, mixed>> $plans
     * @return array<string, mixed>|null
     */
    private function buildNextProductMission($nextMission, array $plans): ?array
    {
        foreach ($plans as $plan) {
            if (($plan['id'] ?? '') === 'mission-013-first-external-product') {
                return [
                    'mission_id' => '013',
                    'title' => $plan['title'] ?? 'Build the First External Product Using AI-DOS',
                    'plan_id' => $plan['id'],
                    'plan_path' => $plan['source_path'] ?? null,
                    'status' => $plan['status'] ?? 'proposed',
                    'work_unit_count' => count($plan['work_units'] ?? []),
                    'backlog_next' => is_array($nextMission) ? $nextMission : null,
                ];
            }
        }

        if (!is_array($nextMission)) {
            return null;
        }

        return [
            'mission_id' => $nextMission['id'] ?? null,
            'title' => $nextMission['title'] ?? null,
            'source' => $nextMission['source'] ?? 'tasks/Backlog.md',
        ];
    }

    /** @return array<string, mixed> */
    private function loadYaml(string $path): array
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
