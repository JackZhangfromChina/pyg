<?php

namespace app\common\model;

use think\Model;

class Profile extends Model
{
    //定义相对的关联  档案-管理员的关联  一个档案属于一个管理员
    public function admin()
    {
        return $this->belongsTo('Admin', 'uid', 'id');
        //return $this->belongsTo('Admin', 'uid', 'id')->bind('username,email');
    }
}
