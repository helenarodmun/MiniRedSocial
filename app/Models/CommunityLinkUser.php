<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class CommunityLinkUser extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'community_link_id',
    ];
  protected $table = 'community_link_user';
  //forzado del nombre de la tabla por conflicto con las consultas sql -> Illuminate \ Database \ QueryException (42S02) SQLSTATE[42S02]: Base table or view not found: 1146 Table
  public function toggleVote(CommunityLink $link)
  {
      $vote = $this->firstOrNew(['user_id' => Auth::id(), 'community_link_id' => $link->id]);
      if ($vote->id) {
          $vote->delete();
      } else {
          $vote->save();
      }
  }
  
}
