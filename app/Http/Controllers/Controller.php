<?php

namespace App\Http\Controllers;

use App\Exceptions\ValidationException;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Throwable;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Process exceptions
     * @param Throwable $e
     * 
     */
    protected function processExceptions(Throwable $e): JsonResponse
    {
        $status = 400;
        $errors = [$e->getMessage()];

        if (get_class($e) == ValidationException::class) {
            /**
             * @var ValidationException
             */
            $validationException = $e;
            $errors = $validationException->getErrors();
        }

        return response()->json(
            [
                'success' => false,
                'errors' => $errors
            ],
            $status 
        );
    }
}
