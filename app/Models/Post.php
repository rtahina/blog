<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     title="Post",
 *     description="Post model",
 *     @OA\Xml(
 *         name="Post"
 *     )
 * )
 */

class Post extends Model
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
     *     title="Author ID",
     *     description="The blog post author ID",
     *     format="integer",
     *     example=22
     * )
     *
     * @var string
     */
    private $author_id;

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
     * Allow mass assignment
     */
    protected $guarded = [];

    /**
     * Post's owner
     */
    public function user() {
        return $this->belongsTo(User::class);
    }

    /**
     * Post's comments
     */
    public function comments() {
        return $this->hasMany(Comment::class);
    }
}
