<?php

namespace App\Services;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use App\Models\Post;

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
        return Post::findOrFail($post->id);
    }

    /**
     * Create a Post
     * 
     * @param Request $request
     * @return Vehicule|False
     */
    public function create(Request $request): ?Post
    {
        return Post::create($request->all());
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