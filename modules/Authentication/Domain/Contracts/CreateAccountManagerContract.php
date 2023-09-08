<?php

declare(strict_types=1);

namespace Modules\Authentication\Domain\Contracts;

/**
 * @phpstan-import-type UserRecord from \Modules\Authentication\Domain\Factories\UserFactory
 */
interface CreateAccountManagerContract
{
    /**
     * @phpstan-param UserRecord $attributes
     */
    public function owner(array $attributes): bool;

    /**
     * @phpstan-param UserRecord $attributes
     */
    public function admin(array $attributes): bool;

    /**
     * @phpstan-param UserRecord $attributes
     */
    public function provider(array $attributes): bool;
}
