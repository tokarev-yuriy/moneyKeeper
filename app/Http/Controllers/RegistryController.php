<?php
namespace App\Http\Controllers;

use App\MoneyKeeper\Accounting\Repositories\AccountsEloquentRepository;
use Illuminate\Http\JsonResponse;
/**
 *  Registry Controller
 *
 *  @author   Yuriy Tokarev <yuriytok@gmail.com>
 */
final class RegistryController extends Controller {

    public function registry(): JsonResponse
    {
        $repository = new AccountsEloquentRepository($this->getUser());
        return response()->json([
            'success' => true,
            'icons' => $repository->getAvailIcons(),
            'colors' => $repository->getAvailColors(),
        ]);
    }

}


        
