<?php

namespace App\Policies;

use App\Payment;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class Payment
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any payments.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return false;
        // show all users payments(?) or all payments for monthly bill(?)
        // or all payments for bill(?) or all payments for family(?)
    }

    /**
     * Determine whether the user can view the payment.
     *
     * @param  \App\User  $user
     * @param  \App\Payment  $payment
     * @return mixed
     */
    public function view(User $user, Payment $payment)
    {
        // case: user made payment
        if($user->id == $payment->user_id) {
            return true;
        }
        // case: user is admin on family where payment is for
        // monthly bill on bill belonging to family
        foreach($user->families as $family) {
            foreach($family->bills as $bill) {
                foreach($bill->monthlyBills as $monthlyBill) {
                    if($monthlyBill->id == $payment->monthly_bill_id) {
                        return true;
                    }
                }
            }
        }
        return false;
    }

    /**
     * Determine whether the user can create payments.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        // case: user is making own payment
        if($user->id == $payment->user_id) {
            return true;
        }
        // case: user is admin on family where payment will
        // be for monthly bill on bill belonging to family
        // i.e. admin can make monthly bill payment on
        // behalf of users in the family
        foreach($user->families as $family) {
            foreach($family->bills as $bill) {
                foreach($bill->monthlyBills as $monthlyBill) {
                    if($monthlyBill->id == $payment->monthly_bill_id) {
                        return true;
                    }
                }
            }
        }
        return false;
    }

    /**
     * Determine whether the user can update the payment.
     *
     * @param  \App\User  $user
     * @param  \App\Payment  $payment
     * @return mixed
     */
    public function update(User $user, Payment $payment)
    {
        // case: user is updating own payment
        if($user->id == $payment->user_id) {
            return true;
        }
        // case: user is admin on family where payment is
        // for monthly bill on bill belonging to family
        // i.e. admin can update monthly bill payment on
        // behalf of users in the family
        foreach($user->families as $family) {
            foreach($family->bills as $bill) {
                foreach($bill->monthlyBills as $monthlyBill) {
                    if($monthlyBill->id == $payment->monthly_bill_id) {
                        return true;
                    }
                }
            }
        }
        return false;
    }

    /**
     * Determine whether the user can delete the payment.
     *
     * @param  \App\User  $user
     * @param  \App\Payment  $payment
     * @return mixed
     */
    public function delete(User $user, Payment $payment)
    {
        // case: user is deleting own payment
        if($user->id == $payment->user_id) {
            return true;
        }
        // case: user is admin on family where payment is
        // for monthly bill on bill belonging to family
        // i.e. admin can delete monthly bill payment on
        // behalf of users in the family
        foreach($user->families as $family) {
            foreach($family->bills as $bill) {
                foreach($bill->monthlyBills as $monthlyBill) {
                    if($monthlyBill->id == $payment->monthly_bill_id) {
                        return true;
                    }
                }
            }
        }
        return false;
    }

    /**
     * Determine whether the user can restore the payment.
     *
     * @param  \App\User  $user
     * @param  \App\Payment  $payment
     * @return mixed
     */
    public function restore(User $user, Payment $payment)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the payment.
     *
     * @param  \App\User  $user
     * @param  \App\Payment  $payment
     * @return mixed
     */
    public function forceDelete(User $user, Payment $payment)
    {
        //
    }
}
