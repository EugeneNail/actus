<?php

namespace App\Models;

use App\Enums\Transaction\Category;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property Carbon $date
 * @property float $value
 * @property Category $category
 * @property int $sign
 * @property string $description
 */
class Transaction extends Model
{
    use HasFactory;

    public $timestamps = false;

    public $fillable = [
        'date',
        'value',
        'category',
        'sign',
        'description'
    ];


    protected $hidden = [
        'user_id'
    ];


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }


    protected function casts(): array
    {
        return [
            'category' => Category::class
        ];
    }
}
