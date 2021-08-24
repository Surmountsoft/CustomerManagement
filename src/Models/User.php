<?php

/**
 * @package CSoftech\Customer\Models
 *
 * @class User
 *
 * @author Mohit kumar <mohit.kumar@surmountsoft.in>
 *
 * @copyright 2021 SurmountSoft Pvt. Ltd. All rights reserved.
 */

namespace CSoftech\Customer\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'email',
        'password',
        'first_name',
        'last_name',
        'is_active',
        'name',
        'mobile_number',
        'user_role',
        'verification_code',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
//    protected $appends = [
//        'profile_photo_url',
//    ];

   /**
    * @return \Illuminate\Database\Eloquent\Relations\MorphOne
    */
   public function address()
   {
       return $this->morphOne(Address::class, 'entity');
   }

    // /**
    //  * @return \Illuminate\Database\Eloquent\Relations\MorphMany
    //  */
    // public function uploads()
    // {
    //     return $this->morphMany(Asset::Class, 'entity');
    // }
    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
     */
    public function uploads()
    {
        return $this->morphMany(Upload::class, 'uploadable');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\belongsToMany
     */
    public function role()
    {
        return $this->hasOne(Role::class,'id','user_role');
    }


    /**
     * get the full name attribute
     * @return string
     */
    public function getFullNameAttribute() {
        return ucfirst($this->first_name) . ' ' . ucfirst($this->last_name);
    }
}
