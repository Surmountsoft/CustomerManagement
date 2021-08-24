<?php
/**
 * @package CSoftech\Customer\Models
 *
 * @class Role
 *
 * @author Rahul Sharma <rahul.sharma@surmountsoft.in>
 *
 * @copyright 2021 SurmountSoft Pvt. Ltd. All rights reserved.
 */
namespace CSoftech\Customer\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'is_active'
    ];

    public function users() {
        return $this->belongsToMany(User::class);
    }

    public function permissions() {
        return $this->belongsToMany(Permission::class,'permission_role','role_id','permission_id');
    }

     /**
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function hasUsers() {
        return $this->hasMany(User::class, 'user_role', 'id');
    }
}
