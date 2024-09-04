<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


/**
 * @OA\Schema(
 *     schema="Transaction",
 *     required={"user_id", "name", "type", "amount", "date"},
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         example=1,
 *         description="The unique identifier of the transaction"
 *     ),
 *     @OA\Property(
 *         property="user_id",
 *         type="integer",
 *         example=51,
 *         description="The ID of the user who made the transaction"
 *     ),
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         example="Sample Transaction",
 *         description="The name or title of the transaction"
 *     ),
 *     @OA\Property(
 *         property="type",
 *         type="string",
 *         example="dépense",
 *         description="The type of the transaction (revenu or dépense)"
 *     ),
 *     @OA\Property(
 *         property="amount",
 *         type="number",
 *         format="float",
 *         example=685.83,
 *         description="The amount of money involved in the transaction"
 *     ),
 *     @OA\Property(
 *         property="date",
 *         type="string",
 *         format="date",
 *         example="1992-11-16",
 *         description="The date when the transaction took place"
 *     ),
 *     @OA\Property(
 *         property="description",
 *         type="string",
 *         example="Laborum natus illo sit voluptatum.",
 *         description="A detailed description of the transaction"
 *     ),
 *     @OA\Property(
 *         property="created_at",
 *         type="string",
 *         format="date-time",
 *         example="2024-09-04T12:12:37Z",
 *         description="The timestamp when the transaction was created"
 *     ),
 *     @OA\Property(
 *         property="updated_at",
 *         type="string",
 *         format="date-time",
 *         example="2024-09-04T12:12:37Z",
 *         description="The timestamp when the transaction was last updated"
 *     )
 * )
 */


class Transaction extends Model
{
    use HasFactory;


    protected $fillable = [
        'user_id',
        'name',
        'type',
        'amount',
        'date',
        'description',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
