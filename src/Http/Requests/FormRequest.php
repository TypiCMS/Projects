<?php

namespace TypiCMS\Modules\Projects\Http\Requests;

use TypiCMS\Modules\Core\Http\Requests\AbstractFormRequest;

class FormRequest extends AbstractFormRequest
{
    public function rules()
    {
        return [
            'category_id' => 'required',
            'date' => 'required|date',
            'website' => 'nullable|url|max:255',
            'image' => 'image|max:2000',
            'title.*' => 'nullable|max:255',
            'slug.*' => 'nullable|alpha_dash|max:255',
        ];
    }
}
