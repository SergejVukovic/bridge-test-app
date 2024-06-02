<?php

namespace App\Http\Requests\Post;

use App\Services\PostService;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return (new PostService)->canUserUpdatePost($this->route('post'), auth()->id());
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            "title" => "string",
            "content" => "string"
        ];
    }
}
