<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\RequestBody(
 *      request="StorePostRequest",
 *      required=true,
 *      @OA\JsonContent(
 *          required={"title", "body"},
 *          @OA\Property(
 *              type="string", property="title", example="This is my title"
 *          ),
 *          @OA\Property(
 *              type="string", property="body", example="This is my blog post content"
 *          )
 *      )
 * )
 */
class StorePostRequest extends FormRequest
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
            'title' => 'required|min:2|max:250',
            'body' => 'required',
            'user_id' => 'required'
        ];
    }
}
