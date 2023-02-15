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
        //$links ->filtramos la consulta, para mostrar solo los links aprovados
        $links = CommunityLink::where('approved', 1);
        //para comprobar si el parámetro 'popular' está presente en la URL. Este método
        //devuelve truesi la variable 'popular' está presente en la URL y false en caso contrario.
        if (request()->exists('popular')) {
            //withCount (Cuenta con relación)
            //ayuda a obtener la cantidad de registros relacionados dentro del objeto principal   
            $links->withCount('votes')->orderBy('votes_count', 'desc');
        } else {
            $links->latest('updated_at');
        }

        if ($channel) {
            $links = $links->where('channel_id', $channel->id);
            //asigna el valor de $slug a $channel->slug, que representa el slug del canal seleccionado
            $slug = $channel->slug;
        } else {
            $slug = '';
        }

        $links = $links->paginate(25);
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
