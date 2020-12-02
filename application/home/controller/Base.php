<?php
    
    namespace app\home\controller;
    
    use think\Controller;
    use think\Request;
    
    class Base extends Controller
    {
        public function __construct(Request $request)
        {
            parent::__construct($request);
            //查询分类信息
            $category = \app\common\model\Category::select();
            //转化为标准的二维数组
            $category = (new \think\Collection($category))->toArray();
            //转化为父子级树状结构
            $category = get_tree_list($category);
            //变量赋值
            $this->assign('category', $category);
        }
    }
