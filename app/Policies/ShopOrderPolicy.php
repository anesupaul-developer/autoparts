<?php

namespace App\Policies;

use App\Models\ShopOrder;
use App\Models\User;

class ShopOrderPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasAnyPermission(['can_edit_shop_order']);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, ShopOrder $shopOrder): bool
    {
        return $user->hasAnyPermission(['can_edit_shop_order']);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasAnyPermission(['can_edit_shop_order']);;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, ShopOrder $shopOrder): bool
    {
        return $user->hasAnyPermission(['can_edit_shop_order']);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ShopOrder $shopOrder): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, ShopOrder $shopOrder): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, ShopOrder $shopOrder): bool
    {
        return false;
    }
}
