<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class CommunityLinkUser extends Model
{
    use HasFactory;
    // Los atributos que se pueden asignar en masa
    protected $fillable = [
        'user_id',
        'community_link_id',
    ];
    // El nombre de la tabla correspondiente al modelo
    // Por defecto, Laravel intentará adivinar el nombre de la tabla en función del nombre del modelo, pero a veces puede fallar
    // En este caso, el modelo CommunityLinkUser corresponde a la tabla 'community_link_user'
    // Al definir el nombre de la tabla aquí, evitamos que Laravel intente adivinarlo
    // y evitamos errores como "Base table or view not found"
    protected $table = 'community_link_user';
    // Relación muchos a muchos con la tabla de usuarios
    public function votes()
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }
    // Cambia el estado del voto de un usuario para un enlace de la comunidad dado
    public function toggleVote(CommunityLink $link)
    {
        // Busca el registro correspondiente al enlace y al usuario actual o crea uno nuevo si no existe
        $vote = $this->firstOrNew(['user_id' => Auth::id(), 'community_link_id' => $link->id]);
        // Si el registro ya existe, significa que el usuario ya ha votado y quiere eliminar su voto
        if ($vote->id) {
            $vote->delete();
        // Si el registro no existe, significa que el usuario aún no ha votado y quiere añadir su voto
        } else {
            $vote->save();
        }
    }
}
