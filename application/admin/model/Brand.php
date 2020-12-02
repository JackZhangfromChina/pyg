<?php

namespace app\admin\model;

use think\Model;

class Brand extends Model
{
    protected $hidden = ['create_time', 'update_time', 'delete_time'];
    public function category(){
        return $this->belongsTo('Category', 'cate_id');
    }

    public function getCateNameAttr()
    {
        return !empty($this->category->cate_name) ? $this->category->cate_name : '';
    }
}
