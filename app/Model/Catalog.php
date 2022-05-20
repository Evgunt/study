<?php

namespace Model;

use Illuminate\Database\Capsule\Manager as DB;

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
    public function search(string $key)
    {
        return DB::select("SELECT * FROM item WHERE title LIKE '%".$key."%'");
    }
    public function getItemAll(int $id)
    {
        return DB::select("SELECT * FROM item WHERE id=?", [$id]);
    }
}
