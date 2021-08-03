<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ErrorResource extends JsonResource
{
    public static $wrap = 'error';

    public $responseCode;

    /**
     * @param \Illuminate\Http\Request $request
     * @param \Illuminate\Http\JsonResponse $response
     */
    public function withResponse($request, $response)
    {
        $response->setStatusCode($this->responseCode);
    }

    /**
     * ErrorResource constructor.
     *
     * @param $message
     * @param $responseCode
     * @param array $with
     */
    public function __construct($message, $responseCode, array $with = [])
    {
        parent::__construct([
            'code'      => $responseCode,
            'message'   => $message
        ]);

        $this->responseCode = $responseCode;
        $this->with = [self::$wrap => $with];
    }
}
