<?php

namespace app\home\controller;

use think\Controller;
use think\Request;

class Room extends Base
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index($id=0)
    {
        $live = \app\common\model\Live::find($id);
//        halt($live);
        if($live){
            $live['goods'] = \app\common\model\LiveGoods::where('live_id', $id)->select();
        }
        $this->view->engine->layout(false);
        return view('index', ['live'=>$live]);
    }

}
