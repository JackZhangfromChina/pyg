<?php
    
    namespace app\home\controller;
    
    use app\admin\model\Address;
    use think\Controller;
    use think\Request;
    
    class Test extends Controller
    {
        /**
         * 显示资源列表
         *
         * @return \think\Response
         */
        public function index()
        {
            halt(cookie('cart'));
            //cookie中存储购物车数据,cookie获取的数据是一个数组
            //100_210主要是为了判断同一件商品（goods_id和spec_goods_id相同即是同一个商品）重复添加
            /*$list = [
                '100_210' => ['goods_id' => 100, 'spec_goods_id'=> 210, 'number' => 10, 'is_selected' => 1],
                '101_211' => ['goods_id' => 101, 'spec_goods_id'=> 211, 'number' => 11, 'is_selected' => 1],
            ];*/
            //1.获取列表数据
            //$list = cookie('cart') ?: [];
            //2.加入购物车 一条数据
            // goods_id 102  spec_goods_id 212  number 20  is_selected 1
            //先取出整个数组
            $list = cookie('cart') ?: [];
            //判断  存在相同的购物记录（商品id和SKU的id 都一样） 累加数量；不存在 则添加新记录
            $goods_id = 101;
            $spec_goods_id = 211;
            $number = 20;
            $key = $goods_id . '_' . $spec_goods_id;
            if(isset($list[$key])){
                //存在相同记录 累加数量
                $list[$key]['number'] += $number;
            }else{
                //否则，添加新记录
                $list[$key] = [
                    'goods_id' => $goods_id,
                    'spec_goods_id' => $spec_goods_id,
                    'number'=>$number,
                    'is_selected' => 1
                ];
            }
            //将新的数组重新保存到cookie
            cookie('cart', $list, 86400);
            
            //3.修改数量、选中状态 修改一条数据
            $goods_id = 101;
            $spec_goods_id = 211;
            $number = 20;
            //$is_selected = 1;
            //先取出所有数据
            $list = cookie('cart')?:[];
            //拼接下标
            $key = $goods_id . '_' . $spec_goods_id;
            $list[$key]['number'] = $number;
            //$list[$key]['is_selected'] = $is_selected;
            //将新的数组 保存cookie
            cookie('cart', $list, 86400);
            
            //4.删除一条数据
            $goods_id = 101;
            $spec_goods_id = 211;
            //获取所有数据
            $list = cookie('cart')?:[];
            //拼接下标
            $key = $goods_id . '_' . $spec_goods_id;
            //删除一个键值对
            unset($list[$key]);
            //重新保存新数据
            cookie('cart', $list, 86400);
        }
        
        /**
         * 显示创建资源表单页.
         *
         * @return \think\Response
         */
        public function create()
        {
            //
        }
        
        /**
         * 保存新建的资源
         *
         * @param  \think\Request  $request
         * @return \think\Response
         */
        public function save(Request $request)
        {
            //
        }
        
        /**
         * 显示指定的资源
         *
         * @param  int  $id
         * @return \think\Response
         */
        public function read($id)
        {
            //
        }
        
        /**
         * 显示编辑资源表单页.
         *
         * @param  int  $id
         * @return \think\Response
         */
        public function edit($id)
        {
            //
        }
        
        /**
         * 保存更新的资源
         *
         * @param  \think\Request  $request
         * @param  int  $id
         * @return \think\Response
         */
        public function update(Request $request, $id)
        {
            //
        }
        
        /**
         * 删除指定资源
         *
         * @param  int  $id
         * @return \think\Response
         */
        public function delete($id)
        {
            //
        }
    }
