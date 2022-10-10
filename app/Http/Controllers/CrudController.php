<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use MoneyKeeper\Accounting\Services\ICrudServices;
use Input, Auth, Validator, Redirect;
use Throwable;

/**
 *  Abstract CRUD controller with ajax support
 *
 *  @author   Yuriy Tokarev <yuriytok@gmail.com>
 */
abstract class CrudController extends Controller {

    /**
     * Crud service class
     *
     * @var ICrudServices
     */
    protected ICrudServices $service;

    /**
     * List of items
     * 
     * @return JsonResponse
     */    
    public function list(Request $request): JsonResponse
    {
        try {
            $items = $this->service->getAll();
            return response()->json([
                'success' => true,
                'items' => $items->getData()
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'success' => false,
                'errors' => [
                    'unknown' => $e->getMessage()
                ]
            ]);
        }
    }
}
