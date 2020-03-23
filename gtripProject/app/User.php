<?php

namespace App;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }


    public function destinations()
    {
        return $this->hasMany(DestinationDetails::class, 'user_id')->latest('updated_at');
    }

    public function accessibleDestinations()
    {
        return DestinationDetails::where('user_id', $this->id)->with('foundItems', 'keys')->get();

        ///->with('keys')
    }

    public function singleAccessibleDestinations($id)
    {
        // return DestinationDetails::where([
        //     ['user_id', $this->id],
        //     []
        // ])->get();
        return [];
    }

    public function accessibleFoundItems()
    {
        // return GumTreeRipper::latest('updated_at')->get();
        return GumTreeRipper::where('user_id', $this->id)->latest('updated_at')->get();
    }
}
