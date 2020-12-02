<?php

namespace app\admin\controller;

use app\admin\model\GoodsAttr;
use app\admin\model\OrderGoods;
use think\Controller;
use think\Request;

class Order extends Base
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        //查询订单表数据
        $list = \app\admin\model\Order::with('user')->order('id desc')->paginate(10);
        return view('order', ['list' => $list]);
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
        //查询订单基本信息
        $order = \app\admin\model\Order::with('user,order_goods')->find($id);

        $kuaidi = [];
        if(!empty($order->shipping_sn)){
            //查询快递信息  假设  快递公司  yunda  快递编号3101314976598
            // 接口地址 https://www.kuaidi100.com/query?type=yunda&postid=3101314976598
            $type = $order->shipping_code;
            $postid = $order->shipping_sn;
            $url = "https://www.kuaidi100.com/query?type={$type}&postid={$postid}";
            //调用curl_request函数 发送get请求  https
            $res = curl_request($url, false, [], true);
            if($res){
                //将json格式字符串转化为数组
                $arr = json_decode($res, true);
                if($arr['status'] == 200){
                    $kuaidi = $arr['data'];
                }
            }
        }

        return view('order-detail', ['order' => $order, 'kuaidi' => $kuaidi]);
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
