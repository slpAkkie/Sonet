<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Note extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'title',
        'content'
    ];

    /**
     * The metas that are mass assignable and allowed for the serialization
     *
     * @var string[]
     */
    private array $allowed_metas = [
        'color'
    ];

    /**
     * The note author
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function author(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * The note metas
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function metas(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(NoteMeta::class);
    }

    /**
     * Check if the meta one of allowed
     *
     * @param NoteMeta|string $meta
     * @return bool
     */
    private function isAllowedMeta(NoteMeta|string $meta): bool
    {
        return in_array($meta instanceof NoteMeta ? $meta->meta_key : $meta, $this->allowed_metas);
    }

    /**
     * Get the note allowed metas
     *
     * @return array
     */
    public function getAllowedMetas(): array
    {
        return $this->metas->reduce(function ($carry, $cur) {
            if ($this->isAllowedMeta($cur)) $carry[$cur->meta_key] = $cur->meta_value;

            return $carry;
        }, []);
    }

    /**
     * Create note from the data
     *
     * @param array $data
     * @return Note
     */
    static function createFrom(array $data): Note
    {
        $note = new Note($data);
        $note->author_id = Auth::id();
        $note->save();

        $data['meta'] && $note->setMetas($data['meta'], true);

        return $note;
    }

    /**
     * Update the note from the request
     *
     * @param array $data
     * @return Note
     */
    public function updateFrom(array $data): Note
    {
        $this->update($data);
        if ($data['meta']) $this->setMetas($data['meta'], true);

        return $this;
    }

    /**
     * Get the note meta
     *
     * @param string $key
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getMeta(string $key): \Illuminate\Database\Eloquent\Collection
    {
        return NoteMeta::where([
            'note_id' => $this->id,
            'meta_key' => $key
        ])->get();
    }

    /**
     * Set meta for the note
     *
     * @param string $key
     * @param string $value
     * @param bool $override
     * @return string
     */
    public function setMeta(string $key, string $value, bool $override = false): string
    {
        if (!$this->isAllowedMeta($key)) return $value;

        if (($meta = $this->getMeta($key))->count()) {
            if ($override) $meta->map(function ($cur) use ($value) {
                $cur->updateValue($value);
            });

            return $value;
        }

        $this->metas()->create([
            'meta_key' => $key,
            'meta_value' => $value
        ]);

        return $value;
    }

    /**
     * Update the note metas
     *
     * @param array $metas
     * @param bool $override
     */
    public function setMetas(array $metas, bool $override = false): void
    {
        foreach ($metas as $key => $value) $this->setMeta($key, $value, $override);
    }
}
