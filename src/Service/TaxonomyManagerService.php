<?php

declare(strict_types=1);

namespace Vigihdev\WpPostType\Service;

use Vigihdev\WpPostType\Contracts\Service\TaxonomyManagerInterface;
use Vigihdev\WpPostType\Contracts\TaxonomyInterface;

/**
 * Service untuk handle Taxonomy Registration
 */
final class TaxonomyManagerService implements TaxonomyManagerInterface
{
    /** @var TaxonomyInterface[] */
    private array $items = [];

    public function __construct(iterable $taxonomies)
    {
        foreach ($taxonomies as $tx) {
            if ($tx instanceof TaxonomyInterface) {
                $this->items[] = $tx;
            }
        }
    }

    public function register(): void
    {
        foreach ($this->items as $tx) {
            register_taxonomy(
                $tx->getTaxonomyName(),
                $tx->getPostType(),
                $tx->getArgs()
            );
        }
    }
}
