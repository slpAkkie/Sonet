<?php

namespace App\Http\Resources;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

abstract class CommonResource extends JsonResource
{
    /**
     * ==================================================
     * Override ------------------------------------- */

    public function __construct($resource = null)
    {
        parent::__construct($resource);
    }

    /**
     * The "data" wrapper key
     *
     * @var string
     */
    public static $wrap = 'data';

    /**
     * Set status code into the response data
     *
     * @param Request $request
     * @return int[]
     */
    public function with($request): array
    {
        return [
            'code' => $this->getStatusCode()
        ];
    }

    /**
     * Set status code as HTTP status code
     *
     * @param Request $request
     * @param JsonResponse $response
     */
    public function withResponse($request, $response)
    {
        $response->setStatusCode($this->getStatusCode());
    }



    /**
     * ==================================================
     * Customs ------------------------------------- */

    /**
     * The response code
     *
     * @var int
     */
    protected $response_code;

    /**
     * Get applied status code
     *
     * @return int
     */
    private function getStatusCode(): int
    {
        return $this->response_code ?? 200;
    }
}
