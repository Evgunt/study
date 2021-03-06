<?php

namespace Controller;

use Model\Post;
use Src\Session;
use Src\View;
use Src\Request;
use Model\User;
use Model\Catalog;
use Src\Auth\Auth;
use Src\Validator\Validator;
class Site
{
    public function index(Request $request): string
    {
        $posts = Post::where('id', $request->id)->get();
        return (new View())->render('site.post', ['posts' => $posts]);
    }

    public function hello(Request $request): string
    {
        if ($request->method === 'POST') {
            $validator = new Validator($request->all(), [
                'key' => ['required'],
            ],[
                'required' => 'Поле :field пусто',
            ]);
            if($validator->fails()){
                return new View('site.hello',
                    ['message' => json_encode($validator->errors(), JSON_UNESCAPED_UNICODE)]);
            }
            $result = (new \Model\Catalog)->search($request->key);
            return new View('site.search', ['result' => $result]);
        }
        $cats = (new \Model\Catalog)->getCat();
        $userId = Session::get('id');
        return new View('site.hello',['cats'=>$cats, 'id'=>$userId]);
    }

    public function signup(Request $request): string
    {
        if ($request->method === 'POST') {

            $validator = new Validator($request->all(), [
                'name' => ['required'],
                'login' => ['required', 'unique:users,login'],
                'password' => ['required'],
                'password2' => ['required'],
                'email' => ['required', 'email'],
                'phone' => ['int'],
            ], [
                'required' => 'Поле :field пусто',
                'unique' => 'Поле :field должно быть уникально'
            ]);

            if($validator->fails()){
                return new View('site.signup',
                    ['message' => json_encode($validator->errors(), JSON_UNESCAPED_UNICODE)]);
            }

            if (User::create($request->all())) {
                app()->route->redirect('/login');
                return false;
            }

        }
        return new View('site.signup');
    }


    public function login(Request $request): string
    {
        //Если просто обращение к странице, то отобразить форму
        if ($request->method === 'GET') {
            return new View('site.login');
        }
        //Если удалось аутентифицировать пользователя, то редирект
        if (Auth::attempt($request->all())) {
            $token = (new \Model\User)->setToken();
            Session::set('token', 'Bearer '.$token['token']);
            app()->route->redirect('/lk?id='.Session::get('id'));
        }
        //Если аутентификация не удалась, то сообщение об ошибке
        return new View('site.login', ['message' => 'Неправильные логин или пароль']);
    }

    public function logout(): void
    {
        Auth::logout();
        app()->route->redirect('/');
    }

    public function lk(Request $request): string
    {
        if($request->method == 'POST')
            (new \Model\User)->setImg();
        $headers = getallheaders();
        if(Session::get('token') !== null) {
            $user = (new \Model\User)->getAllUser($request->id, Session::get('token'));
        }
        else
            $user = (new \Model\User)->getAllUser($request->id, $headers['Authorization']);
        return new View('site.lk', ['user' => $user]);
    }

    public function catalog(Request $request): string
    {
        $cats = (new \Model\Catalog)->getItems($request->id);
        return new View('site.catalog', ['cats' => $cats]);
    }
    public function item(Request $request): string
    {
        $item = (new \Model\Catalog)->getItemAll($request->id);;
        return new View('site.item', ['item' => $item]);
    }
}
