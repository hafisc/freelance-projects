<?php

namespace App\Http\Requests\Api\Education;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\Education;

class UpdateEducationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user() && $this->user()->isAdmin();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $educationId = $this->route('education')?->id ?? $this->route('education');

        return [
            'title' => ['sometimes', 'required', 'string', 'max:255'],
            'slug' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('educations', 'slug')->ignore($educationId),
            ],
            'thumbnail' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
            'content' => ['sometimes', 'required', 'string'],
            'status' => ['nullable', Rule::in(['draft', 'published'])],
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'title.required' => 'Judul edukasi wajib diisi.',
            'title.max' => 'Judul edukasi maksimal 255 karakter.',
            'slug.unique' => 'Slug sudah digunakan oleh edukasi lain.',
            'thumbnail.image' => 'File thumbnail harus berupa gambar.',
            'thumbnail.mimes' => 'Format thumbnail harus jpg, jpeg, atau png.',
            'thumbnail.max' => 'Ukuran thumbnail maksimal 2MB.',
            'content.required' => 'Konten edukasi wajib diisi.',
            'status.in' => 'Status harus draft atau published.',
        ];
    }
}