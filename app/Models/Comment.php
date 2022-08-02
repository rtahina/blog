<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     title="Comment",
 *     description="Comment model",
 *     @OA\Xml(
 *         name="Comment"
 *     )
 * )
 */
class Comment extends Model
{
    use HasFactory;

    /**
     * @OA\Property(
     *     title="ID",
     *     description="ID",
     *     format="int64",
     *     example=1
     * )
     *
     * @var integer
     */
    private $id;

    /**
     * @OA\Property(
     *     title="Comment",
     *     description="The blog post comment",
     *     format="string",
     *     example="This is my first comment"
     * )
     *
     * @var string
     */
    private $comment;

    /**
     * @OA\Property(
     *     title="Created at",
     *     description="Creation date and time",
     *     format="date-time",
     *     example="2022-01-01 09:01:00"
     * )
     *
     * @var string
     */
    private $created_at;

    /**
     * @OA\Property(
     *     title="Created at",
     *     description="Creation date and time",
     *     format="date-time",
     *     example="2022-01-01 09:01:00"
     * )
     *
     * @var string
     */
    private $updated_at;

    /**
     * @OA\Property(
     *     title="Author object",
     *     description="The blog post author object",
     * )
     *
     * @var \App\Models\User
     */
    private $author;

    /**
     * @OA\Property(
     *     title="Post object",
     *     description="The blog post the comment is attached to",
     * )
     *
     * @var \App\Models\Post
     */
    private $post;

     /**
     * Allow mass assignment
     */
    protected $guarded = [];

    /**
     * Comment's owner
     */
    public function user() {
        return $this->belongsTo(User::class);
    }

    /**
     * The post the comment belongs to
     */
    public function post() {
        return $this->belongsTo(Post::class);
    }
}
