<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class NoteResource extends JsonResource
{
    private $responseCode;

    public function withResponse($request, $response)
    {
        $response->setStatusCode($this->responseCode);
        parent::withResponse($request, $response);
    }

    public function __construct($resource, $responseCode = 200)
    {
        parent::__construct($resource);
        $this->responseCode = $responseCode;
    }

    public function toArray($request)
    {
        return [
          'id' => $this->id,
          'title' => $this->title,
          'content' => $this->content,
          'author' => UserResource::make($this->author),
          'meta' => $this->getAllowedMetas(),
          'created_at' => Carbon::parse($this->created_at)->format('d.m.Y')
        ];
    }
}
