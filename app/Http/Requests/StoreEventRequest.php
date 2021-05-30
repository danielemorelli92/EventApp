<?php

namespace App\Http\Requests;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreEventRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|string|min:4|max:255',
            'description' => 'required',
            'address' => 'required|string',
            'type' => 'required|string|min:4|max:255',
            'starting_time' => 'required|date',
            'ending_time' => 'nullable|date',
            'max_partecipants' => 'nullable|min:0|max:999999999',
            'price' => 'nullable|min:0|max:9999999',
            'ticket_office' => 'nullable',
            'website' => 'nullable'
        ];
    }

}
