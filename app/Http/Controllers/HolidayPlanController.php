<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreHolidayPlanRequest;
use App\Models\HolidayPlan;
use Barryvdh\DomPDF\Facade\Pdf;
use OpenApi\Annotations as OA;

class HolidayPlanController extends Controller
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
     *
     */

    public function index()
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

    public function store(StoreHolidayPlanRequest $request)
    {
        $holidayPlan = $request->validated();
        $holidayPlan['user_id'] = auth()->id();
        $holidayPlan['date_from'] = date('y-m-d', strtotime($holidayPlan['date_from']));
        $holidayPlan['date_to'] = date('y-m-d', strtotime($holidayPlan['date_to']));
        $holidayPlan['status'] = 'pending';

        $finalHolidayPlan = HolidayPlan::create($holidayPlan);

        return [$finalHolidayPlan];
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
     *  @OA\Response(
     *      response=404,
     *      description="Holiday plan not found",
     *      @OA\JsonContent(
     *      type="array",
     *      @OA\Items(
     *      type="object",
     *      example={"message":"Holiday plan not found"}
     *      )
     *     )
     *  ),
     *       @OA\Response(
     *       response=401,
     *       description="Unauthorized",
     *       @OA\JsonContent(
     *       type="array",
     *       @OA\Items(
     *       type="object",
     *       example={"message":"Unauthorized"}
     *        ))),
     * )
     */
    public function show(string $id)
    {
        $holidayPlan = HolidayPlan::find($id);
        if (!$holidayPlan) {
            return response()->json(['message' => 'Holiday plan not found'], 404);
        }
        return HolidayPlan::find($id);
    }


    public function getHolidayPdf($id)
    {
        $holidayPlan = HolidayPlan::find($id);

        $pdf = PDF::loadView('holiday', ['holidayPlan' => $holidayPlan]);
        return $pdf->download('holidaysPlans.pdf');
    }

    public function getHolidaysPdf()
    {
        $holidayPlans = HolidayPlan::all();
        $pdf = PDF::loadView('holidays_list', ['holidayPlans' => $holidayPlans]);
        return $pdf->download('holidayPlans.pdf');
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
     *  @OA\Response(
     *      response=404,
     *      description="Holiday plan not found",
     *      @OA\JsonContent(
     *      type="array",
     *      @OA\Items(
     *      type="object",
     *      example={"message":"Holiday plan not found"}
     *      )
     *     )
     *  ),
     *       @OA\Response(
     *       response=401,
     *       description="Unauthorized",
     *       @OA\JsonContent(
     *       type="array",
     *       @OA\Items(
     *       type="object",
     *       example={"message":"Unauthorized"}
     *        ))),
     * )
     */
    public function update(StoreHolidayPlanRequest $request, string $id)
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
     * @OA\Response(
     *     response=404,
     *     description="Holiday plan not found",
     *     @OA\JsonContent(
     *     type="array",
     *     @OA\Items(
     *     type="object",
     *     example={"message":"Holiday plan not found"}
     *     )
     *    )
     * ),
     *      @OA\Response(
     *      response=401,
     *      description="Unauthorized",
     *      @OA\JsonContent(
     *      type="array",
     *      @OA\Items(
     *      type="object",
     *      example={"message":"Unauthorized"}
     *       ))),
     *
     * )
     */
    public function destroy(string $id)
    {
        $holidayPlan = HolidayPlan::find($id);
        if (!$holidayPlan) {
            return response()->json(['message' => 'Holiday plan not found'], 404);
        }
        $holidayPlan->delete();

        return ['message' => 'Holiday plan deleted successfully'];
    }
}
