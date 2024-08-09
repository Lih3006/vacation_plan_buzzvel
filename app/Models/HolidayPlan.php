<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="HolidayPlan",
 *     required={"title", "description", "date_from", "date_to", "location"},
 *     @OA\Property(
 *         property="title",
 *         type="string",
 *         example="Viagem Cultural a Europa",
 *         description="The title of the holiday plan"
 *     ),
 *     @OA\Property(
 *          property="description",
 *          type="string",
 *          example="Tour cultural por museus e galerias de arte em várias cidades da Europa.",
 *          description="The description of the holiday plan"
 *      ),
 *     @OA\Property(
 *         property="date_from",
 *         type="string",
 *         format="date",
 *         description="The start date of the holiday plan"
 *     ),
 *     @OA\Property(
 *         property="date_to",
 *         type="string",
 *         format="date",
 *         description="The end date of the holiday plan"
 *     ),
 *
 *
 *     @OA\Property(
 *          property="location",
 *          type="string",
 *          example="Paris",
 *          description="The location of the holiday plan"
 *      ),
 *
 * )
 *
 *
 * @OA\Schema(
 *     schema="HolidayPlanResponse",
 *     allOf={
 *         @OA\Schema(ref="#/components/schemas/HolidayPlan"),
 *         @OA\Schema(
 *     @OA\Property(
 *                  property="id",
 *                  type="integer",
 *                  example=1,
 *                  description="The ID of the user who created the holiday plan"
 *              ),
 *             @OA\Property(
 *                 property="status",
 *                 type="string",
 *                 example="pending",
 *                 description="The status of the holiday plan"
 *             ),
 *             @OA\Property(
 *                 property="user_id",
 *                 type="integer",
 *                 example=10,
 *                 description="The ID of the user who created the holiday plan"
 *             ),
 *         )
 *     }
 * )
 */
class HolidayPlan extends Model
{
    protected $fillable = ['title', 'description', 'date_from', 'date_to', 'location', 'user_id'];
    protected $hidden = ['created_at', 'updated_at'];
    protected $guarded = ['id', 'status'];
}
