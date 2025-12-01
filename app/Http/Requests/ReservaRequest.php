<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReservaRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'habitacion_id'   => ['required', 'exists:habitaciones,id'],
            'fecha_entrada'   => ['required', 'date', 'after_or_equal:today'],
            'fecha_salida'    => ['required', 'date', 'after:fecha_entrada'],
        ];
    }

    public function messages(): array
    {
        return [
            'habitacion_id.required' => 'Debe seleccionar una habitación.',
            'habitacion_id.exists'   => 'La habitación seleccionada no existe.',

            'fecha_entrada.required' => 'Debe ingresar la fecha de entrada.',
            'fecha_entrada.after_or_equal' => 'La fecha de entrada no puede ser anterior a hoy.',

            'fecha_salida.required' => 'Debe ingresar la fecha de salida.',
            'fecha_salida.after'    => 'La salida debe ser después de la entrada.',
        ];
    }
}
