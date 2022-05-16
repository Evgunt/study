<?php

namespace Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Src\Auth\IdentityInterface;
use Src\Session;
use Illuminate\Database\Capsule\Manager as DB;
use Src\Settings;

class User extends Model implements IdentityInterface
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = [
        'name',
        'login',
        'password',
        'email',
        'name',
        'lastname',
        'phone',
        'img'
    ];

    protected static function booted()
    {
        static::created(function ($user) {
            $user->password = md5($user->password);
            $user->save();
        });
    }

    //Выборка пользователя по первичному ключу
    public function findIdentity(int $id)
    {
        return self::where('id', $id)->first();
    }

    //Возврат первичного ключа
    public function getId(): int
    {
        return $this->id;
    }

    //Возврат аутентифицированного пользователя
    public function attemptIdentity(array $credentials)
    {
        return self::where(['login' => $credentials['login'],
            'password' => md5($credentials['password'])])->first();
    }

    public function getImg()
    {
        return DB::select('SELECT img FROM users WHERE id=?', [Session::get('id')]);
    }

    public function setImg(): void
    {
        if (isset($_FILES['img']) && $_FILES['img']['error'] != 4) {
            $filename = str_replace(' ','',basename($_FILES['img']['name']));
            move_uploaded_file($_FILES["img"]["tmp_name"], '../public/upload/' . $filename);
            DB::update('UPDATE users SET img=? WHERE id=?', [$filename, Session::get('id')]);
        }
    }

    public function getAllUser(): array
    {
        return DB::select('SELECT * FROM users WHERE id=?', [Session::get('id')]);
    }

}
