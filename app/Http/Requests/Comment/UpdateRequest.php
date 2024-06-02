<?php

namespace App\Http\Requests\Comment;

use App\Services\CommentService;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return (new CommentService)->canUserUpdateComment($this->route('comment_id'), auth()->id());
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            "content" => "string",
        ];
    }
}
