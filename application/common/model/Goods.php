<?php
    
    namespace app\common\model;
    
    use think\Model;
    
    class Goods extends Model
    {

        protected static function init()
        {
            //实例化ES工具类
            $es = new \tools\es\MyElasticsearch();
            //设置新增回调
            self::afterInsert(function($goods)use($es){
                //添加文档
                $doc = $goods->visible(['id', 'goods_name', 'goods_desc', 'goods_price'])->toArray();
                $doc['cate_name'] = $goods->category->cate_name;
                $es->add_doc($goods->id, $doc, 'goods_index', 'goods_type');
            });
            //设置更新回调
            self::afterUpdate(function($goods)use($es){
                //修改文档
                $doc = $goods->visible(['id', 'goods_name', 'goods_desc', 'goods_price', 'cate_name'])->toArray();
                $doc['cate_name'] = $goods->category->cate_name;
                $body = ['doc' => $doc];
                $es->update_doc($goods->id, 'goods_index', 'goods_type', $body);
            });
            //设置删除回调
            self::afterDelete(function($goods)use($es){
                //删除文档
                $es->delete_doc($goods->id, 'goods_index', 'goods_type');
            });
        }

        //定义商品-商品分类关联 一个商品属于一个分类
        public function category()
        {
            return $this->belongsTo('Category', 'cate_id', 'id')->bind('cate_name');
        }
        public function categoryRow()
        {
            return $this->belongsTo('Category', 'cate_id', 'id');
        }
        //定义商品-商品品牌关联  一个商品属于一个品牌
        public function brand()
        {
            //将数据表中的name字段设置别名为brand_name
            return $this->belongsTo('Brand', 'brand_id', 'id')->bind(['brand_name'=>'name']);
        }
        public function brandRow()
        {
            //将数据表中的name字段设置别名为brand_name
            return $this->belongsTo('Brand', 'brand_id', 'id');
        }
        //定义商品-商品类型关联  一个商品属于一个类型
        public function type()
        {
            return $this->belongsTo('Type', 'type_id', 'id')->bind('type_name');
        }
        public function typeRow()
        {
            return $this->belongsTo('Type', 'type_id', 'id');
        }
        //定义商品-相册图片关联  一个商品有多个图片
        public function goodsImages()
        {
            return $this->hasMany('GoodsImages', 'goods_id', 'id');
        }
        //定义商品-规格商品SKU的关联  一个商品SPU 有多个 规格商品SKU
        public function specGoods()
        {
            return $this->hasMany('SpecGoods', 'goods_id', 'id');
        }
        
        //获取商品以及sku信息
        public static function getGoodsWithSpec($spec_goods_id, $goods_id)
        {
            //如果有sku的id， 就以之作为查询条件
            if($spec_goods_id){
                //有sku，且有多个，需要根据sku的id取指定的一个
                $where = ['t2.id'=>$spec_goods_id];
            }else{
                //没有sku， 就根据商品id查询，sku相关的字段都是null
                $where = ['t1.id' => $goods_id];
            }
            //如果没有，就以商品id作为查询条件
            $goods = self::alias('t1')
                         ->join('pyg_spec_goods t2', 't1.id=t2.goods_id', 'left')
                         ->field('t1.*, t2.value_ids, t2.value_names, t2.price, t2.cost_price as cost_price2, t2.store_count')
                         ->where($where)
                         ->find();
            //如果sku信息中，price  cost_price 大于0，则覆盖商品信息中的对应字段
            if($goods['price'] > 0){
                $goods['goods_price'] = $goods['price'];
            }
            if($goods['cost_price2'] > 0){
                $goods['cost_price'] = $goods['cost_price2'];
            }
            return $goods;
        }
        
    }
