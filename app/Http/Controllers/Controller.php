<?php

namespace App\Http\Controllers;

use App\Exceptions\ValidationException;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use MoneyKeeper\Accounting\Entities\UserEntity;
use MoneyKeeper\Exceptions\ValidationException as MoneyKeeperValidationException;
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

        if (
            get_class($e) == ValidationException::class || 
            get_class($e) == MoneyKeeperValidationException::class
        ) {
            /**
             * @var ValidationException
             */
            $validationException = $e;
            $errors = $validationException->getErrors();
        }

        return response()->json(
            [
                'success' => false,
                'error' => $e->getMessage(),
                'errors' => $errors
            ],
            $status 
        );
    }

    /**
     * Get current user entity
     *
     * @return UserEntity|null
     */
    protected function getUser(): ?UserEntity
    {
        if (Auth::check()) {
            $user = Auth::user();
            return $user->toEntity();
        }
        return null;
    }
}
