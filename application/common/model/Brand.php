<?php

namespace app\common\model;

use think\Model;

class Brand extends Model
{
    
    //定义相对的关联 品牌到分类 一个品牌属于一个分类
    public function category()
    {
        //这种定义方式， 和 一对一的关联belongsTo完全一样
        return $this->belongsTo('Category', 'cate_id', 'id');
//        return $this->belongsTo('Category', 'cate_id', 'id')->bind('cate_name');
    }
}
