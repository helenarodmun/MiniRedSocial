<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CommunityLinkUser;
use App\Models\CommunityLink;
use Illuminate\Support\Facades\Auth;

class CommunityLinkUserController extends Controller
{
    public function store(CommunityLink $link, CommunityLinkUser $communityLinkUser)
    {
        $communityLinkUser->toggleVote($link);
        return back();
    }
}

//OJO!! si da errores limpiar la cache de rutas y config php artisan config:clear
