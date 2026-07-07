<?php
declare(strict_types=1);

/**
 * Decision Records compiler (Mission 011)
 *
 * Reads decisions/*.md and emits site/data/decisions.json (disposable view).
 */

final class DecisionRecords
{
    private string $root;

    public function __construct(string $root)
    {
        $this->root = $root;
    }

    /** @return array<string, mixed> */
    public function compile(): array
    {
        $decisions = [];
        $pattern = $this->root . '/decisions/*.md';

        foreach (glob($pattern) ?: [] as $file) {
            $parsed = $this->parseDecisionFile($file);
            if ($parsed !== null) {
                $decisions[] = $parsed;
            }
        }

        usort($decisions, static fn(array $a, array $b): int => strcmp((string) $a['id'], (string) $b['id']));

        return [
            'compiled_at' => gmdate('c'),
            'source' => 'decisions/*.md',
            'decision_count' => count($decisions),
            'decisions' => $decisions,
        ];
    }

    /** @return array<string, mixed>|null */
    private function parseDecisionFile(string $path): ?array
    {
        $content = (string) file_get_contents($path);
        $basename = basename($path, '.md');

        if (!preg_match('/^(D\d{3})-/i', $basename, $m)) {
            return null;
        }

        $id = strtoupper($m[1]);
        $title = $this->extractTitle($content) ?? $basename;
        $status = $this->extractField($content, 'Status') ?? 'needs-verification';
        $related = $this->extractRelatedMissions($content);

        return [
            'id' => $id,
            'slug' => $basename,
            'title' => $title,
            'status' => $status,
            'path' => 'decisions/' . basename($path),
            'context' => $this->extractSection($content, 'Context'),
            'decision' => $this->extractSection($content, 'Decision'),
            'alternatives' => $this->extractSection($content, 'Alternatives considered'),
            'why_chosen' => $this->extractSection($content, 'Why chosen'),
            'evidence' => $this->extractSection($content, 'Evidence'),
            'related_missions' => $related,
        ];
    }

    private function extractTitle(string $content): ?string
    {
        if (preg_match('/^#\s+Decision\s+D\d{3}:\s*(.+)$/mi', $content, $m)) {
            return trim($m[1]);
        }

        return null;
    }

    private function extractField(string $content, string $field): ?string
    {
        if (preg_match('/^\*\*' . preg_quote($field, '/') . ':\*\*\s*(.+)$/mi', $content, $m)) {
            return trim($m[1]);
        }

        return null;
    }

    /** @return list<string> */
    private function extractRelatedMissions(string $content): array
    {
        $field = $this->extractField($content, 'Related missions');
        if ($field === null || $field === '') {
            return [];
        }

        preg_match_all('/Mission\s+(\d{3})/i', $field, $matches);

        return array_values(array_unique($matches[1] ?? []));
    }

    private function extractSection(string $content, string $heading): ?string
    {
        $pattern = '/## ' . preg_quote($heading, '/') . '\s*\n+([\s\S]*?)(?=\n## |\z)/';
        if (!preg_match($pattern, $content, $m)) {
            return null;
        }

        $text = trim($m[1]);

        return $text !== '' ? $text : null;
    }
}
