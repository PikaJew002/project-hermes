<?php

namespace App\Policies;

use App\MonthlyBill;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class MonthlyBill
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any monthly bills.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return false;
        // show only users monthly bills?
    }

    /**
     * Determine whether the user can view the monthly bill.
     *
     * @param  \App\User  $user
     * @param  \App\MonthlyBill  $monthlyBill
     * @return mixed
     */
    public function view(User $user, MonthlyBill $monthlyBill)
    {
        // case: user who pays on a bill can view monthly bills
        foreach($user->bills as $bill) {
            if($bill->id == $monthlyBill->bill_id) {
                return true;
            }
        }
        // case: users who are admins can view monthly bills
        // on a bill belonging to the family
        foreach($user->families as $family) {
            foreach($family->bills as $bill) {
                if($bill->id == $monthlyBill->bill_id) {
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * Determine whether the user can create monthly bills.
     *
     * @param  \App\User  $user
     * @param  \App\MonthlyBill  $monthlyBill
     * @return mixed
     */
    public function create(User $user, $monthlyBill)
    {
        // only users who are admins can manualy create monthly bills
        // on a bill belonging to the family
        foreach($user->families as $family) {
            foreach($family->bills as $bill) {
                if($bill->id == $monthlyBill->bill_id) {
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * Determine whether the user can update the monthly bill.
     *
     * @param  \App\User  $user
     * @param  \App\MonthlyBill  $monthlyBill
     * @return mixed
     */
    public function update(User $user, MonthlyBill $monthlyBill)
    {
        // only users who are admins can manualy update monthly bills
        // on a bill belonging to the family
        foreach($user->families as $family) {
            foreach($family->bills as $bill) {
                if($bill->id == $monthlyBill->bill_id) {
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * Determine whether the user can delete the monthly bill.
     *
     * @param  \App\User  $user
     * @param  \App\MonthlyBill  $monthlyBill
     * @return mixed
     */
    public function delete(User $user, MonthlyBill $monthlyBill)
    {
        // only users who are admins can manualy delete monthly bills
        // on a bill belonging to the family
        foreach($user->families as $family) {
            foreach($family->bills as $bill) {
                if($bill->id == $monthlyBill->bill_id) {
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * Determine whether the user can restore the monthly bill.
     *
     * @param  \App\User  $user
     * @param  \App\MonthlyBill  $monthlyBill
     * @return mixed
     */
    public function restore(User $user, MonthlyBill $monthlyBill)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the monthly bill.
     *
     * @param  \App\User  $user
     * @param  \App\MonthlyBill  $monthlyBill
     * @return mixed
     */
    public function forceDelete(User $user, MonthlyBill $monthlyBill)
    {
        //
    }
}
