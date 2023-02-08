<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class CommunityLinkUser extends Model
{
    protected $table = 'community_link_users';
    use HasFactory;

    protected $fillable = [
        'user_id',
        'community_link_id',
    ];
  
}
