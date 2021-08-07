<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Note extends Model
{
    use HasFactory;

    private $allowed_metas = [
        'color'
    ];

    protected $fillable = [
        'title',
        'content'
    ];

    public function author()
    {
        return $this->belongsTo(User::class);
    }

    public function metas()
    {
        return $this->hasMany(NoteMeta::class);
    }

    private function isAllowedMeta($meta)
    {
        return in_array($meta instanceof NoteMeta ? $meta->meta_key : $meta, $this->allowed_metas);
    }

    public static function createFrom($request)
    {
        $data = $request->all();
        $data['users'] = array_unique(gettype($request->get('users')) === 'array' ? $request->get('users') : []);
        $data['author'] = Auth::user();

        $note = Note::createWith($data);

        return $note;
    }

    public function updateFrom($request)
    {
        $this->update($request->all());
        if ($request->get('meta')) $this->updateMetas($request->get('meta'));

        return $this;
    }

    private static function usersForMeta($note, $users)
    {
        $carry = [];
        foreach ($users as $user) {
            $carry[] = [
                'note_id' => $note->id,
                'meta_key' => 'user_id',
                'meta_value' => $user
            ];
        }

        return $carry;
    }

    private static function createWith($props)
    {
        $note = new Note($props);
        $note->author_id = $props['author']->id;
        $note->save();

        $metas = [];
        $metas = array_merge($metas, self::usersForMeta($note, $props['users']));
        $metas = array_filter($metas, function ($cur) { return $cur && !!count($cur); });

        NoteMeta::insert($metas);

        $props['meta'] && $note->updateMetas($props['meta']);

        return $note;
    }

    public function getAllowedMetas()
    {
        return $this->metas->reduce(function ($carry, $cur) {
            if ($this->isAllowedMeta($cur)) $carry[$cur->meta_key] = $cur->meta_value;

            return $carry;
        }, []);
    }

    public function setMeta($key, $value, $override = false)
    {
        if (($meta = NoteMeta::getFor($this, $key))->count()) {
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

    public function updateMetas($metas)
    {
        foreach ($metas as $key => $value)
            if ($this->isAllowedMeta($key)) $this->setMeta($key, $value, true);
    }
}
