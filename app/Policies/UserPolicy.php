<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    public function create(User $user): bool
    {
        return $user->isSuperAdmin() || $user->isAdmin() || $user->isManager();
    }

    public function view(User $user, User $model): bool
    {
        if ($user->isSuperAdmin() || $user->isAdmin()) {
            return true;
        }

        return $user->id === $model->id;
    }

    public function update(User $user, User $model): bool
    {
        if ($user->isSuperAdmin()) {
            return true;
        }

        if ($user->isAdmin()) {
            return !$model->isSuperAdmin();
        }

        if ($user->isManager()) {
            return $model->isEmployee() || $user->id === $model->id;
        }

        if ($user->isEmployee()) {
            return $user->id === $model->id;
        }

        return false;
    }

    public function delete(User $user, User $model): bool
    {
        if ($user->isSuperAdmin()) {
            return $user->id !== $model->id;
        }

        if ($user->isAdmin()) {
            return !$model->isSuperAdmin() && $user->id !== $model->id;
        }

        if ($user->isManager()) {
            return $model->isEmployee();
        }

        return false;
    }
}