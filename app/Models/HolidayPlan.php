<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OpenApi\Annotations as OA;

/**
 *
 *
 * @OA\Schema (
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
 *     @OA\Property(
 *          property="location",
 *          type="string",
 *          example="Paris",
 *          description="The location of the holiday plan"
 *      ),
 *
 * )
 * @OA\Schema (
 *     schema="HolidayPlanResponse",
 *     allOf={
 *         @OA\Schema(ref="#/components/schemas/HolidayPlan"),
 *         @OA\Schema(
 *              @OA\Property(
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
 * @property int $id
 * @property string $title
 * @property string $description
 * @property string $date_from
 * @property string $date_to
 * @property string $location
 * @property int $user_id
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|HolidayPlan newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|HolidayPlan newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|HolidayPlan query()
 * @method static \Illuminate\Database\Eloquent\Builder|HolidayPlan whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HolidayPlan whereDateFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HolidayPlan whereDateTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HolidayPlan whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HolidayPlan whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HolidayPlan whereLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HolidayPlan whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HolidayPlan whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HolidayPlan whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HolidayPlan whereUserId($value)
 * @mixin \Eloquent
 */
final class HolidayPlan extends Model
{
    protected $fillable = ['title', 'description', 'date_from', 'date_to', 'location', 'user_id'];
    protected $hidden = ['created_at', 'updated_at'];
    protected $guarded = ['id', 'status'];
}
