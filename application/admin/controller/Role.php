<?php

namespace app\admin\controller;

use app\admin\model\Auth;
use think\Controller;
use think\Request;

class Role extends Base
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        //查询角色表数据
        $list = \app\admin\model\Role::select();
        return view('admin-role', ['list' => $list]);
    }

    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function create()
    {
        //查询所有的权限
        $auths = \app\admin\model\Auth::field('id,auth_name,pid')->select();

        //将数据集转化为标准二维数组结构
        $auths = (new \think\Collection($auths))->toArray();
        //调用助手函数get_tree_list 将权限数组 转化为树状结构
        $auths = get_tree_list($auths);
//        var_dump($auths);die;
        return view('admin-role-add',['auths' => $auths]);
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
        $validate = $this->validate($data, [
            'role_name|角色名称' => 'require',
            'auth_ids|权限' => 'require'
        ]);
        if($validate!==true){
            return json(['code' => '500', 'msg' => $validate]);
        }
        //将id数组转化为数据表需要的字符串
        $data['role_auth_ids'] = implode(',', $data['auth_ids']);
        \app\admin\model\Role::create($data, true);
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
        $info = \app\admin\model\Role::find($id);
        //查询所有的权限
        $auths = \app\admin\model\Auth::field('id,auth_name,pid')->select();

        //将数据集转化为标准二维数组结构
        $auths = (new \think\Collection($auths))->toArray();
        //调用助手函数get_tree_list 将权限数组 转化为树状结构
        $auths = get_tree_list($auths);
        return view('admin-role-edit', ['info'=>$info, 'auths'=>$auths]);
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
            'role_name|角色名称' => 'require',
            'auth_ids|权限' => 'require'
        ]);
        if($validate!==true){
            return json(['code' => '500', 'msg' => $validate]);
        }
        //将id数组转化为数据表需要的字符串
        $data['role_auth_ids'] = implode(',', $data['auth_ids']);
        \app\admin\model\Role::update($data, ['id' => $id], true);
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
        $ids = explode(',', $id);
        $on_ids = \app\admin\model\Admin::where('role_id', 'in', $ids)->column('role_id');
        $off_ids = array_diff($ids, $on_ids);
        if(empty($off_ids)){
            return json(['code' => '500', 'msg' => '角色被使用中，无法删除']);
        }
        \app\admin\model\Role::destroy($off_ids);
        if(empty($on_ids)){
            return json(['code' => '200', 'msg' => '操作成功']);
        }else{
            return json(['code' => '200', 'msg' => '部分操作成功：部分角色被使用中，无法删除', 'data'=>$off_ids]);
        }

    }
}
