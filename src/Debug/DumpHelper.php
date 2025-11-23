<?php

declare(strict_types=1);

namespace Vigihdev\WpPostType\Debug;

use Vigihdev\WpPostType\Contracts\TaxonomyInterface;
use Vigihdev\WpPostType\Contracts\PostTypeBuilderInterface;

final class DumpHelper
{
    public static function dumpTaxonomy(TaxonomyInterface $taxonomy): array
    {
        return [
            'taxonomy_name' => $taxonomy->getTaxonomyName(),
            'post_type' => $taxonomy->getPostType(),
            'args' => $taxonomy->getArgs(),
            'labels_count' => count($taxonomy->getArgs()['labels']),
            'is_hierarchical' => $taxonomy->getArgs()['hierarchical'],
        ];
    }

    public static function dumpPostType(PostTypeBuilderInterface $builder): array
    {
        $config = $builder->build()->toArray();

        return [
            'post_type' => $config['post_type'] ?? 'N/A',
            'supports' => $config['supports'] ?? [],
            'labels_count' => count($config['labels'] ?? []),
            'public' => $config['public'] ?? false,
            'has_archive' => $config['has_archive'] ?? false,
        ];
    }

    public static function prettyDump(mixed $data, string $title = ''): void
    {
        echo "<pre style='background: #1e1e1e; color: #dcdcdc; padding: 15px; border-radius: 5px;'>";
        if ($title) {
            echo "<strong style='color: #4ec9b0;'>📦 {$title}</strong>\n\n";
        }
        print_r($data);
        echo "</pre>";
    }
}
