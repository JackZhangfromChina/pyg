<?php
namespace app\admin\controller;

use think\Controller;

class Index extends Base
{
    public function index()
    {
        return view();
    }

    public function _empty()
    {
        $method = request()->action();
        if($method == 'login'){
        }
        return view($method);
    }
}
