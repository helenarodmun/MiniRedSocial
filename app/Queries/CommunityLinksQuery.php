<?php

namespace App\Queries;

use App\Models\CommunityLink;
use App\Models\Channel;

class CommunityLinksQuery
/**
 *
 * @param Channel $channel
 * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
 */
{
    public function getByChannel(Channel $channel)
    {
        //Obtiene los enlaces de una categoría específica que hayan sido aprobados,
        //ordenados por fecha de actualización, y paginados en grupos de 25 elementos.
        // Se accede a la relación "communitylinks" de la categoría
        return $channel->communitylinks()->where('approved', 1)->latest('updated_at')->paginate(25);
    }
    /**
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getAll()
    {
        // Obtiene todos los enlaces que hayan sido aprobados,
        // ordenados por fecha de actualización, y paginados en grupos de 25 elementos.
        return CommunityLink::where('approved', 1)->latest('updated_at')->paginate(25);
    }
    /**
     *
     * @param Channel|null $channel
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getMostPopular(Channel $channel = null)
    {
        //obtiene los enlaces más populares (más votados) que hayan sido aprobados,
        //ordenados por número de votos y paginados en grupos de 25 elementos.
        //También se pueden filtrar los enlaces por categoría, si se proporciona el objeto $channel.  
        $query = CommunityLink::where('approved', 1)->withCount('votes')->orderBy('votes_count', 'desc');
        if ($channel) {
            $query->where('channel_id', $channel->id);
        }
        return $query->paginate(25);
    }

    public function search($text)
    {
        // Divide el texto de búsqueda en un array de palabras
        $words = explode(' ', $text);

        // Crear una consulta para buscar los links de la comunidad que coinciden con cualquiera de las palabras clave
        $query = CommunityLink::query();
        // iteración sobre cada una de las palabras clave contenidas en el array words
        foreach ($words as $word) {
            // Se anida una cláusula where dentro del foreach para cada palabra clave
            $query->where(function ($query) use ($word) {
                // Se buscan coincidencias en el campo "title" para la palabra clave actual
                $query->where('title', 'LIKE', "%{$word}%")
                    // Se buscan coincidencias en el campo "link" para la palabra clave actual
                    ->orWhere('link', 'LIKE', "%{$word}%");
            });
        }
        // Ejecutar la consulta y paginar los resultados
        $results = $query->paginate(25);
        // Si no se encuentran resultados, mostrar un mensaje de flash en la sesión
        if ($results->isEmpty()) {
            session()->flash('message', 'No se encontraron resultados para la búsqueda realizada.');
        }
        return $results;
    }
}
