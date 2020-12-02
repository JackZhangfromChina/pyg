<?php

namespace app\admin\model;

use think\Model;

class Order extends Model
{
    protected $hidden = ['create_time', 'update_time', 'delete_time'];
    //获取器  转化获取到的字段值
    public function getOrderStatusAttr($value)
    {
        $pay_status = ['待付款', '待发货', '待收货', '待评价', '已完成', '已取消 ', '已退货', '已退款', '已付款'];
        return $pay_status[$value];
    }

    public function orderGoods()
    {
        return $this->hasMany('OrderGoods');
    }

    public function user()
    {
        return $this->belongsTo('User');
    }
}
