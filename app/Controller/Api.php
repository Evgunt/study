<?php

namespace Controller;


use Model\Post;
use Src\Auth\Auth;
use Src\Request;
use Src\View;

class Api
{
    public function index(): void
    {
        $posts = Post::all()->toArray();

        (new View())->toJSON($posts);
    }
    public function catalog(Request $request): void
    {
        $cats = (new \Model\Catalog)->getItems($request->id);
        (new View())->toJSON($cats);
    }

    public function echo(Request $request): void
    {
        (new View())->toJSON($request->all());
    }

    public function login(Request $request): void
    {
        if (Auth::attempt($request->all())) {
            (new View())->toJSON((new \Model\User)->setToken());
        }
    }
    public function Personal(Request $request)
    {
        if($request->method == 'POST')
            (new \Model\User)->setImg();
        $headers = getallheaders();
        $user = (new \Model\User)->getAllUser($request->id, $headers['Authorization']);
        (new View())->toJSON(['user' => $user]);
    }

}
