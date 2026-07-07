<?php
declare(strict_types=1);

/**
 * Portfolio registry compiler (Mission 014)
 * Reads system/portfolio.yaml → site/data/portfolio.json
 */

final class PortfolioRegistry
{
    private string $root;

    public function __construct(string $root)
    {
        $this->root = $root;
    }

    /** @return array<string, mixed> */
    public function compile(): array
    {
        $source = $this->loadYaml($this->root . '/system/portfolio.yaml');
        $projects = is_array($source['projects'] ?? null) ? $source['projects'] : [];

        return [
            'compiled_at' => gmdate('c'),
            'source' => 'system/portfolio.yaml',
            'project_count' => count($projects),
            'projects' => $projects,
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
