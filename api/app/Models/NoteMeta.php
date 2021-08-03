<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NoteMeta extends Model
{
    use HasFactory;

    protected $fillable = [
        'meta_key',
        'meta_value'
    ];

    public function note()
    {
        return $this->belongsTo(Note::class);
    }

    public function updateValue($value)
    {
        return $this->update([
            'meta_value' => $value
        ]);
    }

    public static function getFor(Note $note, $key)
    {
        return self::where([
            'note_id' => $note->id,
            'meta_key' => $key
        ])->get();
    }
}
