<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Repositories\UsersRepository;
use App\Services\AuthService;
use App\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Validator, Redirect, Auth, Hash;
use MoneyKeeper\Models;
use Throwable;

/**
 *  Controlerr for typical user's operations: login, register and logout
 *
 *  @author   Yuriy Tokarev <yuriytok@gmail.com>
 */
class AuthController extends Controller {


    /**
     * Constructor
     */
    public function __construct()
    {
    }

    /**
     * Logout
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
        try {
            $service = new AuthService();
            $service->logout();
        } catch(Throwable $e) {
            return $this->processExceptions($e);
        }
        return response()->json([
            'success'=> true
        ]);
    }
    
    /**
     * Process registration
     * 
     * @param Request $request
     * @return JsonResponse
     */    
    public function register(Request $request): JsonResponse
    {
        try {
            $service = new AuthService();
            $service->register($request->all());
        } catch(Throwable $e) {
            return $this->processExceptions($e);
        }

        return response()->json([
            'success'=> true
        ]);
    }
    
    /**
     * Process Authorization
     * @param Request $request
     * @return JsonResponse
     */    
    public function login(Request $request)
    {
        try {
            $service = new AuthService();
            $service->login($request->all());
        } catch(Throwable $e) {
            return $this->processExceptions($e);
        }

        return response()->json([
            'success'=> true
        ]);
    }

}
