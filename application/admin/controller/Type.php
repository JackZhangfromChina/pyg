<?php

namespace app\admin\controller;

use think\Controller;
use think\Request;

class Type extends Base
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        //查询商品类型数据
        $where = [];
        $keyword = input('keyword', '');
        if(!empty($keyword)){
            $where['type_name'] = ['like', "%$keyword%"];
        }
        $list = \app\admin\model\Type::select();
        return view('product-type', ['list' => $list]);
    }

    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function create()
    {
        return view('product-type-add');
    }

    /**
     * 保存新建的资源
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function save(Request $request)
    {
        //接收输入参数
        $params = $request->param();
        //参数检测
        if (empty($params['type_name'])) {
            $this->error('类型名称不能为空');
        }
        \think\Db::startTrans();
        try{
            //将数据添加到商品类型表
            $type = \app\admin\model\Type::create($params, true);
            if(isset($params['spec']) && !empty($params['spec'])){
                foreach($params['spec'] as $k=>$v){
                    foreach($v['value'] as $k1=>$value){
                        if(empty($value)){
                            unset($v['value'][$k1]);
                        }
                    }
                    if(empty($v['value'])){
                        unset($params['spec'][$k]);
                    }
                }
                //添加规格名称
                $spec_data = [];
                foreach($params['spec'] as $k=>$v){
                    $spec_data[] = [
                        'type_id' => $type->id,
                        'spec_name' => $v['name'],
                        'sort' => $v['sort']
                    ];
                }
                $spec_model = new \app\admin\model\Spec();
                $spec = $spec_model->saveAll($spec_data);
                //添加规格值
                $spec_ids = array_column($spec, 'id');
                $spec_values = [];
                foreach($params['spec'] as $k=>$v){
                    foreach($v['value'] as $value){
                        $spec_values[] = [
                            'spec_id' => $spec_ids[$k],
                            'spec_value' => $value,
                            'type_id' => $type->id
                        ];
                    }
                }
                $spec_value_model = new \app\admin\model\SpecValue();
                $spec_value_model->saveAll($spec_values);
            }
            if(isset($params['attr']) && !empty($params['attr'])){
                //添加属性
                $attr_data = [];
                foreach($params['attr'] as $k=>$v){
                    if(!empty($v['value'])){
                        $attr_data[] = [
                            'type_id' => $type->id,
                            'attr_name' => $v['name'],
                            'sort' => $v['sort'],
                            'attr_values' => implode(',', $v['value']),
                        ];
                    }
                }
                $attr_model = new \app\admin\model\Attribute();
                $attr_model->saveAll($attr_data);
            }
            \think\Db::commit();
        }catch (\Exception $e){
            \think\Db::rollback();
            $msg = $e->getMessage();
            return json(['code'=>200, 'msg'=>$msg]);
        }
        return json(['code'=>200, 'msg'=>'操作成功']);
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
        $info = \app\admin\model\Type::with('specs,specs.spec_values,attrs')->find($id);
        $this->assign('info', $info);
        return view('product-type-edit');
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
        //接收输入参数
        $data = $request->param();
        //参数检测
        if (empty($data['type_name'])) {
            $this->error('类型名称不能为空');
        }
        \think\Db::startTrans();
        try{
            //将数据添加到商品类型表
            \app\admin\model\Type::update($params, ['id'=>$id], true);
            if(isset($params['spec']) && !empty($params['spec'])){
                foreach($params['spec'] as $k=>$v){
                    foreach($v['value'] as $k1=>$value){
                        if(empty($value)){
                            unset($v['value'][$k1]);
                        }
                    }
                    if(empty($v['value'])){
                        unset($params['spec'][$k]);
                    }
                }
                //修改规格名称
                $spec_data = [];
                foreach($params['spec'] as $k=>$v){
                    $spec_data[] = [
                        'type_id' => $id,
                        'spec_name' => $v['name'],
                        'sort' => $v['sort']
                    ];
                }
                \app\admin\model\Spec::destroy(['type_id'=>$id]);
                $spec_model = new \app\admin\model\Spec();
                $spec = $spec_model->saveAll($spec_data);
                //添加规格值
                $spec_ids = array_column($spec, 'id');
                $spec_values = [];
                foreach($params['spec'] as $k=>$v){
                    foreach($v['value'] as $value){
                        $spec_values[] = [
                            'type_id' => $id,
                            'spec_id' => $spec_ids[$k],
                            'spec_value' => $value
                        ];
                    }
                }
                \app\admin\model\SpecValue::destroy(['type_id'=>$id]);
                $spec_value_model = new \app\admin\model\SpecValue();
                $spec_value_model->saveAll($spec_values);
            }
            if(isset($params['attr']) && !empty($params['attr'])){
                //修改属性
                $attr_data = [];
                foreach($params['attr'] as $k=>$v){
                    if(!empty($v['value'])){
                        $attr_data[] = [
                            'id' => isset($v['id']) ? $v['id'] : null,
                            'attr_name' => $v['name'],
                            'sort' => $v['sort'],
                            'attr_values' => implode(',', $v['value']),
                        ];
                    }
                }
                \app\admin\model\Attribute::destroy(['type_id'=>$id]);
                $attr_model = new \app\admin\model\Attribute();
                $attr_model->saveAll($attr_data);
            }
            \think\Db::commit();
        }catch (\Exception $e){
            \think\Db::rollback();
            $msg = $e->getMessage();
            return json(['code'=>200, 'msg'=>$msg]);
        }
        return json(['code'=>200, 'msg'=>'操作成功']);
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
        $on_ids = \app\admin\model\Goods::where('type_id', 'in', $ids)->column('type_id');
        $off_ids = array_diff($ids, $on_ids);
        if(empty($off_ids)){
            return json(['code' => '500', 'msg' => '使用中，无法删除']);
        }
        \app\admin\model\SpecValue::where('type_id', 'in', $off_ids)->delete();
        \app\admin\model\Spec::where('type_id', 'in', $off_ids)->delete();
        \app\admin\model\Type::destroy($off_ids);
        if(empty($on_ids)){
            return json(['code' => '200', 'msg' => '操作成功']);
        }else{
            return json(['code' => '200', 'msg' => '部分操作成功；部分数据使用中，无法删除','data'=>$off_ids]);
        }
    }

    public function getSpecAttr($type_id)
    {
        $type = \app\admin\model\Type::with('attrs,specs,specs.specValues')->find($type_id);
//        dump($type->toArray());die;
        $data['attrs']=$type['attrs'];
        $data['specs']=$type['specs'];
        return json(['code' => '200', 'msg' => '操作成功','data'=>$data]);
    }
}
