<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     title="UpdatePostRequest",
 *     description="Update Post request",
 *     @OA\Xml(
 *         name="UpdatePostRequest"
 *     )
 * )
 */
class UpdatePostRequest extends FormRequest
{
    
    /**
     * @OA\Property(
     *     title="ID",
     *     description="The blog post ID",
     *     format="int64",
     *     example=1
     * )
     *
     * @var string
     */
    private $id;
    /**
     * @OA\Property(
     *     title="Title",
     *     description="The blog post title",
     *     format="string",
     *     example="This is my first blog post"
     * )
     *
     * @var string
     */
    private $title;

    /**
     * @OA\Property(
     *     title="Slug",
     *     description="The blog post slug",
     *     format="string",
     *     example="this-is-my-first-blog-post"
     * )
     *
     * @var string
     */
    private $slug;

    /**
     * @OA\Property(
     *     title="Body",
     *     description="The blog post content",
     *     format="string",
     *     example="This is the content of my first blog"
     * )
     *
     * @var string
     */
    private $body;

    /**
     * @OA\Property(
     *     title="Author ID",
     *     description="The blog post's author ID",
     *     format="integer",
     *     example=10
     * )
     *
     * @var integer
     */
    private $user_id;

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
