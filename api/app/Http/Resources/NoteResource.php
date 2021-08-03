<?php

namespace App\Http\Resources;

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
        return array_merge([
            'title' => $this->title,
            'content' => $this->content,
            'meta' => $this->getAllowedMetas()
        ], $this->withAuthor ? ['author' => UserResource::make($this->author)] : []);
    }
}
