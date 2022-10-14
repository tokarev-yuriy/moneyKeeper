<?php
namespace App\Http\Controllers;
use App\MoneyKeeper\Accounting\Repositories\AccountsEloquentRepository;
use MoneyKeeper\Accounting\Services\AccountServices;
/**
 *  Crud conrtoller for Accounts
 *
 *  @author   Yuriy Tokarev <yuriytok@gmail.com>
 */
final class AccountController extends CrudController {

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->service = new AccountServices(
                $this->getUser(),
                new AccountsEloquentRepository($this->getUser())
            );
            return $next($request);
        });
    }

}
