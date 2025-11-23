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
    private array $taxonomies = [];

    public function __construct(iterable $taxonomies)
    {
        foreach ($taxonomies as $tx) {
            if ($tx instanceof TaxonomyInterface) {
                $this->taxonomies[] = $tx;
            }
        }
    }

    public function register(): void
    {
        foreach ($this->taxonomies as $tx) {
            register_taxonomy(
                $tx->getTaxonomyName(),
                $tx->getPostType(),
                $tx->getArgs()
            );
        }
    }
}
