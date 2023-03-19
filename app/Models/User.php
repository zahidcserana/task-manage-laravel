<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    public const ROLE_ADMINISTRATOR = 1;
    public const ROLE_MEMBER = 2;

    public const ROLE_DEFAULT = self::ROLE_MEMBER;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function instituteIds($includeDisabled = false, $ignoreSession = false)
    {
        $user = Auth()->user();
        $sessionCustomer = $this->getSessionCustomer();

        if ($sessionCustomer && !$ignoreSession) {
            return [$sessionCustomer->id];
        }

        if ($user->isAdmin()) {
            return Institute::all()->pluck('id')->toArray();
        }

        if ($includeDisabled) {
            return $user->institutes->pluck('id')->toArray();
        }

        return $user->institutes->where('active', 1)->pluck('id')->toArray();
    }

    public function isAdmin()
    {
        return $this->user_type == self::ROLE_ADMINISTRATOR;
    }

    public function getSessionCustomer()
    {
        return null;

        // $customer = Session::get(self::SESSION_CUSTOMER_KEY);

        // if (!$customer) {
        //     return null;
        // }

        // if (is_int($customer)) {
        //     return Customer::find($customer);
        // }

        // return $customer;
    }

    public function institutes()
    {
        return Institute::query();
        // return $this->belongsToMany(Customer::class)->using(CustomerUser::class)->withPivot(['role_id']);
    }
}
