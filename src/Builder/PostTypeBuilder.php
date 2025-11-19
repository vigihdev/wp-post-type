<?php

declare(strict_types=1);

namespace Vigihdev\WpPostType\Builder;

use Vigihdev\WpPostType\Contracts\PostTypeBuilderInterface;
use Vigihdev\WpPostType\DTOs\PostTypeArgsDto;
use Vigihdev\WpPostType\DTOs\PostTypeLabelsDto;

final class PostTypeBuilder implements PostTypeBuilderInterface
{
    private array $config = [];

    public function __construct(private string $postType)
    {
        $this->config['rewrite'] = ['slug' => $postType];
    }

    public function withLabels(array $labels): self
    {
        $this->config['labels'] = $labels;
        return $this;
    }

    public function withAutoLabels(string $singular, string $plural): self
    {
        $this->config['labels'] = PostTypeLabelsDto::create($singular, $plural)->toArray();
        return $this;
    }

    public function withDescription(string $description): self
    {
        $this->config['description'] = $description;
        return $this;
    }

    public function withSupports(array $supports): self
    {
        $this->config['supports'] = $supports;
        return $this;
    }

    public function withTaxonomies(array $taxonomies): self
    {
        $this->config['taxonomies'] = $taxonomies;
        return $this;
    }

    public function withRewrite(array $rewrite): self
    {
        $this->config['rewrite'] = $rewrite;
        return $this;
    }

    public function withSlug(string $slug): self
    {
        $this->config['rewrite'] = ['slug' => $slug];
        return $this;
    }

    public function withMenuPosition(int $position): self
    {
        $this->config['menu_position'] = $position;
        return $this;
    }

    public function withMenuIcon(string $icon): self
    {
        $this->config['menu_icon'] = $icon;
        return $this;
    }

    public function public(bool $public = true): self
    {
        $this->config['public'] = $public;
        return $this;
    }

    public function showInRest(bool $show = true): self
    {
        $this->config['show_in_rest'] = $show;
        return $this;
    }

    /**
     *
     * @param bool $hasArchive
     * @return PostTypeBuilder
     */
    public function hasArchive(bool $hasArchive = true): self
    {
        $this->config['has_archive'] = $hasArchive;
        return $this;
    }

    /**
     *
     * @return PostTypeArgsDto
     */
    public function build(): PostTypeArgsDto
    {
        return PostTypeArgsDto::fromArray($this->config);
    }
}
