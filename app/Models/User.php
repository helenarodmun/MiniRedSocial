<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

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

    //Devuelve con el método de User el atributo 'trusted'
    public function isTrusted()
    {
        return $this->trusted ? true : false;
    }

    //relación entre user y links, con el tiempo de creación y/o actualización de un registro
    public function votes()
    {
        return $this->belongsToMany(CommunityLink::class)->withTimestamps();
    }

    //Devuelve booleano en función si el usuario ha votado por el link
    public function votedFor(CommunityLink $link)
    {
        return $this->votes->contains($link);
    }
}
