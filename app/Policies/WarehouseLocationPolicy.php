<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\WarehouseLocation;
use Illuminate\Auth\Access\HandlesAuthorization;

class WarehouseLocationPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:WarehouseLocation');
    }

    public function view(AuthUser $authUser, WarehouseLocation $warehouseLocation): bool
    {
        return $authUser->can('View:WarehouseLocation');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:WarehouseLocation');
    }

    public function update(AuthUser $authUser, WarehouseLocation $warehouseLocation): bool
    {
        return $authUser->can('Update:WarehouseLocation');
    }

    public function delete(AuthUser $authUser, WarehouseLocation $warehouseLocation): bool
    {
        return $authUser->can('Delete:WarehouseLocation');
    }

    public function restore(AuthUser $authUser, WarehouseLocation $warehouseLocation): bool
    {
        return $authUser->can('Restore:WarehouseLocation');
    }

    public function forceDelete(AuthUser $authUser, WarehouseLocation $warehouseLocation): bool
    {
        return $authUser->can('ForceDelete:WarehouseLocation');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:WarehouseLocation');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:WarehouseLocation');
    }

    public function replicate(AuthUser $authUser, WarehouseLocation $warehouseLocation): bool
    {
        return $authUser->can('Replicate:WarehouseLocation');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:WarehouseLocation');
    }

}