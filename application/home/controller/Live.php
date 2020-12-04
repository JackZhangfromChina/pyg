<?php

namespace app\home\controller;

use think\Controller;
use think\Request;

class Live extends Base
{
    public function __construct(Request $request)
    {
        parent::__construct($request);
        if(!session('?user_info')){
            $this->redirect('home/login/login');
        }
    }

    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        $user_id = session('user_info.id');
        $list = \app\common\model\Live::where('user_id', $user_id)->order('id desc')->select();
        return view('index', ['list'=>$list]);
    }

    public function create()
    {
        return view();
    }

    public function save(Request $request)
    {
        //接收参数 name|start_time|image|goods_ids
        $params = input();
        //鉴权串
        $user_id = session('user_info.id');
        $params['user_id'] = $user_id;
        $params['start_time'] = strtotime($params['start_time']);
        //生成播流地址、推流地址、推流密钥
        $urls = \tools\live\Live::getUrl($user_id, $params['start_time']);
        $params = array_merge($params, $urls);
        $params['image'] = $this->upload_logo();
        $live = \app\common\model\Live::create($params, true);
        //关联商品
        $live_goods = [];
        foreach($params['goods_links'] as $link){
            $goods_id = Request::create($link)->param('id');
            if(empty($goods_id)){
                preg_match('/\/id\/(\d+)/', $link, $match);
                $goods_id = $match[1];
            }
            $goods = \app\common\model\Goods::find($goods_id);
            if($goods){
                $row['live_id'] = $live->id;
                $row['goods_id'] = $goods->id;
                $row['goods_name'] = $goods->goods_name;
                $row['goods_price'] = $goods->goods_price;
                $row['goods_logo'] = $goods->goods_logo;
                $row['goods_link'] = $link;
                $live_goods[] = $row;
            }
        }
        $live_goods_model = new \app\common\model\LiveGoods();
        $live_goods_model->saveAll($live_goods);
        $this->success('操作成功','home/live/index');
    }

    public function upload_logo()
    {
        //获取文件信息（对象）
        $file = request()->file('image');
        if (empty($file)) {
            //必须上传商品logo图片
            $this->error('必须上传商品logo图片');
        }
        //将文件移动到指定的目录（public 目录下  uploads目录 live目录）
        $dir = ROOT_PATH . 'public' . DS . 'uploads' . DS . 'live';
        if(!is_dir($dir)) mkdir($dir);
        $info = $file->validate(['size' => 5*1024*1024, 'ext' => ['jpg', 'png', 'gif', 'jpeg']])->move($dir);
        if (empty($info)) {
            //上传出错
            $this->error($file->getError());
        }
        //拼接图片的访问路径
        $logo = DS . "uploads" . DS . 'live' . DS . $info->getSaveName();
        \think\Image::open('.' . $logo)->thumb(200,200)->save('.'.$logo);
        return $logo;
    }

    public function read($id)
    {
        $info = \app\common\model\Live::find($id);
        if($info){
            $info['goods'] = \app\common\model\LiveGoods::where('live_id', $id)->select();
        }
        return view('read', ['info' => $info]);
    }
}
