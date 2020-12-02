<?php

namespace app\admin\model;

use think\Model;

class GoodsImages extends Model
{
    protected $hidden = ['create_time', 'update_time', 'delete_time'];
    //相册图片 属于 商品的
    public function goods()
    {
        return $this->belongsTo('Goods');
    }
}
