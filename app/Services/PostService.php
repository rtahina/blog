<?php

namespace App\Services;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Str;

class PostService
{
    /**
     * Retrieve paginated Post models. Search parameters maybe provided
     *
     * @param string $orderBy
     * @param string $orderDirection
     * @param int $perPage 
     * @return LengthAwarePaginator
     */
    
    public function all(string $orderBy = "id", string $orderDirection = "ASC", int $perPage = 10): LengthAwarePaginator
    {        
        $Posts = Post::orderBy($orderBy, $orderDirection)
                    ->with('user')
                    ->when(request()->has('title'), function ($q, $value) {
                        $q->where('title', 'LIKE', '%' . request('title') . '%');
                    })
                    ->when(request()->has('body'), function ($q, $value) {
                        $q->where('body', 'LIKE', '%' . request('body') . '%');
                    })
                    ->paginate($perPage);
        
        return  $Posts;                      
    }

    /**
     * Find a Post by its id
     * 
     * @param App\Models\Post $post
     * @return Post|False
     */
    public function getSinglePost(Post $post): ?Post
    {
        try {
            $post = Post::findOrFail($post->id);
        } catch(ModelNotFoundException $e) {
            return Response(
                ['error' => $e->getMessage()],
                404
            );
        }
        
        return $post;
    }

    /**
     * Create a Post
     * 
     * @param Request $request
     * @return Post|False
     */
    public function create(Request $request): ?Post
    {
        $title = request('title');

        $data = [
            'user_id' => request('user_id'),
            'title' => $title,
            'slug' => Str::slug($title),
            'body' => request('body')
        ];
        return Post::create($data);
    }

    public function update(int $id, Request $request): ?Post
    {        
        $Post = Post::findOrFail($id);
        
        if ($Post->update($request->all())) {
            return $Post;
        }
    }

    /**
     * Delete a Post by its id
     * 
     * @param int $id
     * @return boolean
     */
    public function destroy(int $id): bool
    {
        if (Post::find($id)) {
            return Post::destroy($id);
        } else {
            return false;
        }
        
    }
}