<?php

namespace App\Http\Resources;

use Illuminate\Support\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     title="CommentResource",
 *     description="Comment resource",
 *     @OA\Xml(
 *         name="CommentResource"
 *     )
 * )
 */
class CommentResource extends JsonResource
{
    /**
     * @OA\Property(
     *     title="Data",
     *     description="Data wrapper"
     * )
     *
     * @var \App\Models\Comment[]
     */
    private $data;
    
    /**
     * @OA\Property(
     *     title="Links",
     *     description="Pagination links",
     *     format="array",
     *          @OA\Items(
     *              
     *                   @OA\Property(
     *                       property="first", 
     *                       type="string",
     *                       example="https://blog.test/api/posts?page=1" 
     *                   ),
     *                   @OA\Property(
     *                       property="last", 
     *                       type="string",
     *                       example="https://blog.test/api/posts?page=3" 
     *                   ),
     *                   @OA\Property(
     *                       property="prev", 
     *                       type="string",
     *                       example="https://blog.test/api/posts?page=3" 
     *                   ),
     *                   @OA\Property(
     *                       property="next", 
     *                       type="string",
     *                       example="https://blog.test/api/posts?page=3" 
     *                   ),
     *          )
     * )
     *
     * @var array
     */
    private $links;

    /**
     * @OA\Property(
     *     title="Meta",
     *     description="Meta data",
     *     format="array",
     *          @OA\Items(
     *                   @OA\Property(
     *                       property="current_page", 
     *                       type="integer",
     *                       example=1 
     *                   ),
     *                   @OA\Property(
     *                       property="from", 
     *                       type="integer",
     *                       example=0 
     *                   ),
     *                   @OA\Property(
     *                       property="last_page", 
     *                       type="integer",
     *                       example=5 
     *                   ),
     *                   @OA\Property(
     *                       property="links", 
     *                       type="array",
     *                       @OA\Items(
     *                           @OA\Property(
     *                               property="url", 
     *                               type="string",
     *                               example="http://blog.test/api/comments?page=1"
     *                           ),
     *                           @OA\Property(
     *                               property="label", 
     *                               type="string",
     *                               example="&laquo; Previous"
     *                           ),
     *                           @OA\Property(
     *                               property="active", 
     *                               type="boolean",
     *                               example=true
     *                           ),
     *                       ) 
     *                   ),
     *                   @OA\Property(
     *                        property="path",
     *                        type="string",
     *                        example="http://blog.test/api/comments"
     *                   ),
     *                   @OA\Property(
     *                        property="per_page",
     *                        type="integer",
     *                        example=10
     *                   ),
     *                   @OA\Property(
     *                        property="to",
     *                        type="integer",
     *                        example=10
     *                   ),
     *                   @OA\Property(
     *                        property="total",
     *                        description="Total number of comments",
     *                        type="integer",
     *                        example=100
     *                   )
     *          )
     * )
     *
     * @var array
     */
    private $meta;

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        return [
            'id' => $this->id,
            'comment' => $this->comment,
            'created_at' => Carbon::parse($this->create_at)->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::parse($this->updated_at)->format('Y-d-m H:i:s'),
            'author' => new UserResource($this->user),
            'post' => new PostResource($this->post)
        ];
    }
}
