<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:81:"/Users/mmws/work/charge/pyg/pyg/public/../application/home/view/order/create.html";i:1606811526;s:65:"/Users/mmws/work/charge/pyg/pyg/application/home/view/layout.html";i:1606792587;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
    <link rel="stylesheet" type="text/css" href="/static/home/css/all.css" />
    <script type="text/javascript" src="/static/home/js/all.js"></script>
</head>
<body>
<!-- 头部栏位 -->
<!--页面顶部-->
<div id="nav-bottom">
    <!--顶部-->
    <div class="nav-top">
        <div class="top">
            <div class="py-container">
                <div class="shortcut">
                    <ul class="fl">
                        <li class="f-item">品优购欢迎您！</li>
                        <?php if((\think\Session::get('user_info') == '')): ?>
                        <li class="f-item">请
                            <a href="<?php echo url('home/login/login'); ?>" >登录</a>　
                            <span><a href="<?php echo url('home/login/register'); ?>" >免费注册</a></span>
                        </li>
                        <?php else: ?>
                        <li class="f-item">Hi,
                            <a href="javascript:;" >
                                <?php if((\think\Session::get('user_info.nickname'))): ?>
                                <?php echo \think\Session::get('user_info.nickname'); else: ?>
                                <?php echo \think\Session::get('user_info.username'); endif; ?></a>　
                            <span><a href="<?php echo url('home/login/logout'); ?>" >退出</a></span>
                        </li>
                        <?php endif; ?>
                    </ul>
                    <ul class="fr">
                        <li class="f-item">我的订单</li>
                        <li class="f-item space"></li>
                        <li class="f-item"><a href="home.html" target="_blank">我的品优购</a></li>
                        <li class="f-item space"></li>
                        <li class="f-item">品优购会员</li>
                        <li class="f-item space"></li>
                        <li class="f-item">企业采购</li>
                        <li class="f-item space"></li>
                        <li class="f-item">关注品优购</li>
                        <li class="f-item space"></li>
                        <li class="f-item" id="service">
                            <span>客户服务</span>
                            <ul class="service">
                                <li><a href="cooperation.html" target="_blank">合作招商</a></li>
                                <li><a href="shoplogin.html" target="_blank">商家后台</a></li>
                            </ul>
                        </li>
                        <li class="f-item space"></li>
                        <li class="f-item">网站导航</li>
                    </ul>
                </div>
            </div>
        </div>

        <!--头部-->
        <div class="header">
            <div class="py-container">
                <div class="yui3-g Logo">
                    <div class="yui3-u Left logoArea">
                        <a class="logo-bd" title="品优购" href="JD-index.html" target="_blank"></a>
                    </div>
                    <div class="yui3-u Center searchArea">
                        <div class="search">
                            <form action="" class="sui-form form-inline">
                                <!--searchAutoComplete-->
                                <div class="input-append">
                                    <input type="text" id="autocomplete" type="text" class="input-error input-xxlarge" />
                                    <button class="sui-btn btn-xlarge btn-danger" type="button">搜索</button>
                                </div>
                            </form>
                        </div>
                        <div class="hotwords">
                            <ul>
                                <li class="f-item">品优购首发</li>
                                <li class="f-item">亿元优惠</li>
                                <li class="f-item">9.9元团购</li>
                                <li class="f-item">每满99减30</li>
                                <li class="f-item">亿元优惠</li>
                                <li class="f-item">9.9元团购</li>
                                <li class="f-item">办公用品</li>

                            </ul>
                        </div>
                    </div>
                    <div class="yui3-u Right shopArea">
                        <div class="fr shopcar">
                            <div class="show-shopcar" id="shopcar">
                                <span class="car"></span>
                                <a class="sui-btn btn-default btn-xlarge" href="<?php echo url('home/cart/index'); ?>" target="_blank">
                                    <span>我的购物车</span>
                                    <i class="shopnum">0</i>
                                </a>
                                <div class="clearfix shopcarlist" id="shopcarlist" style="display:none">
                                    <p>"啊哦，你的购物车还没有商品哦！"</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="yui3-g NavList">
                    <div class="all-sorts-list">
                        <div class="yui3-u Left all-sort">
                            <h4>全部商品分类</h4>
                        </div>
                        <div class="sort">
                            <div class="all-sort-list2">
                                <div class="item bo">
                                    <h3><a href="">图书、音像、数字商品</a></h3>
                                    <div class="item-list clearfix">
                                        <div class="subitem">
                                            <dl class="fore1">
                                                <dt><a href="">电子书</a></dt>
                                                <dd><a href="">免费</a><a href="">小说</a></em><a href="">励志与成功</a><em><a href="">婚恋/两性</a></em><em><a href="">文学</a></em><em><a href="">经管</a></em><em><a href="">畅读VIP</a></em></dd>
                                            </dl>
                                        </div>
                                    </div>
                                </div>
                                <div class="item">
                                    <h3><a href="">家用电器</a></h3>
                                    <div class="item-list clearfix">
                                        <div class="subitem">
                                            <dl class="fore1">
                                                <dt><a href="">电子书1</a></dt>
                                                <dd><em><a href="">免费</a></em><em><a href="">小说</a></em><em><a href="">励志与成功</a></em><em><a href="">婚恋/两性</a></em><em><a href="">文学</a></em><em><a href="">经管</a></em><em><a href="">畅读VIP</a></em></dd>
                                            </dl>
                                            <dl class="fore2">
                                                <dt><a href="">数字音乐</a></dt>
                                                <dd><em><a href="">通俗流行</a></em><em><a href="">古典音乐</a></em><em><a href="">摇滚说唱</a></em><em><a href="">爵士蓝调</a></em><em><a href="">乡村民谣</a></em><em><a href="">有声读物</a></em></dd>
                                            </dl>
                                            <dl class="fore3">
                                                <dt><a href="">音像</a></dt>
                                                <dd><em><a href="">音乐</a></em><em><a href="">影视</a></em><em><a href="">教育音像</a></em><em><a href="">游戏</a></em></dd>
                                            </dl>
                                            <dl class="fore4">
                                                <dt>文艺</dt>
                                                <dd><em><a href="">小说</a></em><em><a href="">文学</a></em><em><a href="">青春文学</a></em><em><a href="">传记</a></em><em><a href="">艺术</a></em></dd>
                                            </dl>
                                            <dl class="fore5">
                                                <dt>人文社科</dt>
                                                <dd><em><a href="">历史</a></em><em><a href="">心理学</a></em><em><a href="">政治/军事</a></em><em><a href="">国学/古籍</a></em><em><a href="">哲学/宗教</a></em><em><a href="">社会科学</a></em></dd>
                                            </dl>
                                            <dl class="fore6">
                                                <dt>经管励志</dt>
                                                <dd><em><a href="">经济</a></em><em><a href="">金融与投资</a></em><em><a href="">管理</a></em><em><a href="">励志与成功</a></em></dd>
                                            </dl>
                                            <dl class="fore7">
                                                <dt>生活</dt>
                                                <dd><em><a href="">家庭与育儿</a></em><em><a href="">旅游/地图</a></em><em><a href="">烹饪/美食</a></em><em><a href="">时尚/美妆</a></em><em><a href="">家居</a></em><em><a href="">婚恋与两性</a></em><em><a href="">娱乐/休闲</a></em><em><a href="">健身与保健</a></em><em><a href="">动漫/幽默</a></em><em><a href="">体育/运动</a></em></dd>
                                            </dl>
                                            <dl class="fore8">
                                                <dt>科技</dt>
                                                <dd><em><a href="">科普</a></em><em><a href="">IT</a></em><em><a href="">建筑</a></em><em><a href="">医学</a></em><em><a href="">工业技术</a></em><em><a href="">电子/通信</a></em><em><a href="">农林</a></em><em><a href="">科学与自然</a></em></dd>
                                            </dl>
                                            <dl class="fore9">
                                                <dt>少儿</dt>
                                                <dd><em><a href="">少儿</a></em><em><a href="">0-2岁</a></em><em><a href="">3-6岁</a></em><em><a href="">7-10岁</a></em><em><a href="">11-14岁</a></em></dd>
                                            </dl>
                                        </div>
                                    </div>
                                </div>
                                <div class="item">
                                    <h3><a href="">手机、数码</a></h3>
                                    <div class="item-list clearfix">
                                        <div class="subitem">
                                            <dl class="fore1">
                                                <dt><a href="">电子书2</a></dt>
                                                <dd><em><a href="">免费</a></em><em><a href="">小说</a></em><em><a href="">励志与成功</a></em><em><a href="">婚恋/两性</a></em><em><a href="">文学</a></em><em><a href="">经管</a></em><em><a href="">畅读VIP</a></em></dd>
                                            </dl>
                                            <dl class="fore2">
                                                <dt><a href="">数字音乐</a></dt>
                                                <dd><em><a href="">通俗流行</a></em><em><a href="">古典音乐</a></em><em><a href="">摇滚说唱</a></em><em><a href="">爵士蓝调</a></em><em><a href="">乡村民谣</a></em><em><a href="">有声读物</a></em></dd>
                                            </dl>
                                            <dl class="fore3">
                                                <dt><a href="">音像</a></dt>
                                                <dd><em><a href="">音乐</a></em><em><a href="">影视</a></em><em><a href="">教育音像</a></em><em><a href="">游戏</a></em></dd>
                                            </dl>
                                            <dl class="fore4">
                                                <dt>文艺</dt>
                                                <dd><em><a href="">小说</a></em><em><a href="">文学</a></em><em><a href="">青春文学</a></em><em><a href="">传记</a></em><em><a href="">艺术</a></em></dd>
                                            </dl>
                                            <dl class="fore5">
                                                <dt>人文社科</dt>
                                                <dd><em><a href="">历史</a></em><em><a href="">心理学</a></em><em><a href="">政治/军事</a></em><em><a href="">国学/古籍</a></em><em><a href="">哲学/宗教</a></em><em><a href="">社会科学</a></em></dd>
                                            </dl>
                                        </div>
                                    </div>
                                </div>
                                <div class="item">
                                    <h3><a href="">电脑、办公</a></h3>
                                    <div class="item-list clearfix">
                                        <div class="subitem">
                                            <dl class="fore1">
                                                <dt><a href="">电子书3</a></dt>
                                                <dd><em><a href="">免费</a></em><em><a href="">小说</a></em><em><a href="">励志与成功</a></em><em><a href="">婚恋/两性</a></em><em><a href="">文学</a></em><em><a href="">经管</a></em><em><a href="">畅读VIP</a></em></dd>
                                            </dl>
                                            <dl class="fore2">
                                                <dt><a href="">数字音乐</a></dt>
                                                <dd><em><a href="">通俗流行</a></em><em><a href="">古典音乐</a></em><em><a href="">摇滚说唱</a></em><em><a href="">爵士蓝调</a></em><em><a href="">乡村民谣</a></em><em><a href="">有声读物</a></em></dd>
                                            </dl>
                                            <dl class="fore3">
                                                <dt><a href="">音像</a></dt>
                                                <dd><em><a href="">音乐</a></em><em><a href="">影视</a></em><em><a href="">教育音像</a></em><em><a href="">游戏</a></em></dd>
                                            </dl>
                                            <dl class="fore4">
                                                <dt>文艺</dt>
                                                <dd><em><a href="">小说</a></em><em><a href="">文学</a></em><em><a href="">青春文学</a></em><em><a href="">传记</a></em><em><a href="">艺术</a></em></dd>
                                            </dl>
                                            <dl class="fore5">
                                                <dt>人文社科</dt>
                                                <dd><em><a href="">历史</a></em><em><a href="">心理学</a></em><em><a href="">政治/军事</a></em><em><a href="">国学/古籍</a></em><em><a href="">哲学/宗教</a></em><em><a href="">社会科学</a></em></dd>
                                            </dl>
                                            <dl class="fore6">
                                                <dt>经管励志</dt>
                                                <dd><em><a href="">经济</a></em><em><a href="">金融与投资</a></em><em><a href="">管理</a></em><em><a href="">励志与成功</a></em></dd>
                                            </dl>
                                            <dl class="fore7">
                                                <dt>生活</dt>
                                                <dd><em><a href="">家庭与育儿</a></em><em><a href="">旅游/地图</a></em><em><a href="">烹饪/美食</a></em><em><a href="">时尚/美妆</a></em><em><a href="">家居</a></em><em><a href="">婚恋与两性</a></em><em><a href="">娱乐/休闲</a></em><em><a href="">健身与保健</a></em><em><a href="">动漫/幽默</a></em><em><a href="">体育/运动</a></em></dd>
                                            </dl>
                                            <dl class="fore8">
                                                <dt>科技</dt>
                                                <dd><em><a href="">科普</a></em><em><a href="">IT</a></em><em><a href="">建筑</a></em><em><a href="">医学</a></em><em><a href="">工业技术</a></em><em><a href="">电子/通信</a></em><em><a href="">农林</a></em><em><a href="">科学与自然</a></em></dd>
                                            </dl>
                                            <dl class="fore9">
                                                <dt>少儿</dt>
                                                <dd><em><a href="">少儿</a></em><em><a href="">0-2岁</a></em><em><a href="">3-6岁</a></em><em><a href="">7-10岁</a></em><em><a href="">11-14岁</a></em></dd>
                                            </dl>
                                            <dl class="fore10">
                                                <dt>教育</dt>
                                                <dd><em><a href="">教材教辅</a></em><em><a href="">考试</a></em><em><a href="">外语学习</a></em></dd>
                                            </dl>
                                            <dl class="fore11">
                                                <dt>其它</dt>
                                                <dd><em><a href="">英文原版书</a></em><em><a href="">港台图书</a></em><em><a href="">工具书</a></em><em><a href="">套装书</a></em><em><a href="">杂志/期刊</a></em></dd>
                                            </dl>
                                        </div>
                                    </div>
                                </div>
                                <div class="item">
                                    <h3><a href="">家居、家具、家装、厨具</a></h3>
                                    <div class="item-list clearfix">
                                        <div class="subitem">
                                            <dl class="fore1">
                                                <dt><a href="">电子书4</a></dt>
                                                <dd><em><a href="">免费</a></em><em><a href="">小说</a></em><em><a href="">励志与成功</a></em><em><a href="">婚恋/两性</a></em><em><a href="">文学</a></em><em><a href="">经管</a></em><em><a href="">畅读VIP</a></em></dd>
                                            </dl>
                                            <dl class="fore2">
                                                <dt><a href="">数字音乐</a></dt>
                                                <dd><em><a href="">通俗流行</a></em><em><a href="">古典音乐</a></em><em><a href="">摇滚说唱</a></em><em><a href="">爵士蓝调</a></em><em><a href="">乡村民谣</a></em><em><a href="">有声读物</a></em></dd>
                                            </dl>
                                            <dl class="fore3">
                                                <dt><a href="">音像</a></dt>
                                                <dd><em><a href="">音乐</a></em><em><a href="">影视</a></em><em><a href="">教育音像</a></em><em><a href="">游戏</a></em></dd>
                                            </dl>
                                            <dl class="fore4">
                                                <dt>文艺</dt>
                                                <dd><em><a href="">小说</a></em><em><a href="">文学</a></em><em><a href="">青春文学</a></em><em><a href="">传记</a></em><em><a href="">艺术</a></em></dd>
                                            </dl>
                                            <dl class="fore5">
                                                <dt>人文社科</dt>
                                                <dd><em><a href="">历史</a></em><em><a href="">心理学</a></em><em><a href="">政治/军事</a></em><em><a href="">国学/古籍</a></em><em><a href="">哲学/宗教</a></em><em><a href="">社会科学</a></em></dd>
                                            </dl>
                                            <dl class="fore6">
                                                <dt>经管励志</dt>
                                                <dd><em><a href="">经济</a></em><em><a href="">金融与投资</a></em><em><a href="">管理</a></em><em><a href="">励志与成功</a></em></dd>
                                            </dl>
                                            <dl class="fore7">
                                                <dt>生活</dt>
                                                <dd><em><a href="">家庭与育儿</a></em><em><a href="">旅游/地图</a></em><em><a href="">烹饪/美食</a></em><em><a href="">时尚/美妆</a></em><em><a href="">家居</a></em><em><a href="">婚恋与两性</a></em><em><a href="">娱乐/休闲</a></em><em><a href="">健身与保健</a></em><em><a href="">动漫/幽默</a></em><em><a href="">体育/运动</a></em></dd>
                                            </dl>
                                            <dl class="fore8">
                                                <dt>科技</dt>
                                                <dd><em><a href="">科普</a></em><em><a href="">IT</a></em><em><a href="">建筑</a></em><em><a href="">医学</a></em><em><a href="">工业技术</a></em><em><a href="">电子/通信</a></em><em><a href="">农林</a></em><em><a href="">科学与自然</a></em></dd>
                                            </dl>
                                            <dl class="fore9">
                                                <dt>少儿</dt>
                                                <dd><em><a href="">少儿</a></em><em><a href="">0-2岁</a></em><em><a href="">3-6岁</a></em><em><a href="">7-10岁</a></em><em><a href="">11-14岁</a></em></dd>
                                            </dl>
                                        </div>
                                    </div>
                                </div>
                                <div class="item">
                                    <h3><a href="">服饰内衣</a></h3>
                                    <div class="item-list clearfix">
                                        <div class="subitem">
                                            <dl class="fore1">
                                                <dt><a href="">电子书5</a></dt>
                                                <dd><em><a href="">免费</a></em><em><a href="">小说</a></em><em><a href="">励志与成功</a></em><em><a href="">婚恋/两性</a></em><em><a href="">文学</a></em><em><a href="">经管</a></em><em><a href="">畅读VIP</a></em></dd>
                                            </dl>
                                            <dl class="fore2">
                                                <dt><a href="">数字音乐</a></dt>
                                                <dd><em><a href="">通俗流行</a></em><em><a href="">古典音乐</a></em><em><a href="">摇滚说唱</a></em><em><a href="">爵士蓝调</a></em><em><a href="">乡村民谣</a></em><em><a href="">有声读物</a></em></dd>
                                            </dl>
                                            <dl class="fore3">
                                                <dt><a href="">音像</a></dt>
                                                <dd><em><a href="">音乐</a></em><em><a href="">影视</a></em><em><a href="">教育音像</a></em><em><a href="">游戏</a></em></dd>
                                            </dl>
                                            <dl class="fore4">
                                                <dt>文艺</dt>
                                                <dd><em><a href="">小说</a></em><em><a href="">文学</a></em><em><a href="">青春文学</a></em><em><a href="">传记</a></em><em><a href="">艺术</a></em></dd>
                                            </dl>
                                            <dl class="fore5">
                                                <dt>人文社科</dt>
                                                <dd><em><a href="">历史</a></em><em><a href="">心理学</a></em><em><a href="">政治/军事</a></em><em><a href="">国学/古籍</a></em><em><a href="">哲学/宗教</a></em><em><a href="">社会科学</a></em></dd>
                                            </dl>
                                            <dl class="fore6">
                                                <dt>经管励志</dt>
                                                <dd><em><a href="">经济</a></em><em><a href="">金融与投资</a></em><em><a href="">管理</a></em><em><a href="">励志与成功</a></em></dd>
                                            </dl>
                                            <dl class="fore7">
                                                <dt>生活</dt>
                                                <dd><em><a href="">家庭与育儿</a></em><em><a href="">旅游/地图</a></em><em><a href="">烹饪/美食</a></em><em><a href="">时尚/美妆</a></em><em><a href="">家居</a></em><em><a href="">婚恋与两性</a></em><em><a href="">娱乐/休闲</a></em><em><a href="">健身与保健</a></em><em><a href="">动漫/幽默</a></em><em><a href="">体育/运动</a></em></dd>
                                            </dl>
                                            <dl class="fore8">
                                                <dt>科技</dt>
                                                <dd><em><a href="">科普</a></em><em><a href="">IT</a></em><em><a href="">建筑</a></em><em><a href="">医学</a></em><em><a href="">工业技术</a></em><em><a href="">电子/通信</a></em><em><a href="">农林</a></em><em><a href="">科学与自然</a></em></dd>
                                            </dl>
                                        </div>
                                    </div>
                                </div>
                                <div class="item">
                                    <h3><a href="">个护化妆</a></h3>
                                    <div class="item-list clearfix">
                                        <div class="subitem">
                                            <dl class="fore1">
                                                <dt><a href="">电子书6</a></dt>
                                                <dd><em><a href="">免费</a></em><em><a href="">小说</a></em><em><a href="">励志与成功</a></em><em><a href="">婚恋/两性</a></em><em><a href="">文学</a></em><em><a href="">经管</a></em><em><a href="">畅读VIP</a></em></dd>
                                            </dl>
                                            <dl class="fore2">
                                                <dt><a href="">数字音乐</a></dt>
                                                <dd><em><a href="">通俗流行</a></em><em><a href="">古典音乐</a></em><em><a href="">摇滚说唱</a></em><em><a href="">爵士蓝调</a></em><em><a href="">乡村民谣</a></em><em><a href="">有声读物</a></em></dd>
                                            </dl>
                                            <dl class="fore3">
                                                <dt><a href="">音像</a></dt>
                                                <dd><em><a href="">音乐</a></em><em><a href="">影视</a></em><em><a href="">教育音像</a></em><em><a href="">游戏</a></em></dd>
                                            </dl>
                                            <dl class="fore4">
                                                <dt>文艺</dt>
                                                <dd><em><a href="">小说</a></em><em><a href="">文学</a></em><em><a href="">青春文学</a></em><em><a href="">传记</a></em><em><a href="">艺术</a></em></dd>
                                            </dl>
                                            <dl class="fore5">
                                                <dt>人文社科</dt>
                                                <dd><em><a href="">历史</a></em><em><a href="">心理学</a></em><em><a href="">政治/军事</a></em><em><a href="">国学/古籍</a></em><em><a href="">哲学/宗教</a></em><em><a href="">社会科学</a></em></dd>
                                            </dl>
                                            <dl class="fore6">
                                                <dt>经管励志</dt>
                                                <dd><em><a href="">经济</a></em><em><a href="">金融与投资</a></em><em><a href="">管理</a></em><em><a href="">励志与成功</a></em></dd>
                                            </dl>
                                            <dl class="fore7">
                                                <dt>生活</dt>
                                                <dd><em><a href="">家庭与育儿</a></em><em><a href="">旅游/地图</a></em><em><a href="">烹饪/美食</a></em><em><a href="">时尚/美妆</a></em><em><a href="">家居</a></em><em><a href="">婚恋与两性</a></em><em><a href="">娱乐/休闲</a></em><em><a href="">健身与保健</a></em><em><a href="">动漫/幽默</a></em><em><a href="">体育/运动</a></em></dd>
                                            </dl>
                                            <dl class="fore8">
                                                <dt>科技</dt>
                                                <dd><em><a href="">科普</a></em><em><a href="">IT</a></em><em><a href="">建筑</a></em><em><a href="">医学</a></em><em><a href="">工业技术</a></em><em><a href="">电子/通信</a></em><em><a href="">农林</a></em><em><a href="">科学与自然</a></em></dd>
                                            </dl>
                                            <dl class="fore9">
                                                <dt>少儿</dt>
                                                <dd><em><a href="">少儿</a></em><em><a href="">0-2岁</a></em><em><a href="">3-6岁</a></em><em><a href="">7-10岁</a></em><em><a href="">11-14岁</a></em></dd>
                                            </dl>
                                            <dl class="fore10">
                                                <dt>教育</dt>
                                                <dd><em><a href="">教材教辅</a></em><em><a href="">考试</a></em><em><a href="">外语学习</a></em></dd>
                                            </dl>
                                            <dl class="fore11">
                                                <dt>其它</dt>
                                                <dd><em><a href="">英文原版书</a></em><em><a href="">港台图书</a></em><em><a href="">工具书</a></em><em><a href="">套装书</a></em><em><a href="">杂志/期刊</a></em></dd>
                                            </dl>
                                        </div>
                                    </div>
                                </div>
                                <div class="item">
                                    <h3><a href="">运动健康</a></h3>
                                    <div class="item-list clearfix">
                                        <div class="subitem">
                                            <dl class="fore1">
                                                <dt><a href="">电子书7</a></dt>
                                                <dd><em><a href="">免费</a></em><em><a href="">小说</a></em><em><a href="">励志与成功</a></em><em><a href="">婚恋/两性</a></em><em><a href="">文学</a></em><em><a href="">经管</a></em><em><a href="">畅读VIP</a></em></dd>
                                            </dl>
                                            <dl class="fore2">
                                                <dt><a href="">数字音乐</a></dt>
                                                <dd><em><a href="">通俗流行</a></em><em><a href="">古典音乐</a></em><em><a href="">摇滚说唱</a></em><em><a href="">爵士蓝调</a></em><em><a href="">乡村民谣</a></em><em><a href="">有声读物</a></em></dd>
                                            </dl>
                                            <dl class="fore3">
                                                <dt><a href="">音像</a></dt>
                                                <dd><em><a href="">音乐</a></em><em><a href="">影视</a></em><em><a href="">教育音像</a></em><em><a href="">游戏</a></em></dd>
                                            </dl>
                                            <dl class="fore4">
                                                <dt>文艺</dt>
                                                <dd><em><a href="">小说</a></em><em><a href="">文学</a></em><em><a href="">青春文学</a></em><em><a href="">传记</a></em><em><a href="">艺术</a></em></dd>
                                            </dl>
                                        </div>
                                        <div class="cat-right">
                                            <dl class="categorys-brands" clstag="homepage|keycount|home2013|0601d">
                                                <dt>推荐品牌出版商</dt>
                                                <dd>
                                                    <ul>
                                                        <li>
                                                            <a href="">中华书局</a>
                                                        </li>
                                                        <li>
                                                            <a href="">人民邮电出版社</a>
                                                        </li>
                                                    </ul>
                                                </dd>
                                            </dl>
                                        </div>
                                    </div>
                                </div>
                                <div class="item">
                                    <h3><a href="">汽车用品</a></h3>
                                    <div class="item-list clearfix">
                                        <div class="subitem">
                                            <dl class="fore1">
                                                <dt><a href="">电子书8</a></dt>
                                                <dd><em><a href="">免费</a></em><em><a href="">小说</a></em><em><a href="">励志与成功</a></em><em><a href="">婚恋/两性</a></em><em><a href="">文学</a></em><em><a href="">经管</a></em><em><a href="">畅读VIP</a></em></dd>
                                            </dl>
                                            <dl class="fore2">
                                                <dt><a href="">数字音乐</a></dt>
                                                <dd><em><a href="">通俗流行</a></em><em><a href="">古典音乐</a></em><em><a href="">摇滚说唱</a></em><em><a href="">爵士蓝调</a></em><em><a href="">乡村民谣</a></em><em><a href="">有声读物</a></em></dd>
                                            </dl>
                                            <dl class="fore3">
                                                <dt><a href="">音像</a></dt>
                                                <dd><em><a href="">音乐</a></em><em><a href="">影视</a></em><em><a href="">教育音像</a></em><em><a href="">游戏</a></em></dd>
                                            </dl>
                                            <dl class="fore4">
                                                <dt>文艺</dt>
                                                <dd><em><a href="">小说</a></em><em><a href="">文学</a></em><em><a href="">青春文学</a></em><em><a href="">传记</a></em><em><a href="">艺术</a></em></dd>
                                            </dl>
                                            <dl class="fore5">
                                                <dt>人文社科</dt>
                                                <dd><em><a href="">历史</a></em><em><a href="">心理学</a></em><em><a href="">政治/军事</a></em><em><a href="">国学/古籍</a></em><em><a href="">哲学/宗教</a></em><em><a href="">社会科学</a></em></dd>
                                            </dl>
                                            <dl class="fore6">
                                                <dt>经管励志</dt>
                                                <dd><em><a href="">经济</a></em><em><a href="">金融与投资</a></em><em><a href="">管理</a></em><em><a href="">励志与成功</a></em></dd>
                                            </dl>
                                            <dl class="fore7">
                                                <dt>生活</dt>
                                                <dd><em><a href="">家庭与育儿</a></em><em><a href="">旅游/地图</a></em><em><a href="">烹饪/美食</a></em><em><a href="">时尚/美妆</a></em><em><a href="">家居</a></em><em><a href="">婚恋与两性</a></em><em><a href="">娱乐/休闲</a></em><em><a href="">健身与保健</a></em><em><a href="">动漫/幽默</a></em><em><a href="">体育/运动</a></em></dd>
                                            </dl>
                                            <dl class="fore8">
                                                <dt>科技</dt>
                                                <dd><em><a href="">科普</a></em><em><a href="">IT</a></em><em><a href="">建筑</a></em><em><a href="">医学</a></em><em><a href="">工业技术</a></em><em><a href="">电子/通信</a></em><em><a href="">农林</a></em><em><a href="">科学与自然</a></em></dd>
                                            </dl>
                                        </div>
                                    </div>
                                </div>
                                <div class="item">
                                    <h3><a href="">彩票、旅行</a></h3>
                                </div>
                                <div class="item">
                                    <h3><a href="">理财、众筹</a></h3>
                                </div>
                                <div class="item">
                                    <h3><a href="">母婴、玩具</a></h3>
                                </div>
                                <div class="item">
                                    <h3><a href="">箱包</a></h3>
                                </div>
                                <div class="item">
                                    <h3><a href="">运动户外</a></h3>
                                </div>
                                <div class="item">
                                    <h3><a href="">箱包</a></h3>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="yui3-u Center navArea">
                        <ul class="nav">
                            <li class="f-item">服装城</li>
                            <li class="f-item">美妆馆</li>
                            <li class="f-item">品优超市</li>
                            <li class="f-item">全球购</li>
                            <li class="f-item">闪购</li>
                            <li class="f-item">团购</li>
                            <li class="f-item">有趣</li>
                            <li class="f-item"><a href="seckill-index.html" target="_blank">秒杀</a></li>
                        </ul>
                    </div>
                    <div class="yui3-u Right"></div>
                </div>

            </div>
        </div>
    </div>
</div>


<title>结算页</title>

<link rel="stylesheet" type="text/css" href="/static/home/css/pages-getOrderInfo.css" />

<script type="text/javascript" src="/static/home/js/pages/getOrderInfo.js"></script>

<!--主内容-->
<div class="cart py-container">
	<div class="checkout py-container">
		<div class="checkout-tit">
			<h4 class="tit-txt">填写并核对订单信息</h4>
		</div>
		<div class="checkout-steps">
			<!--收件人信息-->
			<div class="step-tit">
				<h5>收件人信息<span><a data-toggle="modal" data-target=".edit" data-keyboard="false" class="newadd">新增收货地址</a></span></h5>
			</div>
			<div class="step-cont">
				<div class="addressInfo">
					<ul class="addr-detail">
						<?php foreach($address as $v): ?>
						<li class="addr-item">
							<div address_id="<?php echo $v['id']; ?>" class="con name <?php if(($v['is_default'])): ?>selected<?php endif; ?>"><a href="javascript:;" ><em><?php echo $v['consignee']; ?></em><span title="点击取消选择">&nbsp;</span></a></div>
							<div class="con address">
								<span class="consignee_name"><?php echo $v['consignee']; ?></span>
								<span class="consignee_address"><?php echo $v['area']; ?> <?php echo $v['address']; ?></span>
								<span class="consignee_phone"><?php echo $v['phone']; ?></span>
								<span class="base">默认地址</span>
								<span class="edittext">
										<a class="edit_address" data-toggle="modal" data-target=".edit" data-keyboard="false" >编辑</a>&nbsp;&nbsp;
										<a class="delete_address" href="javascript:;">删除</a>
									</span>
							</div>
							<div class="clearfix"></div>
						</li>
						<?php endforeach; ?>
					</ul>
					<!--添加地址-->
					<div  tabindex="-1" role="dialog" data-hasfoot="false" class="sui-modal hide fade edit">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" data-dismiss="modal" aria-hidden="true" class="sui-close">×</button>
									<h4 id="myModalLabel" class="modal-title">添加收货地址</h4>
								</div>
								<div class="modal-body">
									<form action="" class="sui-form form-horizontal">
										<div class="control-group">
											<label class="control-label">收货人：</label>
											<div class="controls">
												<input type="text" class="input-medium">
											</div>
										</div>

										<div class="control-group">
											<label class="control-label">详细地址：</label>
											<div class="controls">
												<input type="text" class="input-large">
											</div>
										</div>
										<div class="control-group">
											<label class="control-label">联系电话：</label>
											<div class="controls">
												<input type="text" class="input-medium">
											</div>
										</div>
										<div class="control-group">
											<label class="control-label">邮箱：</label>
											<div class="controls">
												<input type="text" class="input-medium">
											</div>
										</div>
										<div class="control-group">
											<label class="control-label">地址别名：</label>
											<div class="controls">
												<input type="text" class="input-medium">
											</div>
											<div class="othername">
												建议填写常用地址：<a href="#" class="sui-btn btn-default">家里</a>　<a href="#" class="sui-btn btn-default">父母家</a>　<a href="#" class="sui-btn btn-default">公司</a>
											</div>
										</div>

									</form>


								</div>
								<div class="modal-footer">
									<button type="button" data-ok="modal" class="sui-btn btn-primary btn-large">确定</button>
									<button type="button" data-dismiss="modal" class="sui-btn btn-default btn-large">取消</button>
								</div>
							</div>
						</div>
					</div>
					<!--确认地址-->
				</div>
				<div class="hr"></div>
				<div class="recommendAddr">
					<ul class="addr-detail">
						<li class="addr-item">
							<div class="con name"><a href="javascript:;" class="selected">匹配自提点<span title="点击取消选择">&nbsp;</a></div>
							<div class="con address">时代思远书店 中关村软件园9号楼时代思远书店</div>
						</li>
					</ul>
				</div>
			</div>
			<div class="hr"></div>
			<!--支付和送货-->
			<div class="payshipInfo">
				<!--<div class="step-tit">-->
				<!--<h5>支付方式</h5>-->
				<!--</div>-->
				<!--<div class="step-cont">-->
				<!--<ul class="payType">-->
				<!--<li class="selected" pay_type="alipay">支付宝<span title="点击取消选择"></span></li>-->
				<!--<li pay_type="wechat">微信付款<span title="点击取消选择"></span></li>-->
				<!--<li pay_type="card">银联<span title="点击取消选择"></span></li>-->
				<!--<li pay_type="cash">货到付款<span title="点击取消选择"></span></li>-->
				<!--</ul>-->
				<!--</div>-->
				<div class="hr"></div>
				<div class="step-tit">
					<h5>送货清单</h5>
				</div>
				<div class="step-cont">
					<ul class="send-detail">
						<li>
							<div class="sendType">
								<span>配送方式：</span>
								<ul>
									<li>
										<div class="con express">天天快递</div>
										<div class="con delivery">配送时间：预计8月10日（周三）09:00-15:00送达</div>
									</li>
								</ul>
							</div>
							<div class="sendGoods">
								<span>商品清单：</span>
								<?php foreach($cart_data as $v): ?>
								<ul class="yui3-g">
									<li class="yui3-u-1-6">
										<span><img src="<?php echo $v['goods_logo']; ?>"/></span>
									</li>
									<li class="yui3-u-7-12">
										<div class="desc"><?php echo $v['goods_name']; ?><br><?php echo $v['value_names']; ?></div>
										<div class="seven">7天无理由退货</div>
									</li>
									<li class="yui3-u-1-12">
										<div class="price">￥<?php echo $v['goods_price']; ?></div>
									</li>
									<li class="yui3-u-1-12">
										<div class="num">X<?php echo $v['number']; ?></div>
									</li>
									<li class="yui3-u-1-12">
										<div class="exit"><?php if(($v['goods_number'] >= $v['number'])): ?>有货<?php else: ?>无货<?php endif; ?></div>
									</li>
								</ul>
								<?php endforeach; ?>
							</div>
						</li>
						<li></li>
						<li></li>
					</ul>
				</div>
				<div class="hr"></div>
			</div>
			<div class="linkInfo">
				<div class="step-tit">
					<h5>发票信息</h5>
				</div>
				<div class="step-cont">
					<span>普通发票（电子）</span>
					<span>个人</span>
					<span>明细</span>
				</div>
			</div>
			<div class="cardInfo">
				<div class="step-tit">
					<h5>使用优惠/抵用</h5>
				</div>
			</div>
		</div>
	</div>
	<div class="order-summary">
		<div class="static fr">
			<div class="list">
				<span><i class="number"><?php echo $total_number; ?></i>件商品，总商品金额</span>
				<em class="allprice">¥<?php echo $total_price; ?></em>
			</div>
			<div class="list">
				<span>返现：</span>
				<em class="money">0.00</em>
			</div>
			<div class="list">
				<span>运费：</span>
				<em class="transport">0.00</em>
			</div>
		</div>
	</div>
	<div class="clearfix trade">
		<div class="fc-price">应付金额:　<span class="price">¥<?php echo $total_price; ?></span></div>
		<div class="fc-receiverInfo">寄送至:北京市海淀区三环内 中关村软件园9号楼 收货人：某某某 159****3201</div>
	</div>
	<div class="submit">
		<a class="sui-btn btn-danger btn-xlarge" href="javascript:;">提交订单</a>
	</div>
</div>
<form id="orderForm" action="<?php echo url('home/order/save'); ?>" method="post" style="display: none;">
	<input type="hidden" name="address_id" value="">
</form>
<script>
	$(function(){
		//封装函数 将选中的地址，放到页面右下角展示
		var show_address = function(element){
			//获取到选中的地址信息
			if(element){
				var li = $(element).closest('li');
			}else{
				var li = $('.addressInfo').find('.name.selected').closest('li');
			}
			var consignee_address = li.find('.consignee_address').html();
			var consignee_phone = li.find('.consignee_phone').html();
			var consignee_name = li.find('.consignee_name').html();
			//展示到页面右下角
			$('.fc-receiverInfo').html('寄送至:' + consignee_address +' 收货人：' + consignee_name + ' ' + consignee_phone);
		};
		show_address();

		//点击地址 切换右下角的地址
		$('.addressInfo').find('.name').click(function(){
			show_address(this);
		});

		//提交订单
		$('.submit').click(function(){
			//获取选中的收货地址id
			var address_id = $('.addressInfo').find('.name.selected').attr('address_id');
			//将地址id放到表单中
			$('input[name=address_id]').val(address_id);
			//提交表单
			$('#orderForm').submit();
		});
	});
</script>
	

<!-- 底部栏位 -->
<!--页面底部-->
<div class="clearfix footer">
    <div class="py-container">
        <div class="footlink">
            <div class="Mod-service">
                <ul class="Mod-Service-list">
                    <li class="grid-service-item intro  intro1">

                        <i class="serivce-item fl"></i>
                        <div class="service-text">
                            <h4>正品保障</h4>
                            <p>正品保障，提供发票</p>
                        </div>

                    </li>
                    <li class="grid-service-item  intro intro2">

                        <i class="serivce-item fl"></i>
                        <div class="service-text">
                            <h4>正品保障</h4>
                            <p>正品保障，提供发票</p>
                        </div>

                    </li>
                    <li class="grid-service-item intro  intro3">

                        <i class="serivce-item fl"></i>
                        <div class="service-text">
                            <h4>正品保障</h4>
                            <p>正品保障，提供发票</p>
                        </div>

                    </li>
                    <li class="grid-service-item  intro intro4">

                        <i class="serivce-item fl"></i>
                        <div class="service-text">
                            <h4>正品保障</h4>
                            <p>正品保障，提供发票</p>
                        </div>

                    </li>
                    <li class="grid-service-item intro intro5">

                        <i class="serivce-item fl"></i>
                        <div class="service-text">
                            <h4>正品保障</h4>
                            <p>正品保障，提供发票</p>
                        </div>

                    </li>
                </ul>
            </div>
            <div class="clearfix Mod-list">
                <div class="yui3-g">
                    <div class="yui3-u-1-6">
                        <h4>购物指南</h4>
                        <ul class="unstyled">
                            <li>购物流程</li>
                            <li>会员介绍</li>
                            <li>生活旅行/团购</li>
                            <li>常见问题</li>
                            <li>购物指南</li>
                        </ul>

                    </div>
                    <div class="yui3-u-1-6">
                        <h4>配送方式</h4>
                        <ul class="unstyled">
                            <li>上门自提</li>
                            <li>211限时达</li>
                            <li>配送服务查询</li>
                            <li>配送费收取标准</li>
                            <li>海外配送</li>
                        </ul>
                    </div>
                    <div class="yui3-u-1-6">
                        <h4>支付方式</h4>
                        <ul class="unstyled">
                            <li>货到付款</li>
                            <li>在线支付</li>
                            <li>分期付款</li>
                            <li>邮局汇款</li>
                            <li>公司转账</li>
                        </ul>
                    </div>
                    <div class="yui3-u-1-6">
                        <h4>售后服务</h4>
                        <ul class="unstyled">
                            <li>售后政策</li>
                            <li>价格保护</li>
                            <li>退款说明</li>
                            <li>返修/退换货</li>
                            <li>取消订单</li>
                        </ul>
                    </div>
                    <div class="yui3-u-1-6">
                        <h4>特色服务</h4>
                        <ul class="unstyled">
                            <li>夺宝岛</li>
                            <li>DIY装机</li>
                            <li>延保服务</li>
                            <li>品优购E卡</li>
                            <li>品优购通信</li>
                        </ul>
                    </div>
                    <div class="yui3-u-1-6">
                        <h4>帮助中心</h4>
                        <img src="/static/home/img/wx_cz.jpg">
                    </div>
                </div>
            </div>
            <div class="Mod-copyright">
                <ul class="helpLink">
                    <li>关于我们<span class="space"></span></li>
                    <li>联系我们<span class="space"></span></li>
                    <li>关于我们<span class="space"></span></li>
                    <li>商家入驻<span class="space"></span></li>
                    <li>营销中心<span class="space"></span></li>
                    <li>友情链接<span class="space"></span></li>
                    <li>关于我们<span class="space"></span></li>
                    <li>营销中心<span class="space"></span></li>
                    <li>友情链接<span class="space"></span></li>
                    <li>关于我们</li>
                </ul>
                <p>地址：北京市昌平区建材城西路金燕龙办公楼一层 邮编：100096 电话：400-618-4000 传真：010-82935100</p>
                <p>京ICP备08001421号京公网安备110108007702</p>
            </div>
        </div>
    </div>
</div>
<!--页面底部END-->
<!--侧栏面板开始-->
<div class="J-global-toolbar">
    <div class="toolbar-wrap J-wrap">
        <div class="toolbar">
            <div class="toolbar-panels J-panel">

                <!-- 购物车 -->
                <div style="visibility: hidden;" class="J-content toolbar-panel tbar-panel-cart toolbar-animate-out">
                    <h3 class="tbar-panel-header J-panel-header">
                        <a href="" class="title"><i></i><em class="title">购物车</em></a>
                        <span class="close-panel J-close" onclick="cartPanelView.tbar_panel_close('cart');" ></span>
                    </h3>
                    <div class="tbar-panel-main">
                        <div class="tbar-panel-content J-panel-content">
                            <div id="J-cart-tips" class="tbar-tipbox hide">
                                <div class="tip-inner">
                                    <span class="tip-text">还没有登录，登录后商品将被保存</span>
                                    <a href="#none" class="tip-btn J-login">登录</a>
                                </div>
                            </div>
                            <div id="J-cart-render">
                                <!-- 列表 -->
                                <div id="cart-list" class="tbar-cart-list">
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- 小计 -->
                    <div id="cart-footer" class="tbar-panel-footer J-panel-footer">
                        <div class="tbar-checkout">
                            <div class="jtc-number"> <strong class="J-count" id="cart-number">0</strong>件商品 </div>
                            <div class="jtc-sum"> 共计：<strong class="J-total" id="cart-sum">¥0</strong> </div>
                            <a class="jtc-btn J-btn" href="#none" target="_blank">去购物车结算</a>
                        </div>
                    </div>
                </div>

                <!-- 我的关注 -->
                <div style="visibility: hidden;" data-name="follow" class="J-content toolbar-panel tbar-panel-follow">
                    <h3 class="tbar-panel-header J-panel-header">
                        <a href="#" target="_blank" class="title"> <i></i> <em class="title">我的关注</em> </a>
                        <span class="close-panel J-close" onclick="cartPanelView.tbar_panel_close('follow');"></span>
                    </h3>
                    <div class="tbar-panel-main">
                        <div class="tbar-panel-content J-panel-content">
                            <div class="tbar-tipbox2">
                                <div class="tip-inner"> <i class="i-loading"></i> </div>
                            </div>
                        </div>
                    </div>
                    <div class="tbar-panel-footer J-panel-footer"></div>
                </div>

                <!-- 我的足迹 -->
                <div style="visibility: hidden;" class="J-content toolbar-panel tbar-panel-history toolbar-animate-in">
                    <h3 class="tbar-panel-header J-panel-header">
                        <a href="#" target="_blank" class="title"> <i></i> <em class="title">我的足迹</em> </a>
                        <span class="close-panel J-close" onclick="cartPanelView.tbar_panel_close('history');"></span>
                    </h3>
                    <div class="tbar-panel-main">
                        <div class="tbar-panel-content J-panel-content">
                            <div class="jt-history-wrap">
                                <ul>
                                    <!--<li class="jth-item">
                                        <a href="#" class="img-wrap"> <img src="../../.../portal/img/like_03.png" height="100" width="100" /> </a>
                                        <a class="add-cart-button" href="#" target="_blank">加入购物车</a>
                                        <a href="#" target="_blank" class="price">￥498.00</a>
                                    </li>
                                    <li class="jth-item">
                                        <a href="#" class="img-wrap"> <img src="../../../portal/img/like_02.png" height="100" width="100" /></a>
                                        <a class="add-cart-button" href="#" target="_blank">加入购物车</a>
                                        <a href="#" target="_blank" class="price">￥498.00</a>
                                    </li>-->
                                </ul>
                                <a href="#" class="history-bottom-more" target="_blank">查看更多足迹商品 &gt;&gt;</a>
                            </div>
                        </div>
                    </div>
                    <div class="tbar-panel-footer J-panel-footer"></div>
                </div>

            </div>

            <div class="toolbar-header"></div>

            <!-- 侧栏按钮 -->
            <div class="toolbar-tabs J-tab">
                <div onclick="cartPanelView.tabItemClick('cart')" class="toolbar-tab tbar-tab-cart" data="购物车" tag="cart" >
                    <i class="tab-ico"></i>
                    <em class="tab-text"></em>
                    <span class="tab-sub J-count " id="tab-sub-cart-count">0</span>
                </div>
                <div onclick="cartPanelView.tabItemClick('follow')" class="toolbar-tab tbar-tab-follow" data="我的关注" tag="follow" >
                    <i class="tab-ico"></i>
                    <em class="tab-text"></em>
                    <span class="tab-sub J-count hide">0</span>
                </div>
                <div onclick="cartPanelView.tabItemClick('history')" class="toolbar-tab tbar-tab-history" data="我的足迹" tag="history" >
                    <i class="tab-ico"></i>
                    <em class="tab-text"></em>
                    <span class="tab-sub J-count hide">0</span>
                </div>
            </div>

            <div class="toolbar-footer">
                <div class="toolbar-tab tbar-tab-top" > <a href="#"> <i class="tab-ico  "></i> <em class="footer-tab-text">顶部</em> </a> </div>
                <div class="toolbar-tab tbar-tab-feedback" > <a href="#" target="_blank"> <i class="tab-ico"></i> <em class="footer-tab-text ">反馈</em> </a> </div>
            </div>

            <div class="toolbar-mini"></div>

        </div>

        <div id="J-toolbar-load-hook"></div>

    </div>
</div>
<!--购物车单元格 模板-->
<script type="text/template" id="tbar-cart-item-template">
    <div class="tbar-cart-item" >
        <div class="jtc-item-promo">
            <em class="promo-tag promo-mz">满赠<i class="arrow"></i></em>
            <div class="promo-text">已购满600元，您可领赠品</div>
        </div>
        <div class="jtc-item-goods">
            <span class="p-img"><a href="#" target="_blank"><img src="{2}" alt="{1}" height="50" width="50" /></a></span>
            <div class="p-name">
                <a href="#">{1}</a>
            </div>
            <div class="p-price"><strong>¥{3}</strong>×{4} </div>
            <a href="#none" class="p-del J-del">删除</a>
        </div>
    </div>
</script>
<!--侧栏面板结束-->

</body>

</html>