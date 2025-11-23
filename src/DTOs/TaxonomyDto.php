<?php

declare(strict_types=1);

namespace Vigihdev\WpPostType\DTOs;

use Vigihdev\WpPostType\Contracts\ArrayAbleInterface;
use Vigihdev\WpPostType\Contracts\TaxonomyInterface;

final class TaxonomyDto implements ArrayAbleInterface, TaxonomyInterface
{

    private array $processedLabels;

    public function __construct(
        private readonly string $taxonomyName,
        private readonly string|array $postType,
        private readonly string $label,
        private readonly bool $hierarchical = true,
        private readonly bool $public = true,
        private readonly bool $showUi = true,
        private readonly bool $showAdminColumn = true,
        private readonly bool $showInRest = true,
        private readonly array $rewrite = [],
        private array $labels = []
    ) {
        $this->processedLabels = $this->buildLabels($labels);
    }

    private function buildLabels(array $customLabels = []): array
    {
        $singularName = $customLabels['singular_name'] ?? $this->label;
        $pluralName = $customLabels['name'] ?? $this->label;

        $defaultLabels = [
            'name' => $pluralName,
            'singular_name' => $singularName,
            'menu_name' => $customLabels['menu_name'] ?? $pluralName,
            'all_items' => $customLabels['all_items'] ?? "Semua {$pluralName}",
            'edit_item' => $customLabels['edit_item'] ?? "Edit {$singularName}",
            'view_item' => $customLabels['view_item'] ?? "Lihat {$singularName}",
            'update_item' => $customLabels['update_item'] ?? "Update {$singularName}",
            'add_new_item' => $customLabels['add_new_item'] ?? "Tambah {$singularName} Baru",
            'new_item_name' => $customLabels['new_item_name'] ?? "Nama {$singularName} Baru",
            'search_items' => $customLabels['search_items'] ?? "Cari {$pluralName}",
            'popular_items' => $customLabels['popular_items'] ?? "{$pluralName} Populer",
            'separate_items_with_commas' => $customLabels['separate_items_with_commas'] ?? "Pisahkan {$pluralName} dengan koma",
            'add_or_remove_items' => $customLabels['add_or_remove_items'] ?? "Tambah atau Hapus {$pluralName}",
            'choose_from_most_used' => $customLabels['choose_from_most_used'] ?? "Pilih dari yang paling sering digunakan",
            'not_found' => $customLabels['not_found'] ?? "Tidak ada {$pluralName} ditemukan"
        ];

        return array_merge($defaultLabels, $customLabels);
    }

    public function getPostType(): string
    {
        return $this->postType;
    }

    public function getTaxonomyName(): string
    {
        return $this->taxonomyName;
    }

    public function getLabel(): string
    {
        return $this->label;
    }

    public function getHierarchical(): bool
    {
        return $this->hierarchical;
    }

    public function getPublic(): bool
    {
        return $this->public;
    }

    public function getShowUi(): bool
    {
        return $this->showUi;
    }

    public function getShowAdminColumn(): bool
    {
        return $this->showAdminColumn;
    }

    public function getShowInRest(): bool
    {
        return $this->showInRest;
    }

    public function getRewrite(): array
    {
        return $this->rewrite;
    }

    public function getArgs(): array
    {
        return $this->toArray();
    }

    public function toArray(): array
    {
        return [
            'label' => $this->label,
            'hierarchical' => $this->hierarchical,
            'public' => $this->public,
            'show_ui' => $this->showUi,
            'show_admin_column' => $this->showAdminColumn,
            'show_in_rest' => $this->showInRest,
            'rewrite' => $this->rewrite,
            'labels' => $this->processedLabels
        ];
    }
}
