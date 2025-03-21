<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\BookingStoreRequest;
use App\Http\Resources\BookingResource;
use App\Models\Booking;
use App\Services\BookingService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use OpenApi\Annotations as OA;

/**
 * @OA\Tag(
 *     name="Bookings",
 *     description="API для добавления, обновления, удаления и вывода Bookings"
 * )
 */
class BookingController extends Controller
{
    protected const MODEL_RELATIONS = ['resource', 'user'];

    public function __construct(protected BookingService $bookingService)
    {
        //
    }


    /**
     * @OA\Get(
     *     path="/api/bookings",
     *     summary="Display a listing of the resource",
     *     tags={"Bookings"},
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *     )
     * )
     */
    public function index(): AnonymousResourceCollection
    {
        return BookingResource::collection($this->bookingService->getAll(static::MODEL_RELATIONS));
    }

    /**
     * @OA\Post(
     *     path="/api/bookings",
     *     summary="Store a newly created resource in storage",
     *     tags={"Bookings"},
     *         @OA\Parameter(
     *              name="resource_id",
     *              in="query",
     *              required=true,
     *              @OA\Schema(type="integer")
     *         ),
     *         @OA\Parameter(
     *               name="user_id",
     *               in="query",
     *               required=true,
     *               @OA\Schema(type="integer")
     *         ),
     *         @OA\Parameter(
     *               name="start_time",
     *               in="query",
     *               required=true,
     *               @OA\Schema(type="string")
     *         ),
     *         @OA\Parameter(
     *                name="end_time",
     *                in="query",
     *                required=true,
     *                @OA\Schema(type="string")
     *          ),
     *     @OA\Response(
     *         response=201,
     *         description="Created",
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation errors",
     *     )
     * )
     */
    public function store(BookingStoreRequest $request): JsonResponse
    {
        try {
            $booking = $this->bookingService->create($request->validated());
        } catch (\Throwable $th) {
            return response()->json(['status' => $th->getMessage()])->setStatusCode(422);
        }

        return response()->json(new BookingResource($booking))->setStatusCode(201);
    }

    /**
     * @OA\Get(
     *     path="/api/bookings/{id}",
     *     summary="Display the specified resource",
     *     tags={"Bookings"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Not Found",
     *     )
     * )
     */
    public function show(Booking $booking): BookingResource
    {
        return new BookingResource($booking->load(static::MODEL_RELATIONS));
    }

    /**
     * @OA\Patch(
     *     path="/api/bookings/{id}",
     *     summary="Update the specified resource in storage",
     *     tags={"Bookings"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *          @OA\Parameter(
     *               name="resource_id",
     *               in="query",
     *               required=true,
     *               @OA\Schema(type="integer")
     *          ),
     *          @OA\Parameter(
     *                name="user_id",
     *                in="query",
     *                required=true,
     *                @OA\Schema(type="integer")
     *          ),
     *          @OA\Parameter(
     *                name="start_time",
     *                in="query",
     *                required=true,
     *                @OA\Schema(type="string")
     *          ),
     *          @OA\Parameter(
     *                 name="end_time",
     *                 in="query",
     *                 required=true,
     *                 @OA\Schema(type="string")
     *           ),
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Not Found",
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation errors",
     *     )
     * )
     */
    public function update(BookingStoreRequest $request, Booking $booking): BookingResource
    {
        $this->bookingService->update($booking->getAttribute('id'), $request->validated());

        return new BookingResource($booking->fresh());
    }

    /**
     * @OA\Delete(
     *     path="/api/bookings/{id}",
     *     summary="Remove the specified resource from storage",
     *     tags={"Bookings"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="OK",
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Not Found",
     *     )
     * )
     */
    public function destroy(Booking $booking): JsonResponse
    {
        $this->bookingService->delete($booking->getAttribute('id'));

        return response()->json(['status' => 'ok'])->setStatusCode(204);
    }
}
