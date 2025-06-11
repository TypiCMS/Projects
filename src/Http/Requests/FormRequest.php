<?php

namespace TypiCMS\Modules\Projects\Http\Requests;

use TypiCMS\Modules\Core\Http\Requests\AbstractFormRequest;

class FormRequest extends AbstractFormRequest
{
    /** @return array<string, string> */
    public function rules(): array
    {
        return [
            'category_id' => 'required',
            'date' => 'required|date_format:Y-m-d',
            'website' => 'nullable|url|max:255',
            'image_id' => 'nullable|integer',
            'og_image_id' => 'nullable|integer',
            'title.*' => 'nullable|max:255',
            'slug.*' => 'nullable|alpha_dash|max:255|required_if:status.*,1|required_with:title.*',
            'status.*' => 'boolean',
            'summary.*' => 'nullable|max:1000',
            'body.*' => 'nullable|max:20000',
        ];
    }
}
