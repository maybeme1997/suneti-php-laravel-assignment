<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property string|null $bio
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class Writer extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * Get the books written by the writer.
     */
    public function books()
    {
        return $this->hasMany(Book::class);
    }
}
