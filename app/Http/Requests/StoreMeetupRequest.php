<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMeetupRequest extends FormRequest
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
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'string|required',
            'date' => 'date|required',
            'place' => 'string|required',
            'description' => 'string|required',
            'quantity' => 'integer|required',
            'cover' => 'file|required'
        ];
    }

    protected function prepareForValidation()
    {
        $file = $this->file('cover');
        $coverPath = $file->storeAs('covers', $file->getClientOriginalName());

        $this->merge([
            'cover_path' => $coverPath,
        ]);
    }

}
