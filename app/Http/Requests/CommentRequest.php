<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CommentRequest extends FormRequest
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
            //
            'fullname' => ['required','string'],
            'email' => ['required','email'],
            'phone' => ['nullable','numeric'],
            'text' => ['required','string'],
            'post_id'=> ['required','exists:posts,id'],
            'captcha_num' => ['required', 'numeric', function ($attribute, $value, $fail) {
                if (session('captcha_num') != $value)
                        $fail(__('site.security_code_problem'));
            }]
        ];
    }
}
