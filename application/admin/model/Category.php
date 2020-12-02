<?php

namespace app\admin\model;

use think\Model;

class Category extends Model
{
    protected $hidden = ['create_time', 'update_time', 'delete_time'];
    //
    public function brands()
    {
        return $this->hasMany('Brand', 'cate_id');
    }
    public function getIsHotAttr($value)
    {
        return $value ? '是' : '否' ;
    }
    public function getIsShowAttr($value)
    {
        return $value ? '是' : '否' ;
    }

    public function getPidPathAttr($value)
    {
        return explode('_', $value);
    }
}
