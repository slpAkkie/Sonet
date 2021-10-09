<?php

namespace App\Http\Resources;

class CommonErrorResource extends CommonResource
{
    public static $wrap = 'error';

    protected $message;
    protected $metadata;

    public function __construct($message, $response_code, $metadata = [])
    {
        $this->response_code = $response_code;
        $this->message = $message;
        $this->metadata = $metadata;

        parent::__construct(null);
    }

    public function toArray($request)
    {
        return array_merge([
            'message' => $this->message
        ], $this->metadata);
    }
}
