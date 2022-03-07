<?php

namespace App\Modules\Sonet\Models;

use App\Http\Resources\Exceptions\ValidationFailedResource;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;

/**
 * @property int|string|null id
 * @property string title
 * @property int|string note_id
 * @property string path
 * @property int created_at
 * @property int updated_at
 *
 * @property Note note
 *
 * @mixin Builder
 */
class Attachment extends Model
{
    use HasFactory;

    protected $connection = 'sonet';



    /*
    |--------------------------------------------------
    | Mass assignment
    |--------------------------------------------------
    */

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'title',
        'path',
        'note_id',
    ];



    /*
    |--------------------------------------------------
    | Methods
    |--------------------------------------------------
    */

    /**
     * Create new attachment for the note and save it
     *
     * @param UploadedFile $file
     * @param $note_id
     * @return ValidationFailedResource|Attachment
     */
    public static function new(UploadedFile $file, $note_id)
    {
        $path = $file->storePubliclyAs('sonet/attachments', Hash::make($file->getClientOriginalName()) . '.' . $file->getClientOriginalExtension());
        if (!$path) return ValidationFailedResource::make([ 'attachment' => 'Не удалось сохранить ваш файл' ]);

        $attachment = new self([
            'title' => $file->getClientOriginalName(),
            'path' => $path,
            'note_id' => $note_id,
        ]);
        $attachment->save();

        return $attachment;
    }



    /*
    |--------------------------------------------------
    | Relations
    |--------------------------------------------------
    */

    /**
     * Attachment's note
     *
     * @return BelongsTo
     */
    public function note(): BelongsTo
    {
        return $this->belongsTo(Note::class, 'note_id', 'id');
    }
}
