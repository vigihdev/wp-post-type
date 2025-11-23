<?php

declare(strict_types=1);

namespace Vigihdev\WpPostType\Validators;

use Vigihdev\WpPostType\DTOs\TaxonomyDto;
use InvalidArgumentException;

final class TaxonomyValidator
{

    public function validate(TaxonomyDto $dto): void
    {
        // Validate taxonomy name (max 32 chars, lowercase, underscore only)
        if (strlen($dto->getTaxonomyName()) > 32) {
            throw new InvalidArgumentException(
                "Taxonomy name must be 32 characters or less"
            );
        }

        if (!preg_match('/^[a-z0-9_]+$/', $dto->getTaxonomyName())) {
            throw new InvalidArgumentException(
                "Taxonomy name must contain only lowercase letters, numbers, and underscores"
            );
        }

        // Validate rewrite slug
        $args = $dto->getArgs();
        if (isset($args['rewrite']['slug'])) {
            $slug = $args['rewrite']['slug'];
            if (!preg_match('/^[a-z0-9-]+$/', $slug)) {
                throw new InvalidArgumentException(
                    "Rewrite slug should use lowercase letters, numbers, and dashes only"
                );
            }
        }
    }
}
