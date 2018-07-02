<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Validator, Input, Redirect, Auth;
use MoneyKeeper\Models;

/**
 *  Controlerr for typical user operations: authorize, register, recover and change password
 *
 *  @author   Yuriy Tokarev <yuriytok@gmail.com>
 */
class AccountController extends Controller {


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->middleware('auth', array('only' => array('logout')));
    }

    /**
     * Show register form
     * 
     * @return <type>
     */    
    public function getRegister()
    {
          return view('account.register');
    }

    /**
     * Show login form
     * 
     * @return <type>
     */    
    public function getLogin()
    {
        return view('account.login');;
    }

    /**
     * Logout
     * 
     * @return <type>
     */    
    public function getLogout()
    {
        Auth::logout();
        return Redirect::to('/account/login');
    }
    
    /**
     * Process registration
     * 
     * 
     * @return <type>
     */    
    public function postRegister()
    {

        $validator = Validator::make(Input::all(),
            array(
              'name'=>'required|max:255',
              'email'=>'required|email|max:255|unique:users,email',
              'password'=>'required|confirmed|min:8',
            ));        
        if(!$validator->fails())
        {
            $user=new User();
            $user->name = Input::get('name');
            $user->email = Input::get('email');
            $user->password = Hash::make(Input::get('password'));
            $user->save();
            return Redirect::to('/account/login');
        }
        
        $messages = $validator->messages();
        
        return view('account.register', array(
            'errors' => $messages
        ));
    }
    
    /**
     * Process Authorization
     * 
     * 
     * @return <type>
     */    
    public function postLogin()
    {
       
        $validator = Validator::make(Input::all(),array(
              'email'=>'required|email',
              'password'=>'required',
            ));
            
        if($validator->fails()) {
            $messages = $validator->messages();
        } else {
           $remember=(Input::has('remember')) ? true : false;
            
            $auth=Auth::attempt(array(
              'email'=>Input::get('email'),
              'password'=>Input::get('password')
            ));
            if($auth) {
                return Redirect::to('/');
            } else {
                $messages = $validator->messages();
                $messages->add('password', trans('mkeep.wrong_pass'));
            }
        }
        
        return view('account.login', array(
            'errors' => $messages
        ));
    }

}
