<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class KnownledgeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

public function rules(): array
    {
        $type = $this->route('type', 'text');
        dd($type);
        return [
            'type' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'file' => 'nullable|file|mimes:pdf,doc,docx,png,jpg,jpeg|max:4096',
        ];
    }
}
