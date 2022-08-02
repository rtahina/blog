<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

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
