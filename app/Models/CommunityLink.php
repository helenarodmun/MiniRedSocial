<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;


class CommunityLink extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'channel_id',
        'title',
        'link',
        'approved'
      ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function channel()
    {
        return $this->belongsTo(Channel::class);
    }
    
    //método comprueba si un enlace en particular ya ha sido enviado anteriormente.
    // Si es así, actualiza el marcador de tiempo de la entrada en la base de datos y devuelve 'true'. Si no, devuelve 'false'
    public function hasAlreadyBeenSubmitted($link)
    {
        if ($existing = static::where('link', $link)->first()) {
            $existing->touch();
            $existing->save();
            return true;
        }
        return false;
    }
}
