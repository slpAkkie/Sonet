<?php

namespace App\Http\Resources\Exceptions;

use App\Http\Resources\CommonResource;
use Illuminate\Http\JsonResponse;

abstract class CommonErrorResource extends CommonResource
{
    /**
     * ==================================================
     * Override ------------------------------------- */

    public function __construct($message, $response_code, $metadata = [])
    {
        $this->response_code = $response_code;
        $this->message = $message;
        $this->metadata = $metadata;

        parent::__construct(null);
    }

    /**
     * The "data" wrapper key
     *
     * @var string
     */
    public static $wrap = 'error';

    public function toArray($request)
    {
        return array_merge([
            'message' => $this->message
        ], $this->metadata);
    }



    /**
     * ==================================================
     * Customs ------------------------------------- */

    /**
     * The error message
     *
     * @var int
     */
    protected $message;

    /**
     * The error metadata that should be injected into the response data
     *
     * @var int
     */
    protected $metadata;

    /**
     * Create an HTTP response that represents the object
     *
     * @return JsonResponse
     */
    public function asResponse(): JsonResponse
    {
        return $this->toResponse($this->resource);
    }
}
