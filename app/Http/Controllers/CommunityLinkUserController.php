<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CommunityLinkUser;
use App\Models\CommunityLink;
use Illuminate\Support\Facades\Auth;

class CommunityLinkUserController extends Controller
{

    public function store(CommunityLink $link)
    {
        // Se guarda en la variable el usuario autenticado a través de la id búscandolo
        // con el método firstOrNew que encuentra el primer registro de la tabla pivote que coincida con las restricciones dadas,
        // y si no crea uno nuevo, en este caso buscara el usuario que está logueado, si tiene el id del link que se la pasa a través del action del formulario por url
        //(si lo ha votado)    
        $vote = CommunityLinkUser::firstOrNew(['user_id' => Auth::id(), 'community_link_id' => $link->id]);
        //si tiene el id del link, lo borrará al hacer click
        if ($vote->id) {
            $vote->delete();
            //si no lo tiene se guardará en la base de datos el comunnity_link_id que se le pasa por url através del action del formulario
        } else {
            $vote->save();
        }
        return back();
    }
}

//OJO!! si da errores limpiar la cache de rutas y config php artisan config:clear
