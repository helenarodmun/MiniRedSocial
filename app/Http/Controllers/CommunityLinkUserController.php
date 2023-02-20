<?php

namespace App\Http\Controllers;

use App\Models\CommunityLinkUser;
use App\Models\CommunityLink;

class CommunityLinkUserController extends Controller
{
    // Este método se encarga de almacenar el voto del usuario actual para un enlace de la comunidad específico.
    public function store(CommunityLink $link, CommunityLinkUser $communityLinkUser)
    {
        // Se llama al método toggleVote de la instancia de CommunityLinkUser para que el usuario actual vote o quite el voto del enlace de la comunidad pasado como argumento.
        $communityLinkUser->toggleVote($link);
        // El usuario es redirigido a la página anterior.
        return back();
    }
}

//OJO!! si da errores limpiar la cache de rutas y config php artisan config:clear
