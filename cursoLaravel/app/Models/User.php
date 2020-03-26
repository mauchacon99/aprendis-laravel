<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;


class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

   

    protected $fillable = [
        'name', 'email', 'password',
    ];

    protected $casts =[
        //'is_admin' => 'boolean'
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function is_admin()
    {
        return $this->role === 'admin';
    }

    public function Skills()
    {
       return $this->belongsToMany(Skill::class , 'user_skill');
    }

    public function profession()
    {
        return $this->belongsTo(Profession::class);
         
    }

    public function Profile(){
        
        return $this->hasOne(UserProfile::class)->withDefault([
            'bio' => 'Programador'
        ]);
    }

    public function profession_user(){

       if(is_null($this->profession_id)){
            
            $profession = Profession::create([
                'title' => $this->other_profession
            ]);

            return $profession->id;
            
        }else{

            return  $profession = $this->profession_id;
        }
    }
}
