<?php

declare (strict_types=1);
namespace App\Plugins\U87\src\Models;

use App\Model\Model;
use Carbon\Carbon;
use App\Plugins\User\src\Models\UserClass;
use App\Plugins\User\src\Models\UsersOption;
/**
 * @property int $id 
 * @property string $username 
 * @property string $email 
 * @property string $password 
 * @property string $avatar 
 * @property string $email_ver_time 
 * @property string $class_id 
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class User extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'users';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['username','password','email','avatar','class_id','email_ver_time','_token','options_id'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        '_token',
        'email'
    ];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['id' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime'];

    public function Class()
    {
        return $this->belongsTo(UserClass::class,"class_id","id");
    }

    public function Options(){
        return $this->belongsTo(UsersOption::class,"options_id","id");
    }
}