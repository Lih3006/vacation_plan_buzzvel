<?php

declare(strict_types=1);

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use OpenApi\Annotations as OA;

/**
 *
 *
 * @OA\Schema (
 *    schema="User",
 *    required={"name", "email", "password"},
 *    @OA\Property(
 *        property="name",
 *        type="string",
 *        description="The name of the user"
 *    ),
 *    @OA\Property(
 *        property="email",
 *        type="string",
 *        format="email",
 *        description="The email of the user"
 *    ),
 *    @OA\Property(
 *       property="password",
 *       type="string",
 *       format="password",
 *       description="The password of the user"
 *   ),
 * )
 * @OA\Schema (
 *      schema="UserResponse",
 *      @OA\Property(
 *      property="id",
 *      type="integer",
 *      example=1,
 *      description="The ID of the user"
 *      ),
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         description="The name of the user"
 *     ),
 *     @OA\Property(
 *         property="email",
 *         type="string",
 *         format="email",
 *         description="The email of the user"
 *     ),
 *      @OA\Property(
 *         property="email_verified_at",
 *         type="string",
 *         format="date-time",
 *         description="The date and time the user's email was verified"
 *      ),
 *      @OA\Property(
 *         property="role_id",
 *         type="integer",
 *         example=1,
 *         description="The ID of the role of the user"
 *      ),
 *      @OA\Property (
 *         property="created_at",
 *         type="string",
 *         format="date-time",
 *         description="The date and time the user was created"
 *      ),
 *      @OA\Property (
 *         property="updated_at",
 *         type="string",
 *         format="date-time",
 *         description="The date and time the user was updated"
 *      ),
 *
 *   )
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property int $role_id
 * @property mixed $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Sanctum\PersonalAccessToken> $tokens
 * @property-read int|null $tokens_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRoleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @mixin \Eloquent
 */
final class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['name', 'email', 'password',];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = ['password', 'remember_token',];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return ['email_verified_at' => 'datetime', 'password' => 'hashed',];
    }
}
