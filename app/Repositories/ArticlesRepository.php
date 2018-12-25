<?php
/**
 * Created by PhpStorm.
 * User: linxb
 * Date: 2018/12/25
 * Time: 下午9:34
 */
namespace App\Repositories;


use App\Article;

class ArticlesRepository
{
    public function byId($id)
    {
        return Article::where('id', $id)->with('topics')->first();
    }


}
