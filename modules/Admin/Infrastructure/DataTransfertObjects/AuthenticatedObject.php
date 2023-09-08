<?php

declare(strict_types=1);

namespace Modules\Admin\Infrastructure\DataTransfertObjects;

use Modules\Authentication\Domain\Enums\Roles;

final class AuthenticatedObject
{
    private string $key = 'auth.%s.';

    public static function make(): self
    {
        return new self();
    }

    public function key(string $id, string $suffix): string
    {
        return sprintf($this->key . $suffix, $id);
    }

    public function role(string $id): Roles
    {
        $role = session()->get(key: $this->key(id: $id, suffix: 'role'));
        if ($role instanceof Roles) {
            return $role;
        }

        throw new \RuntimeException(message: 'Role must exist on authenticated user.', code: 1);
    }
}
