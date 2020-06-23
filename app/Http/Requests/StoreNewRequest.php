<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreNewRequest extends FormRequest
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
     * Obtiene las reglas de validacion que se aplican al request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|string|max:255|unique:news',
            'body' => 'required|string|max:10000',
            'user_id' => 'required|integer'
        ];
    }

    // /**
    //  * Obtiene los atributos personalizados para el validador de errores.
    //  *
    //  * @return array
    //  */
    // public function attributes()
    // {
    //     return [
    //         'title' => 'Título',
    //         'body' => 'Contenido',
    //         'user_id' => 'Id del usuario',
    //     ];
    // }

    /**
     * Obtiene los mensajes de error para las reglas de validacion definidas.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'title.required' => 'Por favor especifica un título para la noticia',
            'title.string' => 'El título de la noticia tiene que ser una cadena de caracteres',
            'title.max' => 'El título no debe contener mas de 255 caracteres',
            'title.unique' => 'Este título ya se ha utilizado',           
            'body.required'  => 'Por favor redacta el cuerpo de la noticia',
            'body.max' => 'El cuerpo de la noticia no debe contener mas de 10,000 caracteres',
            'body.string' => 'El cuerpo de la noticia tiene que ser una cadena de caracteres',
            'user_id.required'  => 'Por favor especifica el Id de quien redacta la noticia',
            'user_id.integer' => 'El Id del usuario tiene que ser un número entero',
        ];
    }
}
