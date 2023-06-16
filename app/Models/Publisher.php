<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property string $location
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class Publisher extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * Get the books published by the publisher.
     */
    public function books()
    {
        return $this->hasMany(Book::class);
    }
}
