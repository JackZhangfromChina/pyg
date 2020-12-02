<?php

namespace app\adminapi\controller;

use think\Controller;

class BaseApi extends Controller
{
    //无需登录的请求数组
    protected $no_login = ['login/captcha', 'login/login'];
//    控制器的初始化方法（和 直接写构造方法 二选一）
    protected function _initialize()
    {
        //实现父类的初始化方法
        parent::_initialize();
        //初始化代码
        //处理跨域请求
        //允许的源域名
        header("Access-Control-Allow-Origin: *");
        //允许的请求头信息
        header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization");
        //允许的请求类型
        header('Access-Control-Allow-Methods: GET, POST, PUT,DELETE,OPTIONS,PATCH');

        try{
            //登录检测
            //获取当前请求的控制器方法名称
            $path = strtolower($this->request->controller()) . '/' . $this->request->action();
            if(!in_array($path, $this->no_login)){
                //需要做登录检测
                $user_id = \tools\jwt\Token::getUserId();
//                halt($user_id);
                if(empty($user_id)){
                    $this->fail('token验证失败', 403);
                }
                //将得到的用户id 放到请求信息中去  方便后续使用
                $this->request->get('user_id', $user_id);
                $this->request->post('user_id', $user_id);
            }
        }catch (\Exception $e){
            //token解析失败
            $this->fail('token解析失败', 404);
        }

    }

    /**
     * 通用的响应
     * @param int $code 错误码
     * @param string $msg 错误信息
     * @param array $data 返回数据
     */
    protected function response($code=200, $msg='success', $data=[])
    {
        $res = [
            'code' => $code,
            'msg' => $msg,
            'data' => $data
        ];
        //原生php写法
        echo json_encode($res, JSON_UNESCAPED_UNICODE);die;
        //框架写法
        //json($res)->send();

    }
    /**
     * 成功的响应
     * @param array $data 返回数据
     * @param int $code 错误码
     * @param string $msg 错误信息
     */
    protected function ok($data=[], $code=200, $msg='success')
    {
        $this->response($code, $msg, $data);
    }

    /**
     * 失败的响应
     * @param $msg 错误信息
     * @param int $code 错误码
     * @param array $data 返回数据
     */
    protected function fail($msg, $code=500, $data=[])
    {
        $this->response($code, $msg, $data);
    }
}
