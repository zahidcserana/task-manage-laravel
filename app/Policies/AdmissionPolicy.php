<?php

namespace App\Policies;

use App\Models\Admission;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AdmissionPolicy
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
        return true;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Admission  $admission
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Admission $admission)
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Admission  $admission
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, $data = null)
    {
        if ($user->isAdmin()) {
            return true;
        }

        // $data = $data ?: app('request')->input();

        // if (isset($data['sku']) && $product = Product::where('sku', $data['sku'])->first()) {
        //     if ($user->hasCustomer($product->customer_id) == false) {
        //         return false;
        //     }
        // }

        // if (isset($data['customer_id'])) {
        //     return $user->hasCustomer($data['customer_id']);
        // }

        return true;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Admission  $admission
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, $data = null)
    {
        if ($user->isAdmin()) {
            return true;
        }
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Admission  $admission
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Admission $admission)
    {
        return true;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Admission  $admission
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Admission $admission)
    {
        return true;
    }
}
