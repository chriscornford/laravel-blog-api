<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;
use Validator;

class BaseController extends Controller
{

    /**
     * @param array $errors
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function createErrorResponse(array $errors)
    {
        return response()->json(
            ['data' => $errors],
            Response::HTTP_UNPROCESSABLE_ENTITY
        );
    }

    /**
     * @return Response
     */
    public function createNotFoundResponse()
    {
        return response('', Response::HTTP_NOT_FOUND);
    }

    /**
     * @return Response
     */
    public function createUnauthorizedResponse()
    {
        return response('', Response::HTTP_UNAUTHORIZED);
    }

    /**
     * @return Response
     */
    public function createNoContentResponse()
    {
        return response('', Response::HTTP_NO_CONTENT);
    }
}