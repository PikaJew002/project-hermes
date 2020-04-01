<?php

namespace App\Policies;

use App\Family;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class Family
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any families.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return false;
    }

    /**
     * Determine whether the user can view the family.
     *
     * @param  \App\User  $user
     * @param  \App\Family  $family
     * @return mixed
     */
    public function view(User $user, Family $family)
    {
        // if the user is the admin of the family
        if($family->admin_id == $user->id) {
            return true;
        }
        foreach($user->bills as $bill) {
            // if the user has a bill belonging to the family
            if($bill->family_id == $family->id) {
                return true;
            }
        }
        return false;
    }

    /**
     * Determine whether the user can create families.
     *
     * @param  \App\User  $user
     * @param  \App\Family  $family
     * @return mixed
     */
    public function create(User $user, Family $family)
    {
        return $user->id == $family->admin_id;
    }

    /**
     * Determine whether the user can update the family.
     *
     * @param  \App\User  $user
     * @param  \App\Family  $family
     * @return mixed
     */
    public function update(User $user, Family $family)
    {
        return $user->id == $family->admin_id;
    }

    /**
     * Determine whether the user can delete the family.
     *
     * @param  \App\User  $user
     * @param  \App\Family  $family
     * @return mixed
     */
    public function delete(User $user, Family $family)
    {
        return $user->id == $family->admin_id;
    }

    /**
     * Determine whether the user can restore the family.
     *
     * @param  \App\User  $user
     * @param  \App\Family  $family
     * @return mixed
     */
    public function restore(User $user, Family $family)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the family.
     *
     * @param  \App\User  $user
     * @param  \App\Family  $family
     * @return mixed
     */
    public function forceDelete(User $user, Family $family)
    {
        //
    }
}
