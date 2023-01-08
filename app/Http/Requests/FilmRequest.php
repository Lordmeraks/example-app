<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FilmRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'filters' => 'array',
            'search' => 'string|nullable'
        ];
    }

    public function getFilters(): array
    {
        $validated = $this->safe()->only(['filters']);
        return $validated['filters'];
    }

    public function getSearch(): array
    {
        $validated = $this->safe()->only(['search']);
        return explode(' ', $validated['search']);
    }
}
