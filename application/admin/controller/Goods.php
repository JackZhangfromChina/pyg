<?php

namespace app\admin\controller;

use app\admin\model\GoodsAttr;
use think\Controller;
use think\Request;
class Goods extends Base
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        $params = input();
        $where = [];
        $config = [];
        if(isset($params['keyword']) && !empty($params['keyword'])){
            $keyword = $params['keyword'];
            $where['goods_name'] = ['like', "%$keyword%"];
            $config['query'] = ['keyword'=>$keyword];
        }
        $list = \app\admin\model\Goods::with('category,type,brand')->where($where)->order('id desc')->paginate(2, false, $config);
        foreach($list as &$v){
            $v['cate_name'] = $v['category']['cate_name'];
            $v['type_name'] = $v['type']['type_name'];
            $v['brand_name'] = $v['brand']['name'];
            unset($v['category']);
            unset($v['type']);
            unset($v['brand']);
        }
        
        //模板赋值和模板渲染
        return view('product-list', ['list' => $list]);
    }

    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function create()
    {
        //查询商品分类数据，用于页面下拉列表展示
        $category = \app\admin\model\Category::where('pid', 0)->select();
        //查询商品类型数据，用于商品属性栏 下拉列表展示
        $type = \app\admin\model\Type::select();
        return view('product-add', ['category' => $category, 'type' => $type]);
    }

    /**
     * 保存新建的资源
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function save(Request $request)
    {
        //获取输入变量
//        $data = request()->param();
        //使用依赖注入的$request对象。
        $data = $request->param();

        //富文本编辑器字段做特殊处理
        $data['goods_desc'] = $request->param('goods_desc', '', 'remove_xss');
        //表单验证
        //定义验证规则
        $rule = [
            'goods_name' => 'require|max:100|unique:goods',
            'goods_price' => 'require|float|gt:0',
            'goods_number' => 'require|integer|gt:0',
            'cate_id' => 'require|integer|gt:0'
        ];
        //定义提示信息（可选）
        $msg = [
            'goods_name.require' => '商品名称不能为空',
            'goods_name.max' => '商品名称长度不能超过25',
            'goods_name.unique' => '商品名称已经存在',
            'goods_price.require' => '商品价格不能为空',
            'goods_price.float' => '商品价格必须是浮点数',
            'goods_price.gt' => '商品价格必须大于0',
            'goods_number.require' => '商品数量不能为空',
            'goods_number.integer' => '商品数量必须是整数',
            'goods_number.gt' => '商品数量必须大于0',
            'cate_id.require' => '商品分类必须选择'
        ];
        //检测
        $validate = $this->validate($data, $rule, $msg);
        if($validate !== true){
            return json(['code' => '500', 'msg' => $validate]);
        }
        \think\Db::startTrans();
        try{
            //商品logo图片缩略图
            if(file_exists('.' . $data['goods_logo'])){
                //生成缩略图
                $image = \think\Image::open('.' . $data['goods_logo']);
                $goods_logo = dirname($data['goods_logo']) . DS . 'thumb_' . basename($data['goods_logo']);
                //调用thumb方法生成缩略图并保存（直接覆盖原始图片）
                $image->thumb(200, 200)->save('.' . $goods_logo);
                $data['goods_logo'] = $goods_logo;
            }


            //商品属性值关联保存 tpshop_goods表
            $data['goods_attr'] = json_encode($data['attr'], JSON_UNESCAPED_UNICODE);
            //数据添加到数据表 create方法第二个参数true表示过滤非数据表中的字段
            $goods = \app\admin\model\Goods::create($data, true);
            //进行商品相册图片上传
            //商品logo图片缩略图
            if(!empty($data['goods_images'])){
                $images_data = [];
                foreach($data['goods_images'] as $file){
                    if(file_exists('.' . $file)){
                        //生成三张不同规格的缩略图（800*800， 350*350， 50*50）
                        $image = \think\Image::open( '.' . $file);
                        //生成800*800 大图
                        $pics_big = dirname($file) . DS . 'thumb_big_' . basename($file);
                        $image->thumb(800, 800)->save('.' . $pics_big);
                        //生成400*400 小图
                        $pics_sma = dirname($file) . DS . 'thumb_sma_' . basename($file);
                        $image->thumb(400, 400)->save('.' . $pics_sma);

                        //组装一条数据
                        $row = [
                            'goods_id' => $goods->id,
                            'pics_big' => $pics_big,
                            'pics_sma' => $pics_sma
                        ];
                        //将一条数据放到结果数组中，用于最后批量添加
                        $images_data[] = $row;
                    }
                }
                //批量添加数据
                $goods_images_model = new \app\admin\model\GoodsImages();
                $goods_images_model->saveAll($images_data);
            }

            //商品规格值关联保存 tpshop_spec_goods表
            $specs = $data['item'];
            //结果数组
            $spec_goods = [];
            foreach ($specs as $k => $v) {
                //$k 是 value_ids   $v是一个数组
                //组装一条数据
                $v['goods_id'] = $goods->id;
                //将组装的数据放到结果数组，用于批量添加
                $spec_goods[] = $v;
            }
            //批量添加到tpshop_goods_attr表
            $spec_goods_model  = new \app\admin\model\SpecGoods;
            $spec_goods_model->saveAll($spec_goods);
            \think\Db::commit();
        }catch(\Exception $e){
            \think\Db::rollback();
            $msg = $e->getMessage();
            return json(['code' => '500', 'msg' => $msg]);
        }
        
        return json(['code' => '200', 'msg' => '操作成功']);
    }


    public function read($id)
    {
        //查询一条数据
        $info = \app\admin\model\Goods::find($id);
        $this->assign('info', $info);
        return view();
    }

    /**
     * 显示编辑资源表单页. Todo未完成
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function edit($id)
    {
        //查询原始商品数据
        $info = \app\admin\model\Goods::with('category,category.brands,brand,type,type.specs,type.specs.spec_values,goods_images,spec_goods')->find($id);
//        halt($info->toArray());
        $info = json_decode(json_encode($info), true);
        // dump($info);die;
        $info['type']['attrs'] = \app\admin\model\Attribute::where('type_id', $info['type_id'])->select();
        //所有一级
        $category_one = \app\admin\model\Category::where('pid', 0)->select();
        //当前一级下所有二级
        $category_two = \app\admin\model\Category::where('pid', $info['category']['pid_path'][1])->select();
        //当前二级下所有三级
        $category_three = \app\admin\model\Category::where('pid', $info['category']['pid_path'][2])->select();
        //查询商品模型数据，用于下拉列表展示
        $type = \app\admin\model\Type::select();
        $value_ids = explode('_', implode('_', array_column($info['spec_goods'], 'value_ids')));
        $info['value_ids'] = array_unique($value_ids);
        foreach($info['spec_goods'] as $k=>&$v){
            $v['spec_values'] = \app\admin\model\SpecValue::select(explode('_', $v['value_ids']));
        }
        unset($v);
        $data = [
            'goods' => $info,
            'category' => [
                'cate_one' => $category_one,
                'cate_two' => $category_two,
                'cate_three' => $category_three,
            ],
            'type' => $type
        ];
        
        return view('product-edit', $data);
    }

    /**
     * 保存更新的资源 Todo未完成
     *
     * @param  \think\Request  $request
     * @param  int  $id
     * @return \think\Response
     */
    public function update(Request $request, $id)
    {
        //获取输入变量
        // $data = request()->param();
        //使用依赖注入的$request对象。
        $data = $request->param();

        //富文本编辑器字段做特殊处理
        $data['goods_desc'] = $request->param('goods_desc', '', 'remove_xss');
        //表单验证
        //定义验证规则
        $rule = [
            'goods_name' => 'require|max:100|unique:goods',
            'goods_price' => 'require|float|gt:0',
            'goods_number' => 'require|integer|gt:0',
            'cate_id' => 'require|integer|gt:0'
        ];
        //定义提示信息（可选）
        $msg = [
            'goods_name.require' => '商品名称不能为空',
            'goods_name.max' => '商品名称长度不能超过25',
            'goods_name.unique' => '商品名称已经存在',
            'goods_price.require' => '商品价格不能为空',
            'goods_price.float' => '商品价格必须是浮点数',
            'goods_price.gt' => '商品价格必须大于0',
            'goods_number.require' => '商品数量不能为空',
            'goods_number.integer' => '商品数量必须是整数',
            'goods_number.gt' => '商品数量必须大于0',
            'cate_id.require' => '商品分类必须选择'
        ];
        //检测
        $validate = $this->validate($data, $rule, $msg);
        if($validate !== true){
            return json(['code' => '500', 'msg' => $validate]);
        }
        \think\Db::startTrans();
        try{
            //商品logo图片缩略图
            if(file_exists('.' . $data['goods_logo'])){
                //生成缩略图
                $image = \think\Image::open('.' . $data['goods_logo']);
                $goods_logo = dirname($data['goods_logo']) . DS . 'thumb_' . basename($data['goods_logo']);
                //调用thumb方法生成缩略图并保存（直接覆盖原始图片）
                $image->thumb(200, 200)->save('.' . $goods_logo);
                $data['goods_logo'] = $goods_logo;
            }
            //商品属性值关联保存 tpshop_goods表
            $data['goods_attr'] = json_encode($data['attr'], JSON_UNESCAPED_UNICODE);
            //数据添加到数据表 create方法第二个参数true表示过滤非数据表中的字段
            $goods = \app\admin\model\Goods::update($data, ['id'=>$id], true);
            //进行商品相册图片上传
            //商品logo图片缩略图
            if(!empty($data['goods_images'])){
                $images_data = [];
                foreach($data['goods_images'] as $file){
                    if(file_exists('.' . $file)){
                        //生成三张不同规格的缩略图（800*800， 350*350， 50*50）
                        $image = \think\Image::open( '.' . $file);
                        //生成800*800 大图
                        $pics_big = dirname($file) . DS . 'thumb_big_' . basename($file);
                        $image->thumb(800, 800)->save('.' . $pics_big);
                        //生成400*400 小图
                        $pics_sma = dirname($file) . DS . 'thumb_sma_' . basename($file);
                        $image->thumb(400, 400)->save('.' . $pics_sma);

                        //组装一条数据
                        $row = [
                            'goods_id' => $id,
                            'pics_big' => $pics_big,
                            'pics_sma' => $pics_sma
                        ];
                        //将一条数据放到结果数组中，用于最后批量添加
                        $images_data[] = $row;
                    }
                }
                //批量添加数据
                $goods_images_model = new \app\admin\model\GoodsImages();
                $goods_images_model->saveAll($images_data);
            }

            //商品规格值关联保存 tpshop_spec_goods表
            $specs = $data['item'];
            //结果数组
            $spec_goods = [];
            foreach ($specs as $k => $v) {
                //$k 是 value_ids   $v是一个数组
                //组装一条数据
                $v['goods_id'] = $goods->id;
                //将组装的数据放到结果数组，用于批量添加
                $spec_goods[] = $v;
            }
            //批量添加到tpshop_spec_goods表 商品规格表
            \app\admin\model\SpecGoods::destroy(['goods_id'=>$id]);
            $spec_goods_model  = new \app\admin\model\SpecGoods;
            $spec_goods_model->saveAll($spec_goods);
            \think\Db::commit();
            return json(['code' => '200', 'msg' => '操作成功']);
        }catch(\Exception $e){
            \think\Db::rollback();
            $msg = $e->getMessage();
            return json(['code' => '500', 'msg' => $msg]);
        }
    }

    /**
     * 删除指定资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function delete($id)
    {

        //先查询再删除
        // $goods = \app\admin\model\Goods::find($id);
        // $goods->delete();
        //destroy方法
        \app\admin\model\Goods::destroy($id);
        //页面跳转
        // $this->success('删除成功', 'index');
        return json(['code' => '200', 'msg' => '操作成功']);
    }

    /**
     * ajax删除相册图片
     */
    public function delpics($pics_id)
    {
        // $pics_id = request()->param('pics_id');
        //从相册表删除一条数据
        \app\admin\model\GoodsImages::destroy($pics_id);
        return ['code' => 10000, 'msg' => '删除成功'];
    }

    //根据类型id获取类型下的属性名称信息
    public function getattr($type_id){
        //根据type_id查询tpshop_attribute表  类型下的属性名称信息
        $data = \app\admin\model\Attribute::where('type_id', $type_id)->select();

        foreach ($data as &$v) {
            //设置过获取器，这里想要得到原始数据
            $v = $v->getData();
            //根据页面需要，将attr_values由字符串分割为数组
            $v['attr_values'] = explode(',', $v['attr_values']);
        }
        return ['code' => 10000, 'msg' => 'success', 'data' => $data];
    }
}
