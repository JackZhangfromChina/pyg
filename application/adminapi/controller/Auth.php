<?php
    
    namespace app\adminapi\controller;
    
    use think\Controller;
    use think\Request;
    
    class Auth extends BaseApi
    {
        /**
         * 显示资源列表
         *
         * @return 列表  普通列表；无限级分类列表；父子级树状列表tree
         */
        public function index()
        {
            //接收参数 keyword  type
            $params = input();
            $where = [];
            if(!empty($params['keyword'])){
                // where auth_name like '%%'
                $where['auth_name'] = ['like', "%{$params['keyword']}%"];
            }
            //查询数据
            $list = \app\common\model\Auth::field('id,auth_name,pid,pid_path,auth_c,auth_a,is_nav,level')->where($where)->select();
            //转化为标准的二维数组
            $list = (new \think\Collection($list))->toArray();
            if(!empty($params['type']) && $params['type'] == 'tree'){
                //父子级树状列表
                $list = get_tree_list($list);
            }else{
                //无限级分类列表
                $list = get_cate_list($list);
            }
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
            //接收数据
            $params = input();
            //临时处理
            if(empty($params['pid'])){
                $params['pid'] = 0;
            }
            if(empty($params['is_nav'])){
                $params['is_nav'] = $params['radio'];
            }
            //参数检测
            $validate = $this->validate($params, [
                'auth_name|权限名称' => 'require',
                'pid|上级权限' => 'require',
                'is_nav|菜单权限' => 'require',
                //'auth_c|控制器名称' => '',
                //'auth_a|方法名称' => '',
            ]);
            if($validate !== true){
                $this->fail($validate, 401);
            }
            //添加数据（是否顶级，级别和pid_path处理）
            if($params['pid'] == 0){
                $params['level'] = 0;
                $params['pid_path'] = 0;
                $params['auth_c'] = '';
                $params['auth_a'] = '';
            }else{
                //不是顶级权限
                //查询上级信息
                //$p_info = \app\common\model\Auth::where('id', $params['pid'])->find();
                $p_info = \app\common\model\Auth::find($params['pid']);
                if(empty($p_info)){
                    $this->fail('数据异常');
                }
                //设置级别+1  家族图谱 拼接
                $params['level'] = $p_info['level'] + 1;
                $params['pid_path'] = $p_info['pid_path'] . '_' . $p_info['id'];
            }
            //实际开发 可能不需要返回新增的这条数据
            //\app\common\model\Auth::create($params, true);
            //$this->ok();
            //restful 严格风格
            $auth = \app\common\model\Auth::create($params, true);
            $info = \app\common\model\Auth::find($auth['id']);
            //返回数据
            $this->ok($info);
            
        }
        
        /**
         * 显示指定的资源
         *
         * @param  int  $id
         * @return \think\Response
         */
        public function read($id)
        {
            //查询数据
            $auth = \app\common\model\Auth::field('id,auth_name,pid,pid_path,auth_c,auth_a,is_nav,level')->find($id);
            //返回数据
            $this->ok($auth);
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
            //接收数据
            $params = input();
            //临时处理
            if(empty($params['pid'])){
                $params['pid'] = 0;
            }
            if(empty($params['is_nav'])){
                $params['is_nav'] = $params['radio'];
            }
            //参数检测
            $validate = $this->validate($params, [
                'auth_name|权限名称' => 'require',
                'pid|上级权限' => 'require',
                'is_nav|菜单权限' => 'require',
                //'auth_c|控制器名称' => '',
                //'auth_a|方法名称' => '',
            ]);
            if($validate !== true){
                $this->fail($validate, 401);
            }
            //修改数据（是否顶级，级别和pid_path处理）
            $auth = \app\common\model\Auth::find($id);
            if(empty($auth)){
                $this->fail('数据异常');
            }
            //$params['pid']
            if($params['pid'] == 0){
                //如果修改顶级权限
                $params['level'] = 0;
                $params['pid_path'] = 0;
            }else if($params['pid'] != $auth['pid']){
                //如果修改其上级权限pid  重新设置level级别 和 pid_path 家族图谱
                $p_auth = \app\common\model\Auth::find($params['pid']);
                if(empty($p_auth)){
                    $this->fail('数据异常');
                }
                $params['level'] = $p_auth['level'] + 1;
                $params['pid_path'] = $p_auth['pid_path'] . '_' . $p_auth['id'];
            }
            \app\common\model\Auth::update($params, ['id'=>$id], true);
            //返回数据
            $info = \app\common\model\Auth::find($id);
            $this->ok($info);
            
        }
        
        /**
         * 删除指定资源
         *
         * @param  int  $id
         * @return \think\Response
         */
        public function delete($id)
        {
            //判断是否有子权限
            $total = \app\common\model\Auth::where('pid', $id)->count();
            if($total > 0){
                $this->fail('有子权限，无法删除');
            }
            //删除数据
            \app\common\model\Auth::destroy($id);
            //返回数据
            $this->ok();
        }
        
        /**
         * 菜单权限
         */
        public function nav()
        {
            //获取登录的管理员用户id
            $user_id = input('user_id');
            //查询管理员的角色id   role_id
            $info = \app\common\model\Admin::find($user_id);
            $role_id = $info['role_id'];
            //判断是否超级管理员
            if($role_id == 1){
                //超级管理员  直接查询权限表  菜单权限  is_nav = 1  所有可以展示的菜单
                $data = \app\common\model\Auth::where('is_nav', 1)->select();
            }else{
                //先查询角色表  role_auth_ids
                $role = \app\common\model\Role::find($role_id);
                $role_auth_ids = $role['role_auth_ids'];
                //再查询权限表
                $data = \app\common\model\Auth::where('is_nav', 1)->where('id', 'in', $role_auth_ids)->select();
            }
//            halt($data->toArray()); 这个好像转化不了
            //先转化为标准的二维数组
            $data = (new \think\Collection($data))->toArray();
            //再转化为 父子级树状结构
            $data = get_tree_list($data);
            //返回
            $this->ok($data);
        }
    }
