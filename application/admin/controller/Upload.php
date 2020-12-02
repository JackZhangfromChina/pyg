<?php

namespace app\admin\controller;

use think\Controller;
use think\Request;

class Upload extends Base
{
    /**
     * 上传logo图片（单文件）
     * @param type goods|brand|category
     * @param logo file
     * @return \think\Response
     */
    public function logo()
    {
        $params = input();
        $type = $params['image_type'] ?? 'other';
        //获取文件信息（对象）
        $file = request()->file('logo');
        if (empty($file)) {
            //必须上传商品logo图片
            $this->fail('请上传文件');
        }
        //将文件移动到指定的目录（public 目录下  uploads目录 goods目录）
        $dir = ROOT_PATH . 'public' . DS . 'uploads' . DS . $type;
        if(!is_dir($dir)) mkdir($dir);
        $info = $file->validate(['size' => 10*1024*1024, 'ext' => ['jpg', 'png', 'gif', 'jpeg']])->move($dir);
        if (empty($info)) {
            //上传出错
            $msg = $file->getError();
            $this->fail($msg);
        }
        //拼接图片的访问路径
        $logo = DS . "uploads" . DS . $type . DS . $info->getSaveName();
        $this->ok($logo);
    }
    public function image()
    {
        $params = input();
        $type = $params['image_type'] ?? 'other';
        //获取文件信息（对象）
        $file = request()->file('image');
        if (empty($file)) {
            //必须上传商品图片
            $this->fail('请上传文件');
        }
        //将文件移动到指定的目录（public 目录下  uploads目录 goods目录）
        $dir = ROOT_PATH . 'public' . DS . 'uploads' . DS . $type;
        if(!is_dir($dir)) mkdir($dir);
        $info = $file->validate(['size' => 10*1024*1024, 'ext' => ['jpg', 'png', 'gif', 'jpeg']])->move($dir);
        if (empty($info)) {
            //上传出错
            $msg = $file->getError();
            $this->fail($msg);
        }
        //拼接图片的访问路径
        $logo = DS . "uploads" . DS . $type . DS . $info->getSaveName();
        $this->ok($logo);
    }

    /**
     * 上传相册图片 多文件
     * @param type goods  default:goods
     * @param images files
     * @return array ['success'=>[], 'error'=>[]]
     */

    public function images()
    {
        $params = input();
        $type = $params['type'] ?? 'goods';
        //获取文件信息（对象）
        $files = request()->file('images');
        if (empty($files)) {
            //必须上传商品logo图片
            $this->fail('请上传文件');
        }
        //将文件移动到指定的目录（public 目录下  uploads目录 goods目录）
        $dir = ROOT_PATH . 'public' . DS . 'uploads' . DS . $type;
        if(!is_dir($dir)) mkdir($dir);
        $data = ['success'=>[], 'error'=>[]];
        foreach($files as $file){
            $info = $file->validate(['size' => 10*1024*1024, 'ext' => ['jpg', 'png', 'gif', 'jpeg']])->move($dir);
            if ($info) {
                //拼接图片的访问路径
                $data['success'][] = DS . "uploads" . DS . $type . DS . $info->getSaveName();
            }else{
                $data['error'][] = [
                    'name'=>$file->getInfo('name'),
                    'msg'=>$file->getError(),
                ];
            }
        }
        $this->ok($data);
    }

}
