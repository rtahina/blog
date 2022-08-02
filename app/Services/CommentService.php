<?php

namespace App\Services;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Support\Str;
use phpDocumentor\Reflection\PseudoTypes\False_;

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
    
    public function all(int $CommentId = 0, string $orderBy = "id", string $orderDirection = "ASC", int $perPage = 25): LengthAwarePaginator
    {        
        $Comments = Comment::orderBy($orderBy, $orderDirection)
                    ->with('user')
                    ->with('post')
                    ->when($CommentId > 0, function ($q, $CommentId) {
                        $q->where('Comment_id', $CommentId);
                    })
                    ->when(request()->has('title'), function ($q, $value) {
                        $q->where('title', 'LIKE', '%' . request('title') . '%');
                    })
                    ->when(request()->has('body'), function ($q, $value) {
                        $q->where('body', 'LIKE', '%' . request('body') . '%');
                    })
                    ->paginate($perPage);
        
        return  $Comments;                      
    }

    /**
     * Find a Comment by its id
     * 
     * @param App\Models\Comment $Comment
     * @return Comment|False
     */
    public function getSingleComment(Comment $Comment): ?Comment
    {
            
        $Comment = Comment::findOrFail($Comment->id);
        
        return $Comment;
    }

    /**
     * Create a Comment
     * 
     * @param Illuminate\Http\Request; $request
     * @return Comment|False
     */
    public function create(Request $request): ?Comment
    {
        $title = request('title');
        $slug = request('slug') ?? Str::slug($title);

        $data = [
            'user_id' => request('user_id'),
            'title' => $title,
            'slug' => $slug,
            'body' => request('body')
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
    public function update(int $id, Request $request): Comment|false
    {        
        $Comment = Comment::findOrFail($id);
        
        $title = request('title');
        $slug = request('slug') ?? Str::slug($title);

        $data = [
            'user_id' => request('user_id'),
            'title' => $title,
            'slug' => $slug,
            'body' => request('body')
        ];
        $Comment->fill($data);
        
        if ($Comment->save($data))
            return $Comment;
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