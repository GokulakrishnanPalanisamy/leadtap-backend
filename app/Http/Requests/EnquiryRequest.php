<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class EnquiryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'name' => trim(strip_tags($this->name)),
            'email' => strtolower(trim($this->email)),
            'message' => trim(strip_tags($this->message)),
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'min:2',
                'max:255',
            ],

            'email' => [
                'required',
                'regex:/^[^\s@]+@[^\s@]+\.[^\s@]+$/',
                'max:255',
            ],

            'phone' => [
                'required',
                'digits:10',
                'regex:/^[0-9]{10}$/',
            ],

            'wp_post_id' => [
                'required',
                'integer',
                'exists:properties,wp_post_id',
            ],

            'message' => [
                'required',
                'string',
                'min:10',
                'max:1000',
            ],
        ];
    }
}
