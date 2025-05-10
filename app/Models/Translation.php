<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @OA\Schema(
 *     schema="Translation",
 *     type="object",
 *     required={"id", "key", "content", "locale"},
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="key", type="string", example="hello"),
 *     @OA\Property(property="content", type="string", example="Hello"),
 *     @OA\Property(property="locale", type="string", example="en"),
 *     @OA\Property(property="tags", type="array", @OA\Items(type="string"))
 * )
 */
class Translation extends Model
{
    use HasFactory;

    protected $fillable = [
        'locale',
        'key',
        'content',
        'tags',
    ];

    protected $casts = [
        'tags' => 'array',
    ];
}
