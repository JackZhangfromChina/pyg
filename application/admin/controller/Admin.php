<?php

namespace app\admin\controller;

use app\admin\model\Role;
use think\Controller;
use think\Request;

class Admin extends Base
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        $where = [];
        $keyword = input('keyword');
        if(!empty($keyword)){
            $where['username'] = ['like', "%$keyword%"];
        }
        $list = \app\admin\model\Admin::with('role')->where($where)->paginate(2);
        $this->assign('list', $list);
        return view('admin');
    }

    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function create()
    {
        $role = Role::select();
        $this->assign('role', $role);
        return view('admin-add');
    }

    /**
     * 保存新建的资源
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function save(Request $request)
    {
        $data = input();
        //参数验证
        $validate = $this->validate($data, [
            'username|管理员账号' => 'require|unique:admin',
            'email|邮箱' => 'require|email',
            'role_id|角色' => 'require|integer|gt:0'
        ]);
        if($validate!==true){
            return json(['code' => '500', 'msg' => $validate]);
        }
        $data['nickname'] = $data['username'];
        \app\admin\model\Admin::create($data, true);
        return json(['code' => '200', 'msg' => '操作成功']);
    }

    /**
     * 显示指定的资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function read($id)
    {
        return view();
    }

    /**
     * 显示编辑资源表单页.
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function edit($id)
    {
        $role = Role::select();
        $this->assign('role', $role);
        $info = \app\admin\model\Admin::find($id);
        $this->assign('info', $info);
        return view('admin-edit');
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
        $data = input();
        $validate = $this->validate($data, [
            'email|邮箱' => 'require|email',
            'role_id|角色' => 'require|integer|gt:0'
        ]);
        if($validate!==true){
            return json(['code' => '500', 'msg' => $validate]);
        }
        unset($data['username']);
        unset($data['password']);
        \app\admin\model\Admin::update($data,['id' => $id], true);
        return json(['code' => '200', 'msg' => '操作成功']);
    }

    /**
     * 删除指定资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function delete($id)
    {
        if($id == session('manager_info.id')){
            return json(['code' => '500', 'msg' => '操作失败,您无权删除自己']);
        }
        $info = \app\admin\model\Admin::find($id);
        if($info && $info->role_id == 1 && 'admin' != session('manager_info.username')){
            return json(['code' => '500', 'msg' => '操作失败,您无权删除超级管理员']);
        }
        \app\admin\model\Admin::destroy($id);
        return json(['code' => '200', 'msg' => '操作成功']);
    }

    //修改密码
    public function setpwd()
    {
        if (request()->isGet()) {
            return view();
        }
        $data = input();
        //参数验证 Todo
        $id = session('manager_info.id');
        \app\admin\model\Admin::update($data, ['id' => $id], true);
        return json(['code' => '200', 'msg' => '操作成功']);
    }

    //重置密码
    public function reset($id)
    {
        \app\admin\model\Admin::update(['password' => '123456'], ['id' => $id]);
        return json(['code' => '200', 'msg' => '操作成功']);
    }
}
