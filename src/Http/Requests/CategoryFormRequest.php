<?php

namespace TypiCMS\Modules\Projects\Http\Requests;

use TypiCMS\Modules\Core\Http\Requests\AbstractFormRequest;

class CategoryFormRequest extends AbstractFormRequest
{
    public function rules()
    {
        return [
            'image' => 'image|max:2000',
            'title.*' => 'max:255',
            'slug.*' => 'alpha_dash|max:255',
        ];
    }
}
