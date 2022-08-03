<?php

namespace App\Services;

use App\Models\Post;
use App\Models\Comment;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;
use phpDocumentor\Reflection\PseudoTypes\False_;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CommentService
{
    /**
     * Retrieve paginated Comment models. Search parameters maybe provided
     *
     * @param int $CommentId
     * @param string $orderBy
     * @param string $orderDirection
     * @param int $perPage 
     * @return LengthAwarePaginator
     */
    
    public function all(int $postId = 0, string $orderBy = "id", string $orderDirection = "ASC", int $perPage = 25): LengthAwarePaginator
    {        
        $comments = Comment::query()
                    ->orderBy($orderBy, $orderDirection)
                    ->with('user')
                    ->when($postId > 0, function ($q) use ($postId) {
                        $q->where('post_id', $postId);
                    })
                    ->when(request()->has('s'), function ($q) {
                        $q->where('comment', 'LIKE', '%' . request('s') . '%');
                    })
                    ->paginate($perPage);

        return  $comments;                      
    }

    /**
     * Find a Comment by its id
     * 
     * @param App\Models\Comment $Comment
     * @return Comment|False
     */
    public function getSingleComment(Comment $comment): ?Comment
    {
            
        $comment = Comment::findOrFail($comment->id);
        
        return $comment;
    }

    /**
     * Create a Comment
     * 
     * @param Illuminate\Http\Request; $request
     * @return Comment|False
     */
    public function create(Request $request, int $postId) 
    {
        $userId = auth()->user()->id;
        $data = [
            'user_id' => $userId,
            'post_id' => $postId,
            'comment' => request('comment'),
        ];
        
        return Comment::create($data);
    }

    /**
     * Update Comment
     * 
     * @param int $id
     * @param RIlluminate\Http\Request $request;
     * 
     * @return mixed Comment|false 
     */
    public function update(Request $request, int $postId, int $commentId): Comment|false
    {        
        $comment = Comment::findOrFail($commentId);
        $userId = auth()->user()->id;

        $data = [
            'user_id' => $userId,
            'post_id' => $postId,
            'comment' => request('comment')
        ];
        $comment->fill($data);
        
        if ($comment->save($data))
            return $comment;
        else 
            return false;
    }

    /**
     * Delete a Comment by its id
     * 
     * @param int $id
     * @return boolean
     */
    public function destroy(int $id): bool
    {
        if (Comment::find($id)) {
            return Comment::destroy($id);
        } else {
            return false;
        }
        
    }
}