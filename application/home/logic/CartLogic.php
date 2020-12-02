<?php
namespace app\home\logic;

use app\common\model\Cart;
class CartLogic
{
    /**
     * 加入购物车
     * @param $goods_id 商品id
     * @param $spec_goods_id 规格商品SKU的id
     * @param $number 购买数量
     * @param int $is_selected 选中状态 默认选中1
     */
    public static function addCart($goods_id, $spec_goods_id, $number, $is_selected=1)
    {
        //判断登录状态：已登录，添加到数据表；未登录，添加到cookie
        if(session('?user_info')){
            //已登录，添加到数据表
            //判断是否存在相同购物记录（用户id相同，商品id相同，SKU的id相同）
            $user_id = session('user_info.id');
            $where = [
                'user_id' => $user_id,
                'goods_id' => $goods_id,
                'spec_goods_id' => $spec_goods_id
            ];
            $info = Cart::where($where)->find();
            if($info){
                //存在相同记录 累加数量  修改操作
                $info->number += $number;
                $info->is_selected = $is_selected;
                $info->save();
            }else{
                //不存在相同记录 添加新数据
                $where['number'] = $number;
                $where['is_selected'] = $is_selected;
                Cart::create($where);
            }
        }else{
            //未登录，添加到cookie
            //先取出cookie中的数据
            $data = cookie('cart') ?: [];
            //添加或修改数据数组 判断是否存在相同的记录（商品id相同，sku的id相同）
            //$spec_goods_id和spec_goods数据表对应
            $key = $goods_id . '_' . $spec_goods_id;
            if(isset($data[$key])){
                //存在相同记录 则累加数量
                $data[$key]['number'] += $number;
                $data[$key]['is_selected'] = $is_selected;
            }else{
                //不存在相同记录 则添加新的数据（键值对）
                $data[$key] = [
                    'id' => $key,
                    'user_id' => '',
                    'goods_id' => $goods_id,
                    'spec_goods_id' => $spec_goods_id,
                    'number' => $number,
                    'is_selected' => $is_selected
                ];
            }
            //重新保存新数组到cookie
            cookie('cart', $data, 86400*7);
        }
    }

    /**
     * 获取所有的购物记录
     */
    public static function getAllCart()
    {
        //判断登录状态：已登录，查询数据表；未登录 取cookie
        if(session('?user_info')){
            //已登录，查询数据表
            $user_id = session('user_info.id');
            $data = Cart::field('id,user_id,goods_id,spec_goods_id,number,is_selected')->where('user_id', $user_id)->select();
            //转化为标准的二维数组（统一格式）
            $data = (new \think\Collection($data))->toArray();
        }else{
            //未登录 取cookie  ['10_20'=>[],'10_21'=>[], ]
            $data = cookie('cart') ?: [];
            //转化为标准的二维数组（统一格式） 去掉字符串下标
            $data = array_values($data);
        }
        return $data;
    }

    /**
     * 登录后将cookie购物车迁移到数据表
     */
    public static function cookieToDb()
    {
        //从cookie中取出所有数据
        $data = cookie('cart')?:[];
        //将数据添加/修改到数据表
        foreach($data as $v){
            self::addCart($v['goods_id'], $v['spec_goods_id'], $v['number']);
        }
        //删除cookie购物车数据  这个经典
        cookie('cart', null);
    }

    /**
     * 修改购买数量
     * @param $id 修改条件：已登录 主键id；未登录 20_30下标
     * @param $number 修改数量
     */
    public static function changeNum($id, $number)
    {
        //判断登录状态  已登录修改数据表；未登录修改cookie
        if(session('?user_info')){
            //已登录修改数据表
            $user_id = session('user_info.id');
            //只能修改当前用户自己的记录
            Cart::update(['number' => $number], ['id'=>$id, 'user_id'=>$user_id]);
            //Cart::where(['id'=>$id, 'user_id'=>$user_id])->update(['number' => $number]);
        }else{
            //未登录修改cookie
            //先从cookie取出所有记录
            $data = cookie('cart') ?: [];
            //修改数量
            $data[$id]['number'] = $number;
            //重新保存到cookie
            cookie('cart', $data, 86400*7);
        }
    }

    /**
     * 删除购物记录
     * @param $id 删除条件 主键id或者下标20_30
     */
    public static function delCart($id)
    {
        //判断登录状态  已登录 删除数据表，未登录删除cookie
        if(session('?user_info')){
            //已登录 删除数据表
            $user_id = session('user_info.id');
            //Cart::destroy(['id' => $id, 'user_id' => $user_id]);
            Cart::where(['id' => $id, 'user_id' => $user_id])->delete();
        }else{
            //未登录删除cookie
            //从cookie中取出所有
            $data = cookie('cart') ?: [];
            // $id 就是一个下标
            unset($data[$id]);
            //重新保存到cookie
            cookie('cart', $data, 86400*7);
        }
    }

    /**
     * 修改选中状态
     * @param $id 修改条件
     * @param $is_selected 状态 1 0
     */
    public static function changeStatus($id, $is_selected)
    {
        //登录状态 登录 修改数据表；未登录修改cookie
        if(session('?user_info')){
            //登录 修改数据表；
            $user_id = session('user_info.id');
            $where['user_id'] = $user_id;
            if($id != 'all'){
                $where['id'] = $id;
            }
            Cart::where($where)->update(['is_selected' => $is_selected]);
        }else{
            //未登录修改cookie
            //取出所有cookie购物车数据
            $data = cookie('cart') ?: [];
            //$id 就是一个下标
            if($id == 'all'){
                //全部修改
                foreach($data as &$v){
                    $v['is_selected'] = $is_selected;
                }
                unset($v);
            }else{
                //修改一个
                $data[$id]['is_selected'] = $is_selected;
            }

            //重新保存到cookie
            cookie('cart', $data, 86400*7);
        }
    }
}