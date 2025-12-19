<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\WarehouseStock;
use Illuminate\Auth\Access\HandlesAuthorization;

class WarehouseStockPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:WarehouseStock');
    }

    public function view(AuthUser $authUser, WarehouseStock $warehouseStock): bool
    {
        return $authUser->can('View:WarehouseStock');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:WarehouseStock');
    }

    public function update(AuthUser $authUser, WarehouseStock $warehouseStock): bool
    {
        return $authUser->can('Update:WarehouseStock');
    }

    public function delete(AuthUser $authUser, WarehouseStock $warehouseStock): bool
    {
        return $authUser->can('Delete:WarehouseStock');
    }

    public function restore(AuthUser $authUser, WarehouseStock $warehouseStock): bool
    {
        return $authUser->can('Restore:WarehouseStock');
    }

    public function forceDelete(AuthUser $authUser, WarehouseStock $warehouseStock): bool
    {
        return $authUser->can('ForceDelete:WarehouseStock');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:WarehouseStock');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:WarehouseStock');
    }

    public function replicate(AuthUser $authUser, WarehouseStock $warehouseStock): bool
    {
        return $authUser->can('Replicate:WarehouseStock');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:WarehouseStock');
    }

}