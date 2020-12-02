<?php

namespace app\admin\model;

use think\Model;

class OrderGoods extends Model
{
    protected $hidden = ['create_time', 'update_time', 'delete_time'];
    public function goods()
    {
        return Goods::getGoodsWithSpecGoods($this->spec_goods_id, $this->goods_id);
    }

    public function getIsCommentAttr($value)
    {
        return $value ? '是' : '否';
    }
    public function getStatusAttr($value)
    {
        $status = ['未发货','已发货','已换货','已退货'];
        return $status[$value];
    }
}
