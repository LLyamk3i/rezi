<?php

declare(strict_types=1);

namespace Modules\Auth\Domain\Contracts;

interface CreateAccountManagerContract
{
    /**
     * @param array{id?:\Modules\Shared\Domain\ValueObjects\Ulid,name:string,surname:string,email:string,password:string} $attributes
     */
    public function owner(array $attributes): bool;

    /**
     * @param array{id?:\Modules\Shared\Domain\ValueObjects\Ulid,name:string,surname:string,email:string,password:string} $attributes
     */
    public function admin(array $attributes): bool;

    /**
     * @param array{id?:\Modules\Shared\Domain\ValueObjects\Ulid,name:string,surname:string,email:string,password:string} $attributes
     */
    public function provider(array $attributes): bool;
}
