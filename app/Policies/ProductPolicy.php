<?php

namespace App\Policies;

use App\Models\Product;
use App\Models\User;

class ProductPolicy
{
    // (Optional) Let admins do everything:
    public function before(User $user, string $ability): ?bool
    {
        if ($user->isAdmin()) return true;
        return null;
    }

    public function viewAny(User $user): bool
    {
        return $user->isSeller();
    }

    public function view(User $user, Product $product): bool
    {
        return $user->isAdmin() || ($user->isSeller() && $product->seller_id === $user->id);
    }

    public function create(User $user): bool
    {
        return $user->isSeller();
    }

    public function update(User $user, Product $product): bool
    {
        return $user->isAdmin() || ($user->isSeller() && $product->seller_id === $user->id);
    }

    public function delete(User $user, Product $product): bool
    {
        return $user->isAdmin() || ($user->isSeller() && $product->seller_id === $user->id);
    }

    public function restore(User $user, Product $product): bool
    {
        return $this->update($user, $product);
    }

    public function forceDelete(User $user, Product $product): bool
    {
        return $user->isAdmin();
    }
}
