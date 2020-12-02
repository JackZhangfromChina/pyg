<?php

namespace app\admin\controller;

use think\Controller;
use think\Request;

class Auth extends Base
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        //查询权限表数据
        $list = \app\admin\model\Auth::select();
        //使用封装的get_cate_list递归函数重新排序 无限级分类列表
        $list = (new \think\Collection($list))->toArray();
        $list = get_cate_list($list);
        return view('admin-permission', ['list' => $list]);
    }

    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function create($pid=0)
    {
        //查询所有的一二三级权限，用于下拉列表展示
        $p_auth = \app\admin\model\Auth::where('level','<', 3)->select();
        $p_auth = (new \think\Collection($p_auth))->toArray();
        $p_auth = get_cate_list($p_auth);
        return view('admin-permission-add', ['p_auth' => $p_auth, 'pid' => intval($pid)]);
    }

    /**
     * 保存新建的资源ajax
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function save(Request $request)
    {
        //接收请求参数
        $data = $request->param();
        //参数验证
        $validate = $this->validate($data,[
            'auth_name|权限名称' => 'require|length:2,10',
            'pid|上级权限' => 'require|integer|egt:0',
        ]);
        if($validate!==true){
            return json(['code' => 500, 'msg' => $validate]);
        }

        if($data['pid'] == 0){
            unset($data['auth_c'], $data['auth_a']);
            $data['level'] = 0;
            $data['pid_path'] = 0;
        }else{
            $p_auth = \app\admin\model\Auth::find($data['pid']);
            $data['level'] = $p_auth['level'] + 1;
            $data['pid_path'] = $p_auth['pid_path'] . '_' . $p_auth['id'];
        }

        //将数据添加到auth表
        \app\admin\model\Auth::create($data, true);
//        $this->success('操作成功', 'index');
        return json(['code' => 200, 'msg' => '操作成功']);
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
        $info = \app\admin\model\Auth::find($id)->getData();
        $this->assign('info', $info);

        //查询所有的父级权限，用于下拉列表展示
        $p_auth = \app\admin\model\Auth::where('level', '<', 3)->select();
        $p_auth = (new \think\Collection($p_auth))->toArray();
        $p_auth = get_cate_list($p_auth);

        $this->assign('p_auth', $p_auth);
        return view('admin-permission-edit');
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
        //参数验证
        $validate = $this->validate($data,[
            'auth_name|权限名称' => 'require|length:2,10',
            'pid|上级权限' => 'require|integer|egt:0',
        ]);
        if($validate!==true){
            return json(['code' => 500, 'msg' => $validate]);
        }

        if($data['pid'] == 0){
            $data['auth_c'] = '';
            $data['auth_a'] = '';
            $data['level'] = 0;
            $data['pid_path'] = 0;
        }else{
            $p_auth = \app\admin\model\Auth::find($data['pid']);
            if(empty($p_auth)) return json(['code' => 500, 'msg' => '数据异常，请刷新重试']);
            $data['level'] = $p_auth['level'] + 1;
            $data['pid_path'] = $p_auth['pid_path'] . '_' . $p_auth['id'];
        }

        \app\admin\model\Auth::update($data,['id' => $id], true);
        return json(['code' => 200, 'msg' => '操作成功']);
    }

    /**
     * 删除指定资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function delete($id)
    {
        $total = \app\admin\model\Auth::where('pid', $id)->count();
        if($total){
            return json(['code' => 500, 'msg' => '权限下有子权限，不能直接删除']);
        }
        \app\admin\model\Auth::destroy($id);
        return json(['code' => 200, 'msg' => '删除成功']);
    }
}
