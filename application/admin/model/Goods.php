<?php

namespace app\admin\model;

use think\Model;
class Goods extends Model
{
    //定义完整的数据表名称
//    protected $table = 'tpshop_goods';

    //设置软删除
    use \traits\model\SoftDelete;
    protected $deleteTime = 'delete_time';
    protected $hidden = ['create_time', 'update_time', 'delete_time'];

    public function category()
    {
        return $this->belongsTo('Category', 'cate_id');
    }
    public function type()
    {
        return $this->belongsTo('Type');
    }
    public function brand()
    {
        return $this->belongsTo('brand');
    }

    public function goodsImages()
    {
        return $this->hasMany('GoodsImages');
    }

    public function specGoods()
    {
        return $this->hasMany('SpecGoods');
    }

    public function getGoodsAttrAttr($value)
    {
        return json_decode($value, true);
    }

    public static function getGoodsWithSpecGoods($spec_goods_id, $goods_id=0)
    {
        if($spec_goods_id){
            //没有指定sku 则 根据商品id取第一个
            $where = ['t2.id'=>$spec_goods_id];
        }else{
            $where = ['t1.id'=>$goods_id];
        }
        $goods = self::alias('t1')
            ->field('t1.*, t2.id as spec_goods_id, t2.value_ids, t2.value_names, t2.price, t2.cost_price as cost_price2, t2.store_count')
            ->join(config('database.prefix').'spec_goods t2', 't1.id=t2.goods_id', 'left')
            ->where($where)
            ->find();
        if($goods->price > 0){
            $goods->goods_price = $goods->price;
        }
        if($goods->cost_price2 > 0){
            $goods->cost_price = $goods->cost_price2;
        }
        return $goods;
    }
}
