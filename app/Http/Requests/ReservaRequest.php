<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReservaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
        'tipo_habitacion_id' => ['required', 'exists:tipo_habitaciones,id'],
        'habitacion_id'      => ['required', 'exists:habitaciones,id'],

        'fecha_ingreso'      => ['required', 'date', 'after_or_equal:today'],
        'fecha_salida'       => ['required', 'date', 'after:fecha_entrada'],

        'hora_llegada'       => ['nullable', 'date_format:H:i'],

        'adultos'            => ['required', 'integer', 'min:1'],
        'ninos'              => ['nullable', 'integer', 'min:0'],

        'peticiones'         => ['nullable', 'string', 'max:500'],

        'terminos'           => ['accepted'],
    ];

    }

    public function messages(): array
    {
        return [
            'tipo_habitacion_id.required' => 'Debe seleccionar un tipo de habitación.',
            'habitacion_id.required'      => 'Debe seleccionar una habitación.',

            'fecha_ingreso.required' => 'La fecha de ingreso es obligatoria.',
            'fecha_salida.required'  => 'La fecha de salida es obligatoria.',

            'fecha_entrada.after_or_equal' => 'La fecha de ingreso no puede ser anterior a hoy.',
            'fecha_salida.after'           => 'La fecha de salida debe ser mayor a la de ingreso.',

            'terminos.accepted' => 'Debe aceptar los términos y condiciones.',
        ];
    }
}
