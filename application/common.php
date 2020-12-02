<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件
    if(!function_exists('encrypt_password'))
    {
        //密码加密函数
        function encrypt_password($password){
            $salt = 'dsafgdfsfsd';
            return md5($salt . md5($password));
        }
    }
    
    if (!function_exists('get_cate_list')) {
        //递归函数 实现无限级分类列表
        function get_cate_list($list,$pid=0,$level=0) {
            static $tree = array();
            foreach($list as $row) {
                if($row['pid']==$pid) {
                    $row['level'] = $level;
                    $tree[] = $row;
                    get_cate_list($list, $row['id'], $level + 1);
                }
            }
            return $tree;
        }
    }
    
    if(!function_exists('get_tree_list')){
        //引用方式实现 父子级树状结构
        function get_tree_list($list){
            //将每条数据中的id值作为其下标
            $temp = [];
            foreach($list as $v){
                $v['son'] = [];
                $temp[$v['id']] = $v;
            }
            //获取分类树
            foreach($temp as $k=>$v){
                $temp[$v['pid']]['son'][] = &$temp[$v['id']];
            }
            return isset($temp[0]['son']) ? $temp[0]['son'] : [];
        }
    }
    
    if (!function_exists('remove_xss')) {
        //使用htmlpurifier防范xss攻击
        function remove_xss($string){
            //composer安装的，不需要此步骤。相对index.php入口文件，引入HTMLPurifier.auto.php核心文件
//         require_once './plugins/htmlpurifier/HTMLPurifier.auto.php';
            // 生成配置对象
            $cfg = HTMLPurifier_Config::createDefault();
            // 以下就是配置：
            $cfg -> set('Core.Encoding', 'UTF-8');
            // 设置允许使用的HTML标签
            $cfg -> set('HTML.Allowed','div,b,strong,i,em,a[href|title],ul,ol,li,br,p[style],span[style],img[width|height|alt|src]');
            // 设置允许出现的CSS样式属性
            $cfg -> set('CSS.AllowedProperties', 'font,font-size,font-weight,font-style,font-family,text-decoration,padding-left,color,background-color,text-align');
            // 设置a标签上是否允许使用target="_blank"
            $cfg -> set('HTML.TargetBlank', TRUE);
            // 使用配置生成过滤用的对象
            $obj = new HTMLPurifier($cfg);
            // 过滤字符串
            return $obj -> purify($string);
        }
    }
    
    if(!function_exists('curl_request'))
    {
        //使用curl函数库发送请求
        function curl_request($url, $post=true, $params=[], $https=true)
        {
            //初始化请求
            $ch = curl_init($url);
            //默认是get请求。如果是post请求 设置请求方式和请求参数
            if($post){
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
            }
            //如果是https协议，禁止从服务器验证本地证书
            if($https){
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            }
            //发送请求，获取返回结果
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $res = curl_exec($ch);
            /*if(!$res){
                $msg = curl_error($ch);
                dump($msg);die;
            }*/
            //关闭请求
            curl_close($ch);
            return $res;
        }
    }
    
    if(!function_exists('sendmsg')){
        //使用curl_request函数调用短信接口发送短信
        function sendmsg($phone, $content)
        {
            //从配置中取出请求地址、appkey
            $gateway = config('msg.gateway');
            $appkey = config('msg.appkey');
            //https://way.jd.com/chuangxin/dxjk?mobile=13568813957&content=【创信】你的验证码是：5873，3分钟内有效！&appkey=您申请的APPKEY
            $url = $gateway . '?appkey=' . $appkey;
            //get请求
            /*$url .= '&mobile=' . $phone . '&content=' . $content;
            $res = curl_request($url, false, [], true);*/
            //post请求
            $params = [
                'mobile' => $phone,
                'content' => $content
            ];
            $res = curl_request($url, true, $params, true);
            //处理结果
            if(!$res){
                return '请求发送失败';
            }
            //解析结果
            $arr = json_decode($res, true);
            if(isset($arr['code']) && $arr['code'] == 10000){
                //短信接口调用成功
                return true;
            }else{
                /*if(isset($arr['msg'])){
                    return $arr['msg'];
                }*/
                return '短信发送失败';
            }
        }
    }
    
    if(!function_exists('encrypt_phone')){
        //手机号加密  15312345678   =》  153****5678
        function encrypt_phone($phone)
        {
            return substr($phone,0,3) . '****' . substr($phone, 7);
        }
    }