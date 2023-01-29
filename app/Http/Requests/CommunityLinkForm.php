<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\CommunityLink;
//como podemos comprobar en la declaración de la clase, la clase hereda de FormRequest
//que son clases de ayuda que permiten validar y autorizar los datos de un formulario enviados por el usuario
class CommunityLinkForm extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        //reglas de validación       
        return [
            'title' => 'required',
            'link' => 'required|active_url',
            'channel_id' => 'required|exists:channels,id',
            'user_id' => 'required|exists:users,id'
        ];
    }
}
