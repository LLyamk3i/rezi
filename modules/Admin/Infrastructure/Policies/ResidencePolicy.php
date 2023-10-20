<?php

declare(strict_types=1);

namespace Modules\Admin\Infrastructure\Policies;

use Illuminate\Contracts\Auth\Authenticatable;
use Modules\Residence\Infrastructure\Models\Residence;

final class ResidencePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(Authenticatable $user, Residence $residence): bool
    {
        return $user->getAuthIdentifier() === $residence->getAttribute(key: 'user_id');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(Authenticatable $user, Residence $residence): bool
    {
        return $user->getAuthIdentifier() === $residence->getAttribute(key: 'user_id');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(Authenticatable $user, Residence $residence): bool
    {
        return $user->getAuthIdentifier() === $residence->getAttribute(key: 'user_id');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(): bool
    {
        return false;
    }
}
