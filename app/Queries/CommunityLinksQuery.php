<?php

namespace App\Queries;

use App\Models\CommunityLink;
use App\Models\Channel;

class CommunityLinksQuery
/**
 * Obtiene los enlaces de una categoría específica que hayan sido aprobados,
 * ordenados por fecha de actualización, y paginados en grupos de 25 elementos.
 *
 * @param Channel $channel
 * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
 */
{
    public function getByChannel(Channel $channel)
    {
        // Se accede a la relación "communitylinks" de la categoría
        return $channel->communitylinks()->where('approved', 1)->latest('updated_at')->paginate(25);
    }
    /**
     * Obtiene todos los enlaces que hayan sido aprobados,
     * ordenados por fecha de actualización, y paginados en grupos de 25 elementos.
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getAll()
    {
        return CommunityLink::where('approved', 1)->latest('updated_at')->paginate(25);
    }
    /**
     * Obtiene los enlaces más populares (más votados) que hayan sido aprobados,
     * ordenados por número de votos y paginados en grupos de 25 elementos.
     * También se pueden filtrar los enlaces por categoría, si se proporciona el objeto $channel.
     *
     * @param Channel|null $channel
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getMostPopular(Channel $channel = null)
    {

        $query = CommunityLink::where('approved', 1)->withCount('votes')->orderBy('votes_count', 'desc');
        if ($channel) {
            $query->where('channel_id', $channel->id);
        }
        return $query->paginate(25);
    }
}
