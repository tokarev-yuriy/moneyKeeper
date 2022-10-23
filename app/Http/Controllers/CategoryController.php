<?php
namespace App\Http\Controllers;
use App\MoneyKeeper\Accounting\Repositories\CategoriesEloquentRepository;
use MoneyKeeper\Accounting\Services\CategoryServices;
/**
 *  Crud conrtoller for Categories
 *
 *  @author   Yuriy Tokarev <yuriytok@gmail.com>
 */
final class CategoryController extends CrudController {

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->service = new CategoryServices(
                $this->getUser(),
                new CategoriesEloquentRepository($this->getUser())
            );
            return $next($request);
        });
    }

}
