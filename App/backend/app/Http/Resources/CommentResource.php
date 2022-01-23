<?php

namespace App\Http\Resources;

use App\Models\Comment;
use Illuminate\Support\Carbon;

/**
 * @mixin Comment
 */
class CommentResource extends CommonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'user' => "{$this->author->last_name} {$this->author->first_name}",
            'body' => $this->body,
            'created_at' => Carbon::parse($this->created_at)->toDateTimeLocalString(),
        ];
    }
}
