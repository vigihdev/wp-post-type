<?php

declare(strict_types=1);

namespace Vigihdev\WpPostType\Contracts;

/**
 * Taxonomy Interface
 */
interface TaxonomyInterface
{

    public function getLabel(): string;
    public function getHierarchical(): bool;
    public function getPublic(): bool;
    public function getShowUi(): bool;
    public function getShowAdminColumn(): bool;
    public function getShowInRest(): bool;
    public function getRewrite(): array;

    public function getPostType(): string;
    public function getTaxonomyName(): string;
    public function getArgs(): array;
}
