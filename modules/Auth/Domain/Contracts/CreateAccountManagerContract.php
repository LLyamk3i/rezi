<?php

declare(strict_types=1);

namespace Modules\Auth\Domain\Contracts;

/**
 * @phpstan-import-type UserRecord from \Modules\Auth\Domain\Factories\UserFactory
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
