<?php

namespace app\admin\controller;

use think\Controller;
use think\Request;

class Brand extends Base
{
    public function getBrandByCateId($cate_id)
    {
        $data = \app\admin\model\Brand::where('cate_id', $cate_id)->select();
        return json(['code' => 10000, 'msg' => 'success', 'data' => $data]);
    }
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        $where = [];
        $keyword = input('keyword', '');
        if(!empty($keyword)){
            $where['name'] = ['like', "%$keyword%"];
        }
        $list = \app\admin\model\Brand::with('category')->where($where)->select();
        return view('product-brand', ['list' => $list]);
    }

    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function create()
    {
        $categorys = \app\admin\model\Category::where('pid', 0)->select();
        return view('product-brand-add', ['categorys'=>$categorys]);
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
        $upload = $this->upload_logo();
        if(is_array($upload)){
            return json(['code' => 500, 'msg' => $upload[0]]);
        }
        $data['logo'] = $upload;
        //将数据添加到数据表
        \app\admin\model\Brand::create($data, true);
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
        $categorys = \app\admin\model\Category::where('pid', 0)->select();
        $info = \app\admin\model\Brand::with('category')->find($id);
        return view('product-brand-edit', ['categorys'=>$categorys, 'info' => $info]);
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
        //参数检测 略
        if(request()->file('logo')){
            $upload = $this->upload_logo();
            if(is_array($upload)){
                return json(['code' => 500, 'msg' => $upload[0]]);
            }
            $data['logo'] = $upload;
        }else{
            unset($data['logo']);
        }
        if(empty($data['cate_id'])) unset($data['cate_id']);
        //将数据修改到数据表
        \app\admin\model\Brand::update($data, ['id'=>$id], true);
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
        $total = \app\admin\model\Goods::where('brand_id', $id)->count();
        if($total){
            return json(['code' => '500', 'msg' => '品牌下有商品，不能直接删除']);
        }
        \app\admin\model\Brand::destroy($id);
        return json(['code' => '200', 'msg' => '操作成功']);
    }
}
