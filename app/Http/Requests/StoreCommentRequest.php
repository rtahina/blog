<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\RequestBody(
 *      request="StoreCommentRequest",
 *      required=true,
 *      @OA\JsonContent(
 *          required={"comment"},
 *          @OA\Property(
 *              type="string", property="comment"
 *          )
 *      )
 * )
 */
class StoreCommentRequest extends FormRequest
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
            'comment' => 'required'
        ];
    }
}
