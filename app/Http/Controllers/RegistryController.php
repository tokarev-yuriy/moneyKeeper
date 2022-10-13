<?php
namespace App\Http\Controllers;
use Illuminate\Http\JsonResponse;
/**
 *  Registry Controller
 *
 *  @author   Yuriy Tokarev <yuriytok@gmail.com>
 */
final class RegistryController extends Controller {

    public function registry(): JsonResponse
    {
        return response()->json([
            'icons' => [
                'coins',
                'wallet',   
                'credit_card',
                'currency_pound',
                'euro',
                'currency_dollar',
                'account_balance_wallet',
                'business_center',
                'diamond',
                'home',
                'account_balance',
                'savings',
                'money',
            ],
            'colors' => [
                'fff', // white
                'b71c1c', // red
                '880e4f', // pink
                '4a148c', // purple
                '311b92', // deeppurple
                '1a237e', // indigo
                '0d47a1', // blue
                '01579b', // lightBlue
                '006064', // cyan
                '004d40', // teal
                '1b5e20', // green
                '33691e', // lightGreen
                '827717', // lime
                'f57f17', // yellow
                'e65100', // orange
                '3e2723', // brown
                '212121', // grey
                '263238', // blueGrey
                '607d8b', // blueGrey2
                '111111', // black
            ],
        ]);
    }

}


        
