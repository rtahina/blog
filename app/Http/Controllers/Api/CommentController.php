<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Http\Requests\StoreCommentRequest;
use App\Http\Resources\CommentResource;
use Illuminate\Http\Request;
use App\Services\CommentService;

class CommentController extends Controller
{
    protected $commentService;

    public function __construct(CommentService $commentService)
    {
        $this->commentService = $commentService;
    }
    
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    /**
     * @OA\Get(
     *      path="/comments",
     *      operationId="indexComment",
     *      tags={"Comments"},
     *      summary="Gets list of comments",
     *      description="Returns all comments",
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
     *          @OA\JsonContent(ref="#/components/schemas/CommentResource")
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
    public function index(Request $request)
    {
        $comments = $this->commentService->all(0, 'id', 'DESC');
        return CommentResource::collection($comments);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param int $postId
     * @param  \App\Http\Requests\StoreCommentRequest  $request
     * @return \Illuminate\Http\Response
     */
    /**
     * @OA\Post(
     *      path="/posts/{id}/comments",
     *      security={"bearer"},
     *      operationId="createPostComment",
     *      tags={"Comments"},
     *      summary="Creates a comment",
     *      description="Creates a comment for a blog post",
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
     *          ref="#/components/requestBodies/StoreCommentRequest"         
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
    public function store(StoreCommentRequest $request, int $postId)
    {
        $comment = $this->commentService->create($request, $postId);
        
        return new CommentResource($comment);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\StoreCommentRequest  $request
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    /**
     * @OA\Put(
     *      path="/posts/{postId}/comments/{commentId}",
     *      security={"bearer"},
     *      operationId="updatePostComment",
     *      tags={"Comments"},
     *      summary="Updates a comment",
     *      description="Updates a comment for a blog post",
     *      @OA\Parameter(
     *          name="postId",
     *          description="Post ID",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     * *      @OA\Parameter(
     *          name="commentId",
     *          description="Comment ID",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\RequestBody(
     *          ref="#/components/requestBodies/StoreCommentRequest"         
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
    public function update(StoreCommentRequest $request, int $postId, int $commetId)
    {
        $comment = $this->commentService->update($request, $postId, $commetId);
        if (false !== $comment)
            return new CommentResource($comment);
        else 
            return Response(
                array(
                    'success' => false,
                    'message' => 'Update failed'
                ),
                500
            );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    /**
     * @OA\Delete(
     *      path="/comments/{id}",
     *      operationId="deleteComment",
     *      security={"bearer"},
     *      tags={"Comments"},
     *      summary="Deletes a comment",
     *      description="Deletes a comment",
     *      @OA\Parameter(
     *          name="id",
     *          description="Comment ID",
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
     *                         example="Comment successfully deleted"
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
    public function destroy(int $id)
    {
        $delete = $this->commentService->destroy($id);

        $success = $delete;
        $message = ($delete)? 'Comment successfuly deleted' : 'Comment could not be deleted';

        return Response(
            array(
                'success' => $success,
                'message' => $message
            ),
            200
        );
    }
}
