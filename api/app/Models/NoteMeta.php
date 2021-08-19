<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NoteMeta extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'meta_key',
        'meta_value'
    ];

    /**
     * The note pertaining to this meta
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function note(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Note::class);
    }

    /**
     * Update meta
     *
     * @param $value
     * @return bool
     */
    public function updateValue($value): bool
    {
        return $this->update(['meta_value' => $value]);
    }
}
