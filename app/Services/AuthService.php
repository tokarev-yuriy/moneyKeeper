<?php
namespace App\Services;

use App\Exceptions\AlreadyLoggedInException;
use App\Exceptions\ValidationException;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

/**
 *  Auth services class
 *  @todo cover with feature tests
 *  @author   Yuriy Tokarev <yuriytok@gmail.com>
 */
class AuthService {

    /**
     * @var UsersRepository
     */
    protected $repository;

    /**
     * Constructor
     */
    public function __construct()
    {
    }


    /**
     * Registration
     * 
     * @todo replace array to the DTO or laravel form request
     *
     * @param array $arFields
     * @return boolean
     * @throws ValidationException
     */
    public function register(array $arFields): bool
    {
        if (Auth::check()) {
            throw new AlreadyLoggedInException("You are already logged in");
        }
        $validator = Validator::make($arFields,
            array(
              'name'=>'required|max:255',
              'email'=>'required|email|max:255|unique:users,email',
              'password'=>'required|min:8',
              'agree'=> 'required|accepted'
            ));        
        if($validator->fails()) {
            $errors = $validator->getMessageBag()->toArray();
            foreach($errors as $k=>$v) {
                $errors[$k] = current($v);
            }
            throw new ValidationException($errors);
        }
        $user = new User();
        $user->name = $arFields['name'];
        $user->email = $arFields['email'];
        $user->password = Hash::make($arFields['password']);
        $user->save();
        return true;
    }

    /**
     * Log in
     * 
     * @todo replace array to the DTO or laravel form request
     *
     * @param array $arFields
     * @return boolean
     * @throws ValidationException
     * @throws AlreadyLoggedInException
     */
    public function login(array $arFields): bool
    {
        if (Auth::check()) {
            throw new AlreadyLoggedInException("You are already logged in");
        }
        $validator = Validator::make($arFields, [
            'email'=>'required|email|max:255',
            'password'=>'required|min:8'
        ]);

        if($validator->fails()) {
            $errors = $validator->getMessageBag()->toArray();
            foreach($errors as $k=>$v) {
                $errors[$k] = current($v);
            }
            throw new ValidationException($errors);
        }

        $auth = Auth::attempt([
            'email' => $arFields['email'],
            'password' => $arFields['password']
        ]);
        
        if(!$auth) {
            throw new ValidationException(["We couldn't verify your credentials"]);
        }
        return true;
    }

    /**
     * Log out
     * @return boolean
     * @throws ValidationException
     */
    public function logout(): bool
    {
        if (Auth::check()) {
            Auth::logout();
        }

        return true;
    }

    /**
     * get Auth State
     * 
     * @todo replace array to the DTO
     *
     * @return array
     */
    public function getState(): array
    {
        if (Auth::check()) {
            return [
                'isLoggedIn' => true,
                'user' => [
                    'id' => Auth::id()
                ]
            ];
        }
        
        return [
            'isLoggedIn' => false,
            'user' => []
        ];
    }
}
