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
            return $this->processExceptions($e);
        }
    }
    /**
     * Get item
     * 
     * @return JsonResponse
     */    
    public function get(Request $request, int $id): JsonResponse
    {
        try {
            $item = $this->service->getById($id);
            return response()->json([
                'success' => true,
                'item' => $item->toArray()
            ]);
        } catch (Throwable $e) {
            return $this->processExceptions($e);
        }
    }

    /**
     * Add item
     * 
     * @return JsonResponse
     */    
    public function add(Request $request): JsonResponse
    {
        try {
            $item = $this->service->add($request->all());
            return response()->json([
                'success' => true,
                'item' => $item->toArray()
            ]);
        } catch (Throwable $e) {
            return $this->processExceptions($e);
        }
    }

    /**
     * Update item
     * 
     * @return JsonResponse
     */    
    public function update(Request $request, int $id): JsonResponse
    {
        try {
            $item = $this->service->update($id, $request->all());
            return response()->json([
                'success' => true,
                'item' => $item->toArray()
            ]);
        } catch (Throwable $e) {
            return $this->processExceptions($e);
        }
    }

    /**
     * delete item
     * 
     * @return JsonResponse
     */    
    public function delete(Request $request, int $id): JsonResponse
    {
        try {
            $item = $this->service->delete($id);
            return response()->json([
                'success' => true
            ]);
        } catch (Throwable $e) {
            return $this->processExceptions($e);
        }
    }
}
