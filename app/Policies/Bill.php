<?php

namespace App\Policies;

use App\Bill;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class Bill
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any bills.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return false;
        // maybe return all the users bills?
    }

    /**
     * Determine whether the user can view the bill.
     *
     * @param  \App\User  $user
     * @param  \App\Bill  $bill
     * @return mixed
     */
    public function view(User $user, Bill $bill)
    {
        // case: user is admin of family
        foreach($user->families as $family) {
            if($family->id == $bill->family_id) {
                return true;
            }
        }
        // case: user is bill payer
        foreach($user->bills as $userBill) {
            if($userBill->id == $bill->id) {
                return true;
            }
        }
        return false;
    }

    /**
     * Determine whether the user can create bills.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user, Bill $bill)
    {
        foreach($user->families as $family) {
            if($family->id == $bill->family_id) {
                return true;
            }
        }
        return false;
    }

    /**
     * Determine whether the user can update the bill.
     *
     * @param  \App\User  $user
     * @param  \App\Bill  $bill
     * @return mixed
     */
    public function update(User $user, Bill $bill)
    {
        foreach($user->families as $family) {
            if($family->id == $bill->family_id) {
                return true;
            }
        }
        return false;
    }

    /**
     * Determine whether the user can delete the bill.
     *
     * @param  \App\User  $user
     * @param  \App\Bill  $bill
     * @return mixed
     */
    public function delete(User $user, Bill $bill)
    {
        foreach($user->families as $family) {
            if($family->id == $bill->family_id) {
                return true;
            }
        }
        return false;
    }

    /**
     * Determine whether the user can restore the bill.
     *
     * @param  \App\User  $user
     * @param  \App\Bill  $bill
     * @return mixed
     */
    public function restore(User $user, Bill $bill)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the bill.
     *
     * @param  \App\User  $user
     * @param  \App\Bill  $bill
     * @return mixed
     */
    public function forceDelete(User $user, Bill $bill)
    {
        //
    }

    /**
     * Determine whether the user can create bill-user association
     *
     * @param  \App\User  $user
     * @param  \App\Bill  $bill
     * @param  \App\User  $userAttached
     * @return mixed
     */
    public function attachUser(User $user, Bill $bill, User $userAttached)
    {
        // only admin's on a family that the bill belongs to can
        // create a bill-user association
        foreach($user->families as $family) {
            if($family->id == $bill->family_id) {
                return true;
            }
        }
        return false;
    }

    /**
     * Determine whether the user can update bill-user association
     *
     * @param  \App\User  $user
     * @param  \App\Bill  $bill
     * @param  \App\User  $userAttached
     * @return mixed
     */
     public function updatePivotUser(User $user, Bill $bill, User $userAttached)
     {
         // only admin's on a family that the bill belongs to can
         // update a bill-user association
         foreach($user->families as $family) {
             if($family->id == $bill->family_id) {
                 return true;
             }
         }
         return false;
     }
     /**
      * Determine whether the user can delete bill-user association
      *
      * @param  \App\User  $user
      * @param  \App\Bill  $bill
      * @param  \App\User  $userAttached
      * @return mixed
      */
      public function detachUser(User $user, Bill $bill, User $userDetached)
      {
          // only admin's on a family that the bill belongs to can
          // delete a bill-user association
          foreach($user->families as $family) {
              if($family->id == $bill->family_id) {
                  return true;
              }
          }
          return false;
      }
}
