<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\StoreHolidayPlanRequest;
use App\Models\HolidayPlan;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use OpenApi\Annotations as OA;
use phpDocumentor\Reflection\File;

final class HolidayPlanController
{
    /**
     * @OA\Info(
     *    title="Holiday Plan API",
     *    version="1.0",
     *    description="API for managing holidays",
     *    @OA\Contact(
     *      email="support@holidayapi.com",
     *      name="Support Team"
     *    )
     *  )
     * @OA\SecurityScheme(
     *     securityScheme="bearerAuth",
     *     type="http",
     *     scheme="bearer",
     *     bearerFormat="JWT",
     *     description="Autenticação necessária. Use 'Bearer {token}' no campo de autorização."
     * )
     * @OA\SecurityRequirement(
     *     {"bearerAuth": {}}
     * )
     *
     * @OA\Get(
     *     path="/api/holidays",
     *     summary="Get all holiday plans",
     *     tags={"Holiday Plans"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/HolidayPlanResponse")
     *         )
     *     )
     * )
     */

    public function index(): Collection
    {
        return HolidayPlan::all();
    }

    /**
     * @OA\Post(
     *     path="/api/holidays",
     *     summary="Create a new holiday plan",
     *     tags={"Holiday Plans"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/HolidayPlan")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/HolidayPlan")
     *         )
     *     )
     * )
     */

    public function store(StoreHolidayPlanRequest $request): HolidayPlan
    {
        $holidayPlan = $request->validated();
        $holidayPlan['user_id'] = auth()->id();
        $holidayPlan['date_from'] = date('Y-m-d', strtotime($holidayPlan['date_from']));
        $holidayPlan['date_to'] = date('Y-m-d', strtotime($holidayPlan['date_to']));
        $holidayPlan['status'] = 'pending';

        return HolidayPlan::create($holidayPlan);
    }

    /**
     * @OA\Get(
     *     path="/api/holidays/{id}",
     *     summary="Get a holiday plan",
     *     tags={"Holiday Plans"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the holiday plan",
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(ref="#/components/schemas/HolidayPlanResponse")
     *     ),
     *
     *      @OA\Response(
     *          response=404,
     *          description="Holiday plan not found",
     *              @OA\JsonContent(
     *                  type="array",
     *                  @OA\Items(
     *                      type="object",
     *                      example={"message":"Holiday plan not found"}
     *                  )
     *              )
     *      ),
     *       @OA\Response(
     *           response=401,
     *           description="Unauthorized",
     *           @OA\JsonContent(
     *              type="array",
     *              @OA\Items(
     *                  type="object",
     *                  example={"message":"Unauthorized"}
     *            )
     *           )
     *        ),
     *  )
     */
    public function show(string $id): HolidayPlan | JsonResponse
    {
        $holidayPlan = HolidayPlan::find($id);

        if (!$holidayPlan) {
            return response()->json(['message' => 'Holiday plan not found'], 404);
        }

        return HolidayPlan::find($id);
    }

    /**
     * @OA\Get(
     *    path="/api/holiday/{id}/pdf",
     *    summary="Get a holiday plan in PDF",
     *    tags={"Holiday Plans"},
     *    security={{"bearerAuth":{}}},
     *    @OA\Parameter(
     *        name="id",
     *        in="path",
     *        required=true,
     *        description="ID of the holiday plan",
     *    ),
     *    @OA\Response(
     *        response=200,
     *        description="Success",
     *        @OA\MediaType(
     *            mediaType="application/pdf",
     *        )
     *    ),
     * )
     */
    public function getHolidayPdf($id): Response | JsonResponse
    {
        $holidayPlan = HolidayPlan::find($id);

        if (!$holidayPlan) {
            return response()->json(['message' => 'Holiday plan not found'], 404);
        }

        return PDF::loadView('holiday', ['holidayPlan' => $holidayPlan])->download('holidaysPlans.pdf');
    }


    /**
     * @OA\Get(
     *     path="/api/holiday/pdf",
     *     summary="Get all holiday plans in PDF",
     *     tags={"Holiday Plans"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\MediaType(
     *              mediaType="application/pdf",
     *          )
     *     ),
     * )
     */
    public function getHolidaysPdf():Response
    {
        $holidayPlans = HolidayPlan::all();

        return PDF::loadView('holidays_list', ['holidayPlans' => $holidayPlans])
            ->download('holidayPlans.pdf');
    }


    /**
     *
     * @OA\Put(
     *     path="/api/holidays/{id}",
     *     summary="Update a holiday plan",
     *     tags={"Holiday Plans"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the holiday plan",
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/HolidayPlan")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(ref="#/components/schemas/HolidayPlanResponse")
     *     ),
     *
     *      @OA\Response(
     *          response=404,
     *          description="Holiday plan not found",
     *          @OA\JsonContent(
     *              type="array",
     *              @OA\Items(
     *                  type="object",
     *                  example={"message":"Holiday plan not found"}
     *              )
     *          )
     *      ),
     *       @OA\Response(
     *          response=401,
     *          description="Unauthorized",
     *          @OA\JsonContent(
     *              type="array",
     *              @OA\Items(
     *                  type="object",
     *                  example={"message":"Unauthorized"}
     *              )
     *          )
     *      ),
     * )
     */
    public function update(StoreHolidayPlanRequest $request, string $id): JsonResponse | HolidayPlan
    {
        $holidayPlan = $request->validated();
        $holidayPlan['date_from'] = date('y-m-d', strtotime($holidayPlan['date_from']));
        $holidayPlan['date_to'] = date('y-m-d', strtotime($holidayPlan['date_to']));

        $finalHolidayPlan = HolidayPlan::find($id);

        if (!$finalHolidayPlan) {
            return response()->json(['message' => 'Holiday plan not found'], 404);
        }

        if ($finalHolidayPlan->user_id !== auth()->id()) {
            return response()->json(['message' => 'ou do not have permission to update this holiday plan'], 401);
        }

        $finalHolidayPlan->update($holidayPlan);

        return $finalHolidayPlan;
    }


    /**
     * @OA\Delete(
     *     path="/api/holidays/{id}",
     *     summary="Delete a holiday plan",
     *     tags={"Holiday Plans"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the holiday plan",
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(
     *             type="array",
     *            @OA\Items(
     *                  type="object",
     *                  example={"message":"Holiday plan deleted successfully"}
     *              )
     *         )
     *     ),
     *      @OA\Response(
     *         response=404,
     *         description="Holiday plan not found",
     *         @OA\JsonContent(
     *              type="array",
     *              @OA\Items(
     *                  type="object",
     *                  example={"message":"Holiday plan not found"}
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthorized",
     *          @OA\JsonContent(
     *              type="array",
     *              @OA\Items(
     *                  type="object",
     *                  example={"message":"Unauthorized"}
     *              )
     *          )
     *       ),
     *
     * )
     */
    public function destroy(string $id): array | JsonResponse
    {
        $holidayPlan = HolidayPlan::find($id);

        if (!$holidayPlan) {
            return response()->json(['message' => 'Holiday plan not found'], 404);
        }

        $holidayPlan->delete();

        return ['message' => 'Holiday plan deleted successfully'];
    }
}
