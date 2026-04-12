<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ModuloRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $isUpdate   = $this->isMethod('PUT') || $this->isMethod('PATCH');
        $isOptional = ($isUpdate ? 'sometimes' : 'required');

        return [
            'modulo-dependiente' => 'nullable|exists:modulos,ulid',

            'nombre' => $isOptional . '|string|max:30',
            'icono'  => $isOptional . '|string|max:30',
            'estatus'=> 'sometimes|numeric',
            'uri'    => 'sometimes|nullable|string',
            'orden'  => 'sometimes|nullable|numeric',
            'descripcion' => 'sometimes|nullable|string'
        ];
    }
}
