<?php

namespace Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Src\Auth\IdentityInterface;
use Src\Session;
use Illuminate\Database\Capsule\Manager as DB;
use Src\Settings;

class Catalog
{
    public function getCat()
    {
        return DB::select('SELECT * FROM catalog');
    }
    public function getItems(int $parent)
    {
        return DB::select('SELECT * FROM item WHERE catalog =?', [$parent]);
    }
    public function getBread(int $id)
    {

    }
    public function search(string $key)
    {
        return DB::select("SELECT * FROM item WHERE title LIKE '%".$key."%'");
    }
    public function getItemAll(int $id)
    {
        return DB::select("SELECT * FROM item WHERE id=?", [$id]);
    }

}
