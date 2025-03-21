<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\ResourceStoreRequest;
use App\Http\Resources\ResourceResource;
use App\Models\Resource;
use App\Services\ResourceService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use OpenApi\Annotations as OA;


/**
 * @OA\Tag(
 *     name="Resources",
 *     description="API для добавления, обновления, удаления и вывода Resources"
 * )
 */
class ResourceController extends Controller
{
    public function __construct(protected ResourceService $resourceService)
    {
        //
    }


    /**
     * @OA\Get(
     *      path="/api/resources",
     *      summary="Display a listing of the resource",
     *      tags={"Resources"},
     *      @OA\Response(
     *          response=200,
     *          description="OK",
     *     )
     * )
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        return ResourceResource::collection($this->resourceService->getAll());
    }

    /**
     * @OA\Post(
     *      path="/api/resources",
     *      summary="Store a newly created resource in storage",
     *      tags={"Resources"},
     *       @OA\Parameter(
     *             name="name",
     *             in="query",
     *             required=true,
     *             @OA\Schema(type="string")
     *        ),
     *        @OA\Parameter(
     *              name="type",
     *              in="query",
     *              required=true,
     *              @OA\Schema(type="string")
     *        ),
     *        @OA\Parameter(
     *              name="description",
     *              in="query",
     *              required=false,
     *              @OA\Schema(type="string")
     *        ),
     *      @OA\Response(
     *          response=201,
     *          description="OK"
     *     ),
     *      @OA\Response(
     *          response=422,
     *          description="Validation errors",
     *      )
     * )
     */
    public function store(ResourceStoreRequest $request): JsonResponse
    {
        $resource = $this->resourceService->create($request->validated());

        return response()->json(new ResourceResource($resource))->setStatusCode(201);
    }

    /**
     * @OA\Get(
     *      path="/api/resources/{id}",
     *      summary="Display the specified resource",
     *      tags={"Resources"},
     *      @OA\Parameter(
     *            name="id",
     *            in="path",
     *            required=true,
     *            @OA\Schema(type="integer")
     *        ),
     *      @OA\Response(
     *          response=200,
     *          description="OK"
     *     ),
     *      @OA\Response(
     *          response=404,
     *          description="Not Found"
     *      )
     * )
     */
    public function show(Resource $resource): ResourceResource
    {
        return new ResourceResource($resource);
    }


    /**
     * @OA\Patch(
     *      path="/api/resources/{id}",
     *      summary="Update the specified resource in storage",
     *      tags={"Resources"},
     *      @OA\Parameter(
     *           name="id",
     *           in="path",
     *           required=true,
     *           @OA\Schema(type="integer")
     *       ),
     *      @OA\Parameter(
     *            name="name",
     *            in="query",
     *            required=true,
     *            @OA\Schema(type="string")
     *       ),
     *       @OA\Parameter(
     *             name="type",
     *             in="query",
     *             required=true,
     *             @OA\Schema(type="string")
     *       ),
     *       @OA\Parameter(
     *             name="description",
     *             in="query",
     *             required=false,
     *             @OA\Schema(type="string")
     *       ),
     *      @OA\Response(
     *          response=200,
     *          description="OK"
     *     ),
     *      @OA\Response(
     *          response=404,
     *          description="Not Found"
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="Validation errors"
     *      )
     * )
     */
    public function update(ResourceStoreRequest $request, Resource $resource): ResourceResource
    {
        $this->resourceService->update($resource->getAttribute('id'), $request->validated());

        return new ResourceResource($resource->fresh());
    }

    /**
     * @OA\Delete(
     *      path="/api/resources/{id}",
     *      summary="Remove the specified resource from storage",
     *      tags={"Resources"},
     *      @OA\Parameter(
     *            name="id",
     *            in="path",
     *            required=true,
     *            @OA\Schema(type="integer")
     *        ),
     *      @OA\Response(
     *          response=204,
     *          description="OK"
     *     ),
     *     @OA\Response(
     *          response=404,
     *          description="Not Found"
     *      )
     * )
     */
    public function destroy(Resource $resource): JsonResponse
    {
        $this->resourceService->delete($resource->getAttribute('id'));

        return response()->json(['status' => 'ok'])->setStatusCode(204);
    }
}
