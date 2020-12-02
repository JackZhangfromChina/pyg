<?php
namespace app\adminapi\controller;

use think\Controller;

class Index extends BaseApi
{
    public function index()
    {
        //测试数据库配置
        halt(cache('delete_token'));
//        $goods = \think\Db::table('pyg_goods')->find();
//        dump($goods);die;
        echo encrypt_password('123456');die;
        //测试Token工具类
        //生成token
//        $token = \tools\jwt\Token::getToken(200);
//        dump($token);
        //解析token 得到用户id
//        $user_id = \tools\jwt\Token::getUserId($token);
//        dump($user_id);die;

        //测试响应方法
//        $this->response();
        $this->response(200, 'success', ['id' => 100, 'name' => 'zhangsan']);
        $this->ok(['id' => 100, 'name' => 'zhangsan']);
        //$this->response(400, '参数错误');
        //$this->fail('参数错误');
        $this->fail('参数错误', 401);
        
        //return 'hello, 这里是adminapi的index的index方法';
    }
}
