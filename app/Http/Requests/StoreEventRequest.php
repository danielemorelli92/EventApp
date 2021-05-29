<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreEventRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {

        return $this->user() != null && ($this->user()->type === 'organizzatore' || $this->user()->type === 'admin');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'bail|required|string|min:4|max:255',
            'description' => 'required',
            'address' => 'required|string',
            'type' => 'required|string|min:4|max:255',
            'starting_time' => 'required|date',
            'ending_time' => 'nullable|date'
        ];
    }
}
