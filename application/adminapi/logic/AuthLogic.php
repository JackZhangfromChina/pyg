<?php
namespace app\adminapi\logic;

class AuthLogic {
    //权限检测
    public static function check()
    {
        //判断是否特殊页面（比如首页，不需要检测）
        $controller = request()->controller(); //返回的是首字母大写
        $action = request()->action();
        if($controller == 'Index' && $action == 'index'){
            //不需要检测 （有权限访问）
            return true;
        }
        //获取到管理员的角色id
        $user_id = input('user_id');
        $info = \app\common\model\Admin::find($user_id);
        $role_id = $info['role_id'];
        //判断是否超级管理员（超级管理员不需要检测）
        if($role_id == 1){
            //不需要检测 （有权限访问）
            return true;
        }
        //查询当前管理员所拥有的权限ids（从角色表查询对应的role_auth_ids）
        $role = \app\common\model\Role::find($role_id);
        //取出权限ids分割为数组
        $role_auth_ids = explode(',', $role['role_auth_ids']); // '1,2,3'  [1,2,3]
        //根据当前访问的控制器、方法查询到具体的权限id
        $auth = \app\common\model\Auth::where('auth_c', $controller)->where('auth_a', $action)->find();
        $auth_id = $auth['id'];
        //判断当前权限id是否在role_auth_ids范围中。
        if(in_array($auth_id, $role_auth_ids)){
            //有权限
            return true;
        }
        //没有权限访问
        return false;
    }
}