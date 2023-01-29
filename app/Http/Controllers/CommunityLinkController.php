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
    public function index()
    {
        /**
         * $links ->filtramos la consulta, para mostrar solo los links aprovados,
         * con paginación de 25, y que aparezcan los últimos registros creados
         * $channels -> mostrremos los canales  por orden ascendente
         * A la vista le pasamos los atributos, y las variables  a mostrar
         */
        $links = CommunityLink::where('approved', 1)->latest('updated_at')->paginate(25);
        $channels = Channel::orderBy('title', 'asc')->get();
        return view('community/index', compact('links', 'channels'));
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
        $validated = $request->validated(); 
        $validated =$request->safe()->only(['title', 'link', 'channel_id', 'user_id']);
        $validated =$request->safe()->except(['title', 'link', 'channel_id', 'user_id']); 
        //Devuelve con el método de User el atributo 'trusted'
        $approved = Auth::user()->isTrusted();
        $request->merge(['user_id' => Auth::id(), 'approved' => $approved, 'channel_id']);
        CommunityLink::create($validated);
        if (CommunityLink::hasAlreadyBeenSubmitted($request->link)) {
            return back()->with('error', 'This link has already been submitted!');
        }else{           
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
