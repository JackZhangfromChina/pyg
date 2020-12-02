<?php

namespace app\common\model;

use think\Model;

class Cart extends Model
{
    //设置购物车-商品关联  一条购物车记录 属于 一个商品
    public function goods()
    {
        return $this->belongsTo('Goods', 'goods_id', 'id')->bind('goods_logo,goods_name,goods_price,goods_number,cost_price,frozen_number');
    }

    //设置购物车-规格商品SKU关联  一条购物车记录 属于 一个规格商品SKU
    public function specGoods()
    {
        //return $this->belongsTo('SpecGoods', 'spec_goods_id', 'id')->bind('value_ids,value_names,price,cost_price,store_count,store_frozen');//cost_price重复，需要取别名
        return $this->belongsTo('SpecGoods', 'spec_goods_id', 'id')->bind(['value_ids','value_names','price','cost_price2'=>'cost_price','store_count','store_frozen']);
    }
}
