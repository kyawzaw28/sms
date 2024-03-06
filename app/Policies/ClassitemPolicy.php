<?php

namespace App\Policies;

use App\Models\Classitem;
use App\Models\User;
use App\Models\Role;
use Illuminate\Auth\Access\HandlesAuthorization;

class ClassitemPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */

    public function viewAny(User $user)
    {
        return $user->role_id == Role::IS_ADMIN;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Classitem  $classitem
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Classitem $classitem)
    {
        return $user->role_id == Role::IS_ADMIN || $classitem->users()->where('user_id', $user->id)->exists();
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return $user->role_id == Role::IS_ADMIN;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Classitem  $classitem
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Classitem $classitem)
    {
        return $user->role_id == Role::IS_ADMIN;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Classitem  $classitem
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Classitem $classitem)
    {
        return $user->role_id == Role::IS_ADMIN;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Classitem  $classitem
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Classitem $classitem)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Classitem  $classitem
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Classitem $classitem)
    {
        //
    }
}
