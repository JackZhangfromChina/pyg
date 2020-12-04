<?php

namespace app\cli\controller;

use think\Controller;
use think\Request;

class Es extends Controller
{
    /**
     * 创建商品索引并导入全部商品文档
     * cd public
     * php index.php /cli/Es/createAllGoodsDocs
     */
    public function createAllGoodsDocs()
    {
        try{
            //实例化ES工具类
            $es = new \tools\es\MyElasticsearch();
            //创建索引
            if($es->exists_index('goods_index')) $es->delete_index('goods_index');

            $es->create_index('goods_index');
            $i = 0;
            while(true){
                //查询商品数据 每次处理1000条
                $goods = \app\common\model\Goods::with('category')->field('id,goods_name,goods_desc, goods_price,goods_logo,cate_id')->limit($i, 1000)->select();
                if(empty($goods)){
                    //查询结果为空，则停止
                    break;
                }
                //添加文档
                foreach($goods as $v){
                    unset($v['cate_id']);
                    $es->add_doc($v['id'],$v, 'goods_index', 'goods_type');
                }
                $i += 1000;
            }
            die('success');
        }catch (\Exception $e){
            $msg = $e->getMessage();
            die($msg);
        }
    }

}
