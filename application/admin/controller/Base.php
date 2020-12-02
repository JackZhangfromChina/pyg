<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 2018/3/12
 * Time: 16:08
 */
namespace app\admin\controller;

use app\admin\model\Auth;
use app\admin\model\Role;
use think\Controller;

class Base extends Controller
{
    public function __construct()
    {
        //先实现父类的构造方法，防止被直接重写掉
        parent::__construct();

        //测试，免登陆
        if ( !session('manager_info') ) {
            $info = \app\admin\model\Admin::find(1)->toArray();
            session('manager_info', $info);
        }


        //登录验证
        if ( !session('manager_info') ) {
            //没有登录 跳转到登录页面
            $this->redirect('admin/login/login');
        }
        //先检测权限
        $this->checkauth();
        //调用getnav方法
        $this->getnav();

        $action = request()->action();
        if(in_array($action,['index', 'read'])){
            $this->view->engine->layout(true);
        }

    }

    //获取左侧菜单权限
    public function getnav()
    {
        //获取当前登录的管理员，左侧菜单显示的权限
        //获取当前管理员的信息（role_id）
        $role_id = session('manager_info.role_id');
        //如果是超级管理员，直接查询权限表
        if ($role_id == 1) {
            //查询所有菜单权限
            $nav = Auth::where('is_nav', 1)->select();
        } else {
            //如果是普通管理员，先查询角色表 取到role_auth_ids
            $role = Role::find($role_id);
            $role_auth_ids = $role->role_auth_ids;
            //查询拥有的菜单权限
            $nav = Auth::where([
                'is_nav' => 1,
                'id' => ['in', $role_auth_ids]
            ])->select();
        }
        $nav = (new \think\Collection($nav))->toArray();
        $nav = get_tree_list($nav);
        //变量赋值
        $this->assign('nav', $nav);

        $controller = request()->controller();
        $action = request()->action();
        $auth = Auth::where(['auth_c'=>$controller, 'auth_a'=>$action])->find();
        $current_auth_ids = explode('_', $auth['pid_path']);
        $current_auth_ids[] = $auth['id'];
        $this->assign('current_auth_ids', $current_auth_ids);
    }

    //检测当前访问的权限
    public function checkauth()
    {
        //获取管理员信息（role_id）
        $role_id = session('manager_info.role_id');
        if ($role_id == 1) {
            //超级管理员，拥有所有权限，不需要继续检测
            return ;
        }
        //普通管理员 需要检测权限
        //分别获取当前请求的控制器和方法名称
        $controller = request()->controller();
        $action = request()->action();
        if (strtolower($controller) == 'index' && strtolower($action) == 'index'){
//            if ($controller == 'Index' && $action == 'index'){
            //特殊页面 比如后台首页，不需要检测权限
            return;
        }
        $ac = $controller . '-' . $action;
        //判断$ac 是否在已经拥有的权限role_auth_ac里面
        //查询当前角色信息
        $role = Role::find($role_id);
        $auth = Auth::where(['auth_c'=>$controller, 'auth_a'=>$action])->find();
        $role_auth_ids = explode(',', $role->role_auth_ids);
        if (!in_array($auth['id'], $role_auth_ids)) {
            $this->error('没有权限访问', 'admin/index/index');
        }

    }

    public function response($code=200, $msg='success', $data=[])
    {
        $res = [
            'code' => $code,
            'msg' => $msg,
            'data' => $data
        ];
//        echo json_encode($res, JSON_UNESCAPED_UNICODE);die;
        json($res)->send();die;
    }

    public function fail($msg='fail',$code=500)
    {
        return $this->response($code, $msg);
    }
    public function ok($data=[], $code=200, $msg='success')
    {
        return $this->response($code, $msg, $data);
    }

}