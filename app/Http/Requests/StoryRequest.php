<?php

namespace App\Http\Requests;

use Illuminate\Auth\Events\Failed;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class StoryRequest extends FormRequest
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
        // Lay story.id doi voi edit
        $storyId = $this->route('story.id');

        return [
            'title' => [
                'required', 'max:50',
                // customer
                function ($attribute, $value, $fail) {
                    if($value === 'error') {
                        $fail($attribute.' is not valid');
                    }
                },
                Rule::unique('stories')->ignore($storyId)
            ],
            'body' => 'required',
            'type' => 'required',
            'status' => 'required' 
        ];
    }

    public function withValidator($validator) {
        // body co doi dai length > 500 thi type khong duoc bang short
        $validator->sometimes('body', 'max:500', function ($attribute) {
            return 'short' == $attribute->type;
        });
    }


    public function messages() {
        return [
            'title.required' => 'You must enter :attribute',
            'required' => 'Please enter :attribute'
        ];
    }
}
