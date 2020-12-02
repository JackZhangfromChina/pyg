<?php

namespace app\admin\controller;

use think\Controller;
use think\Request;

class Category extends Base
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function getSubCateByPid($pid)
    {
        $data = \app\admin\model\Category::where('pid', $pid)->select();
        return json(['code' => 10000, 'msg' => 'success', 'data' => $data]);
    }

    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        $list = \app\admin\model\Category::select();
        $list = (new \think\Collection($list))->toArray();
        $list = get_cate_list($list);
        return view('product-category', ['list' => $list]);
    }

    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function create($pid=0)
    {
        //查询所有的一二级分类，用于下拉列表展示
        $p_cate = \app\admin\model\Category::where('level','<', 2)->select();
        $p_cate = (new \think\Collection($p_cate))->toArray();
        $p_cate = get_cate_list($p_cate);
        return view('product-category-add', ['p_cate' => $p_cate, 'pid'=>$pid]);
    }

    /**
     * 保存新建的资源
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function save(Request $request)
    {
        //接收请求参数
        $data = $request->param();
//        dump($data);die;
        //参数验证
        $validate = $this->validate($data,[
            'cate_name|分类名称' => 'require|length:2,100',
            'pid|上级分类' => 'require|integer|egt:0',
            'sort|排序' => 'require|integer|egt:0',
            'is_hot|是否热门' => 'require|in:0,1',
            'is_show|是否显示' => 'require|in:0,1',
        ]);
        if($validate!==true){
            return json(['code' => 500, 'msg' => $validate]);
        }

        if($data['pid'] == 0){
            $data['level'] = 0;
            $data['pid_path'] = 0;
        }else{
            $p_cate = \app\admin\model\Category::find($data['pid'])->getData();
            $data['level'] = $p_cate['level'] + 1;
            $data['pid_path'] = $p_cate['pid_path'] . '_' . $p_cate['id'];
            $data['pid_path_name'] = trim($p_cate['pid_path_name'] . '/' . $p_cate['cate_name'], '/');
        }

        $upload = $this->upload_logo();
        if(is_array($upload)){
            return json(['code' => 500, 'msg' => $upload[0]]);
        }
        $data['image_url'] = $upload;
        //将数据添加到表
        \app\admin\model\Category::create($data, true);
//        $this->success('操作成功', 'index');
        return json(['code' => 200, 'msg' => '操作成功']);
    }

    protected function upload_logo()
    {
        //获取文件信息（对象）
        $file = request()->file('logo');
        if (empty($file)) {
            //必须上传logo图片
            return ['必须上传logo图片'];
        }
        //将文件移动到指定的目录（public 目录下  uploads目录）
        $info = $file->validate(['size' => 10*1024*1024, 'ext' => ['jpg', 'png', 'gif', 'jpeg']])->move(ROOT_PATH . 'public' . DS . 'uploads');
        if (empty($info)) {
            //上传出错
            return [$file->getError()];
        }
        //拼接图片的访问路径
        $logo = DS . "uploads" . DS . $info->getSaveName();
        //生成缩略图
        $image = \think\Image::open('.' . $logo);
        //调用thumb方法生成缩略图并保存（直接覆盖原始图片）
        $image->thumb(200, 200)->save('.' . $logo);
        return $logo;
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
        //查询所有的一二级分类，用于下拉列表展示
        $p_cate = \app\admin\model\Category::where('level','<', 2)->select();
        $p_cate = (new \think\Collection($p_cate))->toArray();
        $p_cate = get_cate_list($p_cate);
        //查询分类原始信息
        $info = \app\admin\model\Category::find($id);
        return view('product-category-edit', ['p_cate' => $p_cate, 'info' =>$info]);
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
        //接收请求参数
        $data = $request->param();
        //参数验证
        $validate = $this->validate($data,[
            'cate_name|分类名称' => 'require|length:2,10',
            'pid|上级分类' => 'require|integer|egt:0',
            'sort|排序' => 'require|integer|egt:0',
            'is_hot|是否热门' => 'require|in:0,1',
            'is_show|是否显示' => 'require|in:0,1',
        ]);
        if($validate!==true){
            return json(['code' => 500, 'msg' => $validate]);
        }

        if($data['pid'] == 0){
            $data['level'] = 0;
            $data['pid_path'] = 0;
        }else{
            $p_cate = \app\admin\model\Category::find($data['pid'])->getData();
            if(empty($p_cate)){
                return json(['code' => 500, 'msg' => '数据异常，请刷新重试']);
            }
            $data['level'] = $p_cate['level'] + 1;
            $data['pid_path'] = $p_cate['pid_path'] . '_' . $p_cate['id'];
            $data['pid_path_name'] = trim($p_cate['pid_path_name'] . '/' . $p_cate['cate_name'], '/');
        }
        if(request()->file('logo')){
            $upload = $this->upload_logo();
            if(is_array($upload)){
                return json(['code' => 500, 'msg' => $upload[0]]);
            }
            $data['image_url'] = $upload;
        }
    
        //将数据修改到表
        \app\admin\model\Category::update($data,['id'=>$id], true);
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
        $total = \app\admin\model\Category::where('pid', $id)->count();
        if($total){
            return json(['code' => '500', 'msg' => '分类下有子分类，不能直接删除']);
        }
        \app\admin\model\Category::destroy($id);
        return json(['code' => '200', 'msg' => '操作成功']);
    }
}
