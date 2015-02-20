<?php
namespace TypiCMS\Modules\Projects\Http\Requests;

use TypiCMS\Http\Requests\AbstractFormRequest;

class FormRequest extends AbstractFormRequest {

    public function rules()
    {
        $rules = [
            'category_id' => 'required',
            'date'        => 'date',
            'website'     => 'url',
            'image'       => 'image|max:2000|image_size:>=500',
        ];
        foreach (config('translatable.locales') as $locale) {
            $rules[$locale . '.slug'] = [
                'required_with:' . $locale . '.title',
                'required_if:' . $locale . '.status,1',
                'alpha_dash',
                'max:255',
            ];
            $rules[$locale . '.title'] = 'max:255';
        }
        return $rules;
    }

    /**
     * Sanitize inputs
     * 
     * @return array
     */
    public function sanitize()
    {
        $input = $this->all();

        // Checkboxes
        foreach (config('translatable.locales') as $locale) {
            $input[$locale]['status'] = $this->has($locale . '.status');
        }

        // add relations data (default to empty array)
        $input['galleries'] = $this->get('galleries', []);

        $this->replace($input);
        return $this->all();
    }
}
