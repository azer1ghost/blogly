<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => 'required|min:1|max:255',
            'description' => 'nullable|max:10000',
            'publication_date' => 'nullable|date|after:yesterday',
            'image' => 'filled|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'tags' => 'required|array'
        ];
    }

    public function messages(): array
    {
        return [
            'publication_date.after' => 'You can\'t enter date before today',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'tags' => explode(',', $this->tags),
        ]);
    }
}
