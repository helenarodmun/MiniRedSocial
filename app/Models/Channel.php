<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'color',
    ];
    // El nombre del parámetro de ruta a usar para buscar el modelo.
    public function getRouteKeyName()
    {
        return 'slug';
    }
    // Definición de la relación de uno a muchos con la clase CommunityLink
    public function communitylinks()
    {
        return $this->hasMany(CommunityLink::class);
    }
}
