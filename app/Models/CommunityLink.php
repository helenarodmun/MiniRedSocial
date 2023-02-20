<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User; 

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
    // Establece la relación de la tabla community_links con la tabla users mediante la columna user_id
    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    // Establece la relación de la tabla community_links con la tabla users mediante la columna user_id
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    // Establece la relación de la tabla community_links con la tabla channels mediante la columna channel_id
    public function channel()
    {
        return $this->belongsTo(Channel::class);
    }
    // Establece la relación muchos a muchos de la tabla community_links con la tabla users
    public function users()
    {
        return $this->belongsToMany(User::class);
    }
   // Establece la relación muchos a muchos de la tabla community_links con la tabla users y guarda los timestamps
    public function votes()
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }
    //método comprueba si un enlace en particular ya ha sido enviado anteriormente.
    // Si es así, actualiza el marcador de tiempo de la entrada en la base de datos y devuelve 'true'. Si no, devuelve 'false'
    public function hasAlreadyBeenSubmitted($link)
    {
        // Busca en la tabla community_links si ya existe un registro con el mismo link
        if ($existing = static::where('link', $link)->first()) {
            // Actualiza el marcador de tiempo del registro
            $existing->touch();
            $existing->save();
            // Devuelve true si el registro existe
            return true;
        }
        // Devuelve false si el registro no existe
        return false;
    }
}
