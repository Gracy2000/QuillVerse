<?php

namespace App\Http\Requests\Tags;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTagRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required | min:3 | max:255 | unique:tags,name,'.$this->tag->id //Here we have to pass id of current tag ignore this id or field in validing for unique because suppose current user entered same tag name so it will not update and gives a validation error as 'this name is already taken' by passing this we are telling that except this id or field apply the unique validation rule
        ];
    }
}
