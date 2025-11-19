<?php

declare(strict_types=1);

namespace Vigihdev\WpPostType\DTOs;

use Vigihdev\WpPostType\Contracts\ArrayAbleDtoInterface;
use Vigihdev\WpPostType\Contracts\PostTypeArgsInterface;

/**
 * DTO untuk Post Type Arguments
 */
final class PostTypeArgsDto implements ArrayAbleDtoInterface, PostTypeArgsInterface
{

    public function __construct(
        private array $labels = [],
        private bool $public = true,
        private bool $publiclyQueryable = true,
        private bool $showUi = true,
        private bool $showInMenu = true,
        private bool $queryVar = true,
        private array|string $rewrite = ['slug' => 'post'],
        private string $capabilityType = 'post',
        private bool $hasArchive = true,
        private bool $hierarchical = false,
        private ?int $menuPosition = null,
        private array $supports = ['title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments'],
        private string $menuIcon = 'dashicons-admin-post',
        private bool $showInRest = true,
        private string $restBase = '',
        private bool $excludeFromSearch = false,
        private bool $showInNavMenus = true,
        private bool $showInAdminBar = true,
        private ?string $description = null,
        private array $taxonomies = [],
        private bool $canExport = true,
        private bool $deleteWithUser = false
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
        $this->labels = $labels;
        return $this;
    }

    /**
     * Set rewrite slug
     */
    public function withSlug(string $slug): self
    {
        $this->rewrite = ['slug' => $slug];
        return $this;
    }

    /**
     * Set supports
     */
    public function withSupports(array $supports): self
    {
        $this->supports = $supports;
        return $this;
    }

    /**
     * Set menu icon
     */
    public function withMenuIcon(string $icon): self
    {
        $this->menuIcon = $icon;
        return $this;
    }

    /**
     * Set menu position
     */
    public function withMenuPosition(int $position): self
    {
        $this->menuPosition = $position;
        return $this;
    }
}
