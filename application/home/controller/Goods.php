<?php
    
    namespace app\home\controller;
    
    use think\Controller;
    
    class Goods extends Base
    {
        //分类下的商品列表
        public function index($id=0)
        {
            //接收参数
            $keywords = input('keywords');
            if(empty($keywords)){
                //获取指定分类下商品列表
                if(!preg_match('/^\d+$/', $id)){
                    $this->error('参数错误');
                }
                //查询分类下的商品
                $list = \app\common\model\Goods::where('cate_id', $id)->order('id desc')->paginate(10);
                //查询分类名称
                $category_info = \app\common\model\Category::find($id);
                $cate_name = $category_info['cate_name'];
            }else{
                try{
                    //从ES中搜索
                    $list = \app\home\logic\GoodsLogic::search();
                    $cate_name = $keywords;
                }catch (\Exception $e){
                    $this->error('服务器异常');
                }

            }
            return view('index', ['list' => $list, 'cate_name' => $cate_name]);
        }
        
        //商品详情页
        public function detail($id)
        {
            //$id 是商品id
            //查询商品信息、商品相册、规格商品SKU
            $goods = \app\common\model\Goods::with('goods_images,spec_goods')->find($id);
            //将商品的第一个规格商品的信息，替换到$goods中
            if(!empty($goods['spec_goods'])){
                if($goods['spec_goods'][0]['price'] > 0){
                    $goods['goods_price'] = $goods['spec_goods'][0]['price'];
                }
                if($goods['spec_goods'][0]['cost_price'] > 0){
                    $goods['cost_price'] = $goods['spec_goods'][0]['cost_price'];
                }
                if($goods['spec_goods'][0]['store_count'] > 0){
                    $goods['store_count'] = $goods['spec_goods'][0]['store_count'];
                }else{
                    $goods['store_count'] = 0;
                }
            }
            //$goods_images = \app\common\model\GoodsImages::where('goods_id', $id)->select();
            //转化商品属性json为数组
            $goods['goods_attr'] = json_decode($goods['goods_attr'], true);
            //查询商品的规格名称规格值 组装数组
            //取出所有相关的规格值id
            //$goods['spec_goods']  二维数组  value_ids字段
            /*$goods['spec_goods'] = [
                ['id'=>1, 'value_ids'=>'28_32'],
                ['id'=>2, 'value_ids'=>'28_33'],
                ['id'=>3, 'value_ids'=>'29_32'],
                ['id'=>4, 'value_ids'=>'29_33'],
            ];*/
            //array_column函数从二维数组取出某一列的值  ['28_32', '28_33', '29_32', '29_33']
            //implode() '28_32_28_33_29_32_29_33'  explode()  [28,32,28,33,29,32,29,33]  array_unique [28,29,32,33]
            //array_column($goods['spec_goods'], 'value_ids');
            $value_ids = array_unique(explode('_', implode('_', array_column($goods['spec_goods'], 'value_ids'))));
            //根据规格值ids  $value_ids [28,29,32,33]  查询spec_value表 规格名称表
            //$spec_values = \app\common\model\SpecValue::select($value_ids);
            $spec_values = \app\common\model\SpecValue::with('spec')->where('id', 'in', $value_ids)->select();
            //为了页面展示方便，对数组结构进行转化
            /*$spec_values = [
                ['id' => 28, 'spec_id'=>23, 'spec_value'=>'白色', 'type_id'=>21, 'spec_name'=>'颜色'],
                ['id' => 29, 'spec_id'=>23, 'spec_value'=>'黑色', 'type_id'=>21, 'spec_name'=>'颜色'],
                ['id' => 32, 'spec_id'=>24, 'spec_value'=>'64G', 'type_id'=>21, 'spec_name'=>'内存'],
                ['id' => 33, 'spec_id'=>24, 'spec_value'=>'128', 'type_id'=>21, 'spec_name'=>'内存'],
            ];*/
            /*$spec_values = [
                23 => [ 'spec_id'=>23, 'spec_name'=>'颜色', 'spec_values'=>[
                    ['id' => 28, 'spec_id'=>23, 'spec_value'=>'白色', 'type_id'=>21, 'spec_name'=>'颜色'],
                    ['id' => 29, 'spec_id'=>23, 'spec_value'=>'黑色', 'type_id'=>21, 'spec_name'=>'颜色'],
                ]],
                24 => [ 'spec_id'=>24, 'spec_name'=>'内存', 'spec_values'=>[
                    ['id' => 32, 'spec_id'=>24, 'spec_value'=>'64G', 'type_id'=>21, 'spec_name'=>'内存'],
                    ['id' => 33, 'spec_id'=>24, 'spec_value'=>'128', 'type_id'=>21, 'spec_name'=>'内存'],
                ]],
            ];*/
            $res = [];
            foreach($spec_values as $v){
                $res[$v['spec_id']] = [
                    'spec_id' => $v['spec_id'],
                    'spec_name' => $v['spec_name'],
                    'spec_values' => []
                ];
            }
            /*$res = [
                23 => [ 'spec_id'=>23, 'spec_name'=>'颜色', 'spec_values'=>[]],
                24 => [ 'spec_id'=>24, 'spec_name'=>'内存', 'spec_values'=>[]],
            ];*/
            foreach($spec_values as $v){
                //$v['spec_id']
                $res[$v['spec_id']]['spec_values'][] = $v;
            }
            /*$res = [
                23 => [ 'spec_id'=>23, 'spec_name'=>'颜色', 'spec_values'=>[
                    ['id' => 28, 'spec_id'=>23, 'spec_value'=>'白色', 'type_id'=>21, 'spec_name'=>'颜色'],
                    ['id' => 29, 'spec_id'=>23, 'spec_value'=>'黑色', 'type_id'=>21, 'spec_name'=>'颜色'],
                ]],
                24 => [ 'spec_id'=>24, 'spec_name'=>'内存', 'spec_values'=>[
                    ['id' => 32, 'spec_id'=>24, 'spec_value'=>'64G', 'type_id'=>21, 'spec_name'=>'内存'],
                    ['id' => 33, 'spec_id'=>24, 'spec_value'=>'128', 'type_id'=>21, 'spec_name'=>'内存'],
                ]],
            ];*/
            
            //规格值ids组合--规格商品SKU的映射关系  页面需要使用
            /*$goods['spec_goods'] = [
                ['id'=>1, 'value_ids'=>'28_32'],
                ['id'=>2, 'value_ids'=>'28_33'],
                ['id'=>3, 'value_ids'=>'29_32'],
                ['id'=>4, 'value_ids'=>'29_33'],
            ];*/
            /*$value_ids_map = [
                '规格值ids组合' => '规格商品SKU的id和price'
                '28_32' => ['id'=>1, 'price'=>'1000'],
                '28_33' => ['id'=>2, 'price'=>'1000'],
                '29_32' => ['id'=>3, 'price'=>'1000'],
                '29_33' => ['id'=>4, 'price'=>'2000']
            ];*/
            $value_ids_map = [];
            foreach($goods['spec_goods'] as $v){
                //$v['id']  $v['price']
                $row = [
                    'id' => $v['id'],
                    'price' => $v['price']
                ];
                $value_ids_map[$v['value_ids']] = $row;
            }
            //数据最终在js中使用，转化为json格式，用于输出到
            $value_ids_map = json_encode($value_ids_map);
//            $goods,$res
//            dump($goods);
//            dump($res);
//            dump($value_ids_map);die;
            return view('detail', ['goods' => $goods, 'specs'=>$res, 'value_ids_map' => $value_ids_map]);
        }
    }
