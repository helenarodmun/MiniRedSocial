<?php

namespace App\Http\Controllers;

use App\Models\CommunityLink;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Channel;
use App\Http\Requests\CommunityLinkForm;

class CommunityLinkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // recibe un parámetro opcional Channel $channel = null
    public function index(Channel $channel = null)
    {
        /**
         * $links ->filtramos la consulta, para mostrar solo los links aprovados,
         * con paginación de 25, y que aparezcan los últimos registros creados
         * $channels -> mostrremos los canales  por orden ascendente
         * A la vista le pasamos los atributos, y las variables  a mostrar
         */
        //Si se ha pasado el slug del canal por la URL
        if ($channel) {
            //filtra los links asociados a ese canal en la tabla CommunityLink y solo muestra aquellos 
            //links aprobados que están ordenados por la fecha de actualización de manera descendente, y luego se paginan con 25 por página
            $links = CommunityLink::where('channel_id', $channel->id)->where('approved', 1)->latest('updated_at')->paginate(25);
              //asigna el valor de $slug a $channel->slug, que representa el slug del canal seleccionado
            $slug = $channel->slug;
        } else {
            //muestra todos los links
            $links = CommunityLink::where('approved', 1)->latest('updated_at')->paginate(25);
            $slug = '';
        }

        //obtiene todos los canales  ordenados por título
        $channels = Channel::orderBy('title', 'asc')->get();      
        
        //devuelve la vista con los links y canales  y el valor de $slug
        return view('community/index', compact('links', 'channels', 'slug'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * almacena los datos recibidos desdela solicitud (Request) en la bd. Valida los datos recibidos con la función validate,
     *  luego verifica si el usuario que hizo la solicitud es un usuario verificado (auth) y por último almacena los datos de
     *  la solicitud en la bd. 
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CommunityLinkForm $request)
    {


        //Devuelve con el método de User el atributo 'trusted'
        $approved = Auth::user()->isTrusted();

        //Establece el atributo 'approved' con el resultado de isTrusted()
        $request->merge(['user_id' => Auth::id(), 'approved' => $approved]);
        //Verifica si el link ha sido previamente enviado
        //Crea una nueva instancia de CommunityLink
        $link = new CommunityLink();
        //Establece el atributo user_id con el id del usuario autenticado
        $link->user_id = Auth::id();
        if ($link->hasAlreadyBeenSubmitted($request->link)) {
            //Si se ha enviado previamente, devuelve un mensaje
            return back()->with('info', 'This link has already been submitted!');
        } else {
            //Crea el link            
            CommunityLink::create($request->all());

            if ($approved == true) {
                return back()->with('success', 'Link created successfully!');
            } else {
                return back()->with('error', 'You are not a verified user, when we approve three links you will be able to publish freely!');
            }
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CommunityLink  $communityLink
     * @return \Illuminate\Http\Response
     */
    public function show(CommunityLink $communityLink)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CommunityLink  $communityLink
     * @return \Illuminate\Http\Response
     */
    public function edit(CommunityLink $communityLink)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CommunityLink  $communityLink
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CommunityLink $communityLink)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CommunityLink  $communityLink
     * @return \Illuminate\Http\Response
     */
    public function destroy(CommunityLink $communityLink)
    {
        //
    }
}
