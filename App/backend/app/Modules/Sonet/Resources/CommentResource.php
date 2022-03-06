<?php

namespace App\Modules\Sonet\Resources;

use App\Modules\Sonet\Models\Comment;
use Illuminate\Support\Carbon;

/**
 * @mixin Comment
 */
class CommentResource extends \App\Http\Resources\CommonResource
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
