<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\MoneyKeeper\Accounting\Repositories\AccountsEloquentRepository;
use App\User;
use MoneyKeeper\Accounting\Services\AccountGroupServices;
use Validator, Input, Redirect, Auth, Request, Hash;

/**
 *  Crud conrtoller for Account groups
 *
 *  @author   Yuriy Tokarev <yuriytok@gmail.com>
 */
final class AccountGroupController extends CrudController {

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->service = new AccountGroupServices(
                $this->getUser(),
                new AccountsEloquentRepository($this->getUser())
            );
            return $next($request);
        });
    }

}
