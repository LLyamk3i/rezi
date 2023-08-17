<?php

declare(strict_types=1);

namespace Modules\Admin\Infrastructure\Policies;

use Modules\Admin\Infrastructure\Models\Admin;
use Modules\Residence\Infrastructure\Models\Residence;

final class ResidencePolicy
{
    /**
     * Determine whether the admin can view any models.
     */
    public function viewAny(Admin $admin): bool
    {
        return true;
    }

    /**
     * Determine whether the admin can view the model.
     */
    public function view(Admin $admin, Residence $residence): bool
    {
        return $admin->getAttribute(key: 'id') === $residence->getAttribute(key: 'user_id');
    }

    /**
     * Determine whether the admin can create models.
     */
    public function create(Admin $admin): bool
    {
        return true;
    }

    /**
     * Determine whether the admin can update the model.
     */
    public function update(Admin $admin, Residence $residence): bool
    {
        return $admin->getAttribute(key: 'id') === $residence->getAttribute(key: 'user_id');
    }

    /**
     * Determine whether the admin can delete the model.
     */
    public function delete(Admin $admin, Residence $residence): bool
    {
        return $admin->getAttribute(key: 'id') === $residence->getAttribute(key: 'user_id');
    }

    /**
     * Determine whether the admin can restore the model.
     */
    public function restore(Admin $admin, Residence $residence): bool
    {
        return false;
    }

    /**
     * Determine whether the admin can permanently delete the model.
     */
    public function forceDelete(Admin $admin, Residence $residence): bool
    {
        return false;
    }
}
