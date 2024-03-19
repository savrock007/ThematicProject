<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TicketCreateRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:250',
            'description' => 'required|string|max:3000',
            'assets' =>  'string|max:3000',
            'steps' => 'string|max:3000',
            'developer' => 'required|exists:users,id',
            'tester' =>'required|exists:users,id|different:developer',
        ];
    }
}
