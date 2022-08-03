<?php

namespace App\Http\Controllers\Api;

use App\Models\Post;
use App\Services\PostService;
use App\Services\CommentService;
use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Http\Requests\StorePostRequest;
use App\Http\Resources\CommentResource;
use App\Http\Requests\UpdatePostRequest;


class PostController extends Controller
{
    protected $postService;
    protected $commentService;

    public function __construct(PostService $postService, CommentService $commentService)
    {
        $this->postService = $postService;
        $this->commentService = $commentService;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    /**
     * @OA\Get(
     *      path="/posts",
     *      operationId="index",
     *      tags={"Posts"},
     *      summary="Gets list of posts",
     *      description="Returns all posts with their author",
     *      @OA\Parameter(
     *          name="orderBy",
     *          in="query",
     *          required=false,
     *          description="Field to apply the sorting on",
     *          example="title",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="orderDirection",
     *          in="query",
     *          required=false,
     *          description="Sorting direction DESC or ASC - Default ASC",
     *          example="asc",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="perPage",
     *          in="query",
     *          required=false,
     *          description="Numbe of records per page - Default 10",
     *          example=10,
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/PostResource")
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="not found"
     *      ),
     *  )
     */
    public function index()
    {
        $posts = $this->postService->all();

        return PostResource::collection($posts);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePostRequest  $request
     * @return \Illuminate\Http\Response
     */
    /**
     * @OA\Post(
     *      path="/posts",
     *      security={"bearer"},
     *      operationId="createPost",
     *      tags={"Posts"},
     *      summary="Creates a blog post",
     *      description="Creates a blog post",
     *      @OA\RequestBody(
     *          ref="#/components/requestBodies/StorePostRequest" 
     *      ),
     *      @OA\Response(
     *          response=202,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/Post")
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Resource Not Found"
     *      )
     * )
     */
    public function store(StorePostRequest $request)
    {
        $post = $this->postService->create($request);
        
        return Response(new PostResource($post), 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    /**
     * @OA\Get(
     *      path="/posts/{id}",
     *      operationId="showPost",
     *      tags={"Posts"},
     *      summary="Shows a single blog post",
     *      description="Shows a single blog post",
     *      @OA\Parameter(
     *          name="id",
     *          description="Post ID",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *     @OA\Response(
     *          response=202,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/Post")
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Resource Not Found"
     *      )
     * )
     */
    public function show(Post $post)
    {
        $post = $this->postService->getSinglePost($post);

        if (!$post) {
            return Response([
                'message' => 'Post not found'
            ], 404);
        }

        return Response(new PostResource($post), 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\StorePostRequest  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    /**
     * @OA\Put(
     *      path="/posts/{id}",
     *      security={"bearer"},
     *      operationId="updatePost",
     *      tags={"Posts"},
     *      summary="Updates blog post",
     *      description="Updates a single blog post",
     *      @OA\Parameter(
     *          name="id",
     *          description="Post ID",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\RequestBody(
     *          ref="#/components/requestBodies/StorePostRequest" 
     *      ),
     *      @OA\Response(
     *          response=202,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/Post")
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Resource Not Found"
     *      )
     * )
     */
    public function update(StorePostRequest $request, int $id)
    {
        $post = $this->postService->update($id, $request);
        
        if ($post)
            return Response(
                new PostResource($post),
                200
            );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    /**
     * @OA\Delete(
     *      path="/posts/{id}",
     *      operationId="deletePost",
     *      security={"bearer"},
     *      tags={"Posts"},
     *      summary="Deletes a blog post",
     *      description="Deletes a blog post",
     *      @OA\Parameter(
     *          name="id",
     *          description="Post ID",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=202,
     *          description="Successful operation",
     *          content={
     *              @OA\MediaType(
     *                  mediaType="application/json",
     *                  @OA\Schema(
     *                    @OA\Property(
     *                         property="success",
     *                         type="boolean",
     *                         description="Status of the operation",
     *                         example=true
     *                   ),
     *                   @OA\Property(
     *                         property="message",
     *                         type="string",
     *                         description="The response message",
     *                         example="Post successfully deleted"
     *                   ),
     *              )    
     *              )
     *          }
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Resource Not Found"
     *      )
     * )
     */
    public function destroy(Post $post)
    {
        $delete = $this->postService->destroy($post->id);

        $success = $delete;
        $message = ($delete)? 'Post successfuly deleted' : 'Post could not be deleted';

        return Response(
            array(
                'success' => $success,
                'message' => $message
            ),
            200
        );
    }

    /**
     * Lists comments attached to a blog post.
     *
     * @param  int $id post ID
     * @return \Illuminate\Http\Response
     */
    /**
     * @OA\Get(
     *      path="/posts/{id}/comments",
     *      operationId="postComments",
     *      tags={"Comments"},
     *      summary="Lists comments on a single blog post",
     *      description="Lists comments on a single blog post",
     *      @OA\Parameter(
     *          name="id",
     *          description="Post ID",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *     @OA\Response(
     *          response=202,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/CommentResource")
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Resource Not Found"
     *      )
     * )
     */
    public function postComments(int $id)
    {
        $comments = $this->commentService->all($id);
        return CommentResource::collection($comments);
    }
}
