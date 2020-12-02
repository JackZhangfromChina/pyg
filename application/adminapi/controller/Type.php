<?php
    
    namespace app\adminapi\controller;
    
    use think\Controller;
    use think\Request;
    
    class Type extends BaseApi
    {
        /**
         * 显示资源列表
         *
         * @return \think\Response
         */
        public function index()
        {
            //查询数据
            $list = \app\common\model\Type::select();
            //返回数据
            $this->ok($list);
        }
        
        
        /**
         * 保存新建的资源
         *
         * @param  \think\Request  $request
         * @return \think\Response
         */
        public function save(Request $request)
        {
            //接收参数
            $params = input();
            //参数检测
            $validate = $this->validate($params, [
                'type_name|模型名称' => 'require|max:20',
                'spec|规格' => 'require|array',
                'attr|属性' => 'require|array',
            ]);
            if($validate !== true){
                $this->fail($validate);
            }
            //开启事务
            \think\Db::startTrans();
            try{
                //4+2  添加类型、批量添加规格名、批量添加规格值、批量添加属性； 去除空的规格，去除空的属性
                //添加商品类型 $type['id']  后续要使用
                $type = \app\common\model\Type::create($params, true);
                //$type = \app\common\model\Type::create(['type_name'=>$params['type_name']]);
                //添加商品规格名
                //去除空的规格值  去除没有值的规格名
                //参数数组参考：
                /*$params = [
                    'type_name' => '手机',
                    'spec' => [
                        ['name' => '颜色', 'sort' => 50, 'value'=>['黑色', '白色', '金色']],
                        //['name' => '颜色1', 'sort' => 50, 'value'=>['', '']],
                        ['name' => '内存', 'sort' => 50, 'value'=>['64G', '128G', '256G']],
                    ],
                    'attr' => [
                        ['name' => '毛重', 'sort'=>50, 'value' => []],
                        ['name' => '产地', 'sort'=>50, 'value' => ['进口', '国产','']],
                    ]
                ]*/
                //外层遍历规格名
                foreach($params['spec'] as $i=>&$spec){
                    //判断规格名是否为空
                    if(trim($spec['name']) == ''){
                        unset($params['spec'][$i]);
                        //continue;
                    }else{
                        //内存遍历规格值
                        foreach($spec['value'] as $k=>$value){
                            // $value就是一个规格值，去除空的值
                            if(trim($value) == ''){
                                //unset($spec['value'][$k]);
                                unset($params['spec'][$i]['value'][$k]);
                            }
                        }
                        //上面$spec['value']的foreach结束，判断当前的规格名的规则值是不是空数组
//                        $spec['value']和$params['spec'][$i]['value']一个意思
                        if(empty($params['spec'][$i]['value'])){
                            unset($params['spec'][$i]);
                        }
                    }
                }
                unset($spec);
                //遍历组装 数据表需要的数据
                $specs = [];
                foreach($params['spec'] as $spec){
                    $row = [
                        'type_id' => $type['id'],
                        'spec_name' => $spec['name'],
                        'sort' => $spec['sort'],
                    ];
                    $specs[] = $row;
                }
                //批量添加 规格名称
                $spec_model = new \app\common\model\Spec();
                //saveAll 如果要过滤非数据表字段，需要调用allowField方法
                $spec_data = $spec_model->allowField(true)->saveAll($specs);
                //参数数组参考：
                /*$params = [
                    'type_name' => '手机',
                    'spec' => [
                        ['name' => '颜色', 'sort' => 50, 'value'=>['黑色', '白色', '金色']],
                        //['name' => '颜色1', 'sort' => 50, 'value'=>['', '']],
                        ['name' => '内存', 'sort' => 50, 'value'=>['64G', '128G', '256G']],
                    ],
                    'attr' => [
                        ['name' => '毛重', 'sort'=>50, 'value' => []],
                        ['name' => '产地', 'sort'=>50, 'value' => ['进口', '国产','']],
                    ]
                ]*/
                /*$spec_data = [
                    ['id' => 10, 'spec_name' => '颜色', 'sort' => 50], //实际上是模型对象
                    ['id' => 20, 'spec_name' => '内存', 'sort' => 50],
                ];*/
                //$spec_ids = [10, 20]; //扩展代码
                //$spec_ids = array_column($spec_data, 'id');//扩展代码
                //添加商品规格值
                $spec_values = [];
                /*$spec_values = [
                    ['spec_id' => 10, 'spec_value' => '黑色', 'type_id' => 30],
                    ['spec_id' => 10, 'spec_value' => '白色', 'type_id' => 30],
                    ['spec_id' => 10, 'spec_value' => '金色', 'type_id' => 30],
                    ['spec_id' => 20, 'spec_value' => '32G', 'type_id' => 30],
                    ['spec_id' => 20, 'spec_value' => '64G', 'type_id' => 30],
                    ['spec_id' => 20, 'spec_value' => '128G', 'type_id' => 30],
                ];*/
                
                //外层遍历规格名称
                foreach($params['spec'] as $i=>$spec){
                    //$i  0 1 2  $spec 接收到的规格名称数组  $spec['value']数组 ['黑色','白色']
                    //内层遍历规格值
                    foreach($spec['value'] as $value){
                        $row = [
                            //'spec_id' => $spec_ids[$i], //扩展代码$params['spec'] 和 $spec_ids 下标对应
                            'spec_id' => $spec_data[$i]['id'], //$params['spec'] 和 $spec_data 下标对应
                            'spec_value' => $value,
                            'type_id' => $type['id']
                        ];
                        $spec_values[] = $row;
                    }
                }
                //批量添加规格值
                $spec_value_model = new \app\common\model\SpecValue();
                $spec_value_model->saveAll($spec_values);
                //添加商品属性
                //去除空的属性名和空的属性值
                //外层遍历属性名
                foreach($params['attr'] as $i=>&$attr){
                    if(trim($attr['name']) == ''){
                        unset($params['attr'][$i]);
                        //continue;或者if else都可以 只要层级不太深
                    }else{
                        //内层遍历属性值
                        foreach($attr['value'] as $k=>$value){
                            if(trim($value) == ''){
                                //unset($attr['value'][$k]); //对应$attr加引用的情况
                                unset($params['attr'][$i]['value'][$k]);
                            }
                        }
                    }
                }
                unset($attr);
                //批量添加属性名称属性值
                $attrs = [];
                foreach($params['attr'] as $attr){
                    $row = [
                        'attr_name' => $attr['name'],
                        'attr_values' => implode(',', $attr['value']),
                        'sort' => $attr['sort'],
                        'type_id' => $type['id'],
                    ];
                    $attrs[] = $row;
                }
                //批量添加
                $attr_model = new \app\common\model\Attribute();
                $attr_model->saveAll($attrs);
                //提交事务
                \think\Db::commit();
                //返回数据
                $type = \app\common\model\Type::find($type['id']);
                $this->ok($type);
            }catch (\Exception $e){
                //回滚事务
                \think\Db::rollback();
                //$msg = $e->getMessage();
                //$this->fail($msg);
                ////返回数据
                $this->fail('添加失败');
            }
        }
        
        /**
         * 显示指定的资源
         *
         * @param  int  $id
         * @return \think\Response
         */
        public function read($id)
        {
            //查询一条数据（包含规格信息、规格值、属性信息）  注意：with方法多个关联，逗号后不要加空格
            $info = \app\common\model\Type::with('specs,specs.spec_values,attrs')->find($id);
            //返回数据
            $this->ok($info);
            //相当于以下代码--不使用关联模型
            /*$info = \app\common\model\Type::find($id);
            $specs = \app\common\model\Spec::where('type_id', $id)->select();
            foreach($specs as &$spec){
                // $spec['id']   对应规格值表的spec_id
                $spec['spec_values'] = \app\common\model\SpecValue::where('spec_id', $spec['id'])->select();
            }
            unset($spec);
            $attrs = \app\common\model\Attribute::where('type_id', $id)->select();
            $info['specs'] = $specs;
            $info['attrs'] = $attrs;
            $this->ok($info);*/
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
            //接收参数
            $params = input();
            //参数检测
            $validate = $this->validate($params, [
                'type_name|模型名称' => 'require|max:20',
                'spec|规格' => 'require|array',
                'attr|属性' => 'require|array'
            ]);
            if($validate !== true){
                $this->fail($validate);
            }
            //开启事务
            \think\Db::startTrans();
            try{
                //修改模（类）型名称
                \app\common\model\Type::update(['type_name'=>$params['type_name']], ['id'=>$id], true);
                //\app\common\model\Type::where('id', $id)->update(['type_name'=>$params['type_name']]);
                //去除空的规格名和规格值
                //参数数组参考：
                /*$params = [
                    'type_name' => '手机',
                    'spec' => [
                        ['name' => '颜色', 'sort' => 50, 'value'=>['黑色', '白色', '金色']],
                        //['name' => '颜色1', 'sort' => 50, 'value'=>['', '']],
                        ['name' => '内存', 'sort' => 50, 'value'=>['64G', '128G', '256G']],
                    ],
                    'attr' => [
                        ['name' => '毛重', 'sort'=>50, 'value' => []],
                        ['name' => '产地', 'sort'=>50, 'value' => ['进口', '国产','']],
                    ]
                ]*/
                //外层遍历规格名称
                foreach($params['spec'] as $i=>$spec){
                    if(trim($spec['name']) == ''){
                        unset($params['spec'][$i]);
                        continue;
                    }else{
                        //内存遍历规格值
                        foreach($spec['value'] as $k=>$value){
                            //$value就是一个规格值
                            if(trim($value) == ''){
                                unset($params['spec'][$i]['value'][$k]);
                            }
                        }
                        //判断规格值数组，是否为空数组
                        if(empty($params['spec'][$i]['value'])){
                            unset($params['spec'][$i]);
                        }
                    }
                }
                //批量删除原来的规格名  删除条件 类型type_id
                \app\common\model\Spec::destroy(['type_id'=>$id]);
                //\app\common\model\Spec::where('type_id', $id)->delete();
                //批量添加新的规格名
                $specs = [];
                foreach($params['spec'] as $i=>$spec){
                    $row = [
                        'spec_name' => $spec['name'],
                        'sort' => $spec['sort'],
                        'type_id' => $id
                    ];
                    $specs[] = $row;
                }
                $spec_model = new \app\common\model\Spec();
                $spec_data = $spec_model->saveAll($specs);
                /*$spec_data = [
                    ['id' => 10, 'spec_name' => '颜色', 'sort' => 50], //实际上是模型对象
                    ['id' => 20, 'spec_name' => '内存', 'sort' => 50],
                ];*/
                //批量删除原来的规格值 这个type_id没白加，删除的时候非常方便
                \app\common\model\SpecValue::destroy(['type_id' => $id]);
                //批量添加新的规格值
                $spec_values = [];
                foreach($params['spec'] as $i=>$spec){
                    foreach($spec['value'] as $value){
                        $row = [
                            'spec_id' => $spec_data[$i]['id'],
                            'type_id' => $id,
                            'spec_value' => $value
                        ];
                        $spec_values[] = $row;
                    }
                }
                $spec_value_model = new \app\common\model\SpecValue();
                $spec_value_model->saveAll($spec_values);
                //去除空的属性值
                foreach($params['attr'] as $i=>$attr){
                    if(trim($attr['name']) == ''){
                        unset($params['attr'][$i]);
                        continue;
                    }else{
                        foreach($attr['value'] as $k=>$value){
                            if(trim($value) == ''){
                                unset($params['attr'][$i]['value'][$k]);
                            }
                        }
                    }
                }
                //批量删除原来的属性
                \app\common\model\Attribute::destroy(['type_id'=>$id]);
                //批量添加新的属性
                $attrs = [];
                foreach($params['attr'] as $i=>$attr){
                    $row = [
                        'type_id' => $id,
                        'attr_name' => $attr['name'],
                        'attr_values' => implode(',', $attr['value']),
                        'sort' => $attr['sort']
                    ];
                    $attrs[] = $row;
                }
                $attr_model = new \app\common\model\Attribute();
                $attr_model->saveAll($attrs);
                //提交事务
                \think\Db::commit();
                //返回数据
                $type = \app\common\model\Type::find($id);
                $this->ok($type);
            }catch (\Exception $e){
                //回滚事务
                \think\Db::rollback();
                //返回数据
                //$msg = $e->getMessage();
                //$this->fail($msg);
                $this->fail('操作失败');
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
            //判断是否有商品在使用该商品类型
            $goods = \app\common\model\Goods::where('type_id', $id)->find();
            if($goods){
                $this->fail('正在使用中，不能删除');
            }
            //开启事务
            \think\Db::startTrans();
            try{
                //删除数据 （商品类型、类型下的规格名、类型下的规格值、类型下的属性）
                \app\common\model\Type::destroy($id);
                \app\common\model\Spec::destroy(['type_id', $id]);
                //\app\common\model\Spec::where('type_id', $id)->delete();
                \app\common\model\SpecValue::destroy(['type_id', $id]);
                \app\common\model\Attribute::destroy(['type_id', $id]);
                //提交事务
                \think\Db::commit();
                //返回数据
                $this->ok();
            }catch(\Exception $e){
                //回滚事务
                \think\Db::rollback();
                //获取错误信息
                //$msg = $e->getMessage();
                //$this->fail($msg);
                $this->fail('删除失败');
            }
        }
    }
