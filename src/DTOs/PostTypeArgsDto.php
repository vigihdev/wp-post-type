<?php

declare(strict_types=1);

namespace Vigihdev\WpPostType\DTOs;

use Vigihdev\WpPostType\Contracts\ArrayAbleDtoInterface;

/**
 * DTO untuk Post Type Arguments
 */
final class PostTypeArgsDto implements ArrayAbleDtoInterface
{

    public function __construct(
        private readonly array $labels = [],
        private readonly bool $public = true,
        private readonly bool $publiclyQueryable = true,
        private readonly bool $showUi = true,
        private readonly bool $showInMenu = true,
        private readonly bool $queryVar = true,
        private readonly array|string $rewrite = ['slug' => 'post'],
        private readonly string $capabilityType = 'post',
        private readonly bool $hasArchive = true,
        private readonly bool $hierarchical = false,
        private readonly ?int $menuPosition = null,
        private readonly array $supports = ['title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments'],
        private readonly string $menuIcon = 'dashicons-admin-post',
        private readonly bool $showInRest = true,
        private readonly string $restBase = '',
        private readonly bool $excludeFromSearch = false,
        private readonly bool $showInNavMenus = true,
        private readonly bool $showInAdminBar = true,
        private readonly ?string $description = null,
        private readonly array $taxonomies = [],
        private readonly bool $canExport = true,
        private readonly bool $deleteWithUser = false
    ) {}

    /**
     * Convert DTO to array
     */
    public function toArray(): array
    {
        $args = [
            'labels'              => $this->labels,
            'public'              => $this->public,
            'publicly_queryable'  => $this->publiclyQueryable,
            'show_ui'             => $this->showUi,
            'show_in_menu'        => $this->showInMenu,
            'query_var'           => $this->queryVar,
            'rewrite'             => $this->rewrite,
            'capability_type'     => $this->capabilityType,
            'has_archive'         => $this->hasArchive,
            'hierarchical'        => $this->hierarchical,
            'menu_position'       => $this->menuPosition,
            'supports'            => $this->supports,
            'menu_icon'           => $this->menuIcon,
            'show_in_rest'        => $this->showInRest,
            'exclude_from_search' => $this->excludeFromSearch,
            'show_in_nav_menus'   => $this->showInNavMenus,
            'show_in_admin_bar'   => $this->showInAdminBar,
            'can_export'          => $this->canExport,
            'delete_with_user'    => $this->deleteWithUser,
        ];

        // Add optional fields
        if (!empty($this->restBase)) {
            $args['rest_base'] = $this->restBase;
        }

        if ($this->description !== null) {
            $args['description'] = $this->description;
        }

        if (!empty($this->taxonomies)) {
            $args['taxonomies'] = $this->taxonomies;
        }

        return array_filter($args, fn($value) => $value !== null);
    }

    /**
     * Create DTO from array
     */
    public static function fromArray(array $data): static
    {
        return new self(
            labels: $data['labels'] ?? [],
            public: $data['public'] ?? true,
            publiclyQueryable: $data['publicly_queryable'] ?? true,
            showUi: $data['show_ui'] ?? true,
            showInMenu: $data['show_in_menu'] ?? true,
            queryVar: $data['query_var'] ?? true,
            rewrite: $data['rewrite'] ?? ['slug' => 'post'],
            capabilityType: $data['capability_type'] ?? 'post',
            hasArchive: $data['has_archive'] ?? true,
            hierarchical: $data['hierarchical'] ?? false,
            menuPosition: $data['menu_position'] ?? null,
            supports: $data['supports'] ?? [
                'title',
                'editor',
                'author',
                'thumbnail',
                'excerpt',
                'comments'
            ],
            menuIcon: $data['menu_icon'] ?? 'dashicons-admin-post',
            showInRest: $data['show_in_rest'] ?? true,
            restBase: $data['rest_base'] ?? '',
            excludeFromSearch: $data['exclude_from_search'] ?? false,
            showInNavMenus: $data['show_in_nav_menus'] ?? true,
            showInAdminBar: $data['show_in_admin_bar'] ?? true,
            description: $data['description'] ?? null,
            taxonomies: $data['taxonomies'] ?? [],
            canExport: $data['can_export'] ?? true,
            deleteWithUser: $data['delete_with_user'] ?? false
        );
    }


    /**
     * Set labels
     */
    public function withLabels(array $labels): self
    {
        $clone = clone $this;
        $clone->labels = $labels;
        return $clone;
    }

    /**
     * Set rewrite slug
     */
    public function withSlug(string $slug): self
    {
        $clone = clone $this;
        $clone->rewrite = ['slug' => $slug];
        return $clone;
    }

    /**
     * Set supports
     */
    public function withSupports(array $supports): self
    {
        $clone = clone $this;
        $clone->supports = $supports;
        return $clone;
    }

    /**
     * Set menu icon
     */
    public function withMenuIcon(string $icon): self
    {
        $clone = clone $this;
        $clone->menuIcon = $icon;
        return $clone;
    }

    /**
     * Set menu position
     */
    public function withMenuPosition(int $position): self
    {
        $clone = clone $this;
        $clone->menuPosition = $position;
        return $clone;
    }
}
