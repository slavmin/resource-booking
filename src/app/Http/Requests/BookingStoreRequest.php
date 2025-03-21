<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookingStoreRequest extends FormRequest
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
            'resource_id' => ['required', 'integer', 'exists:resources,id'],
            'user_id' => ['required', 'integer', 'exists:users,id'],
            'start_time' => ['required', 'date', 'after_or_equal:today'],
            'end_time' => ['required', 'date', 'after:start_time'],
        ];
    }

    public function messages(): array
    {
        return [
            'resource_id.required' => 'Это поле обязательно',
            'resource_id.integer' => 'Поле должно быть числом',
            'resource_id.exists' => 'Соответствие не найдено',
            'user_id.required' => 'Это поле обязательно',
            'user_id.integer' => 'Поле должно быть числом',
            'user_id.exists' => 'Соответствие не найдено',
            'start_time.required' => 'Это поле обязательно',
            'start_time.date' => 'Поле должно быть датой',
            'start_time.after_or_equal' => 'Поле должно быть более поздней датой',
            'end_time.required' => 'Это поле обязательно',
            'end_time.date' => 'Поле должно быть датой',
            'end_time.after' => 'Поле должно быть более поздней датой',
        ];
    }
}
