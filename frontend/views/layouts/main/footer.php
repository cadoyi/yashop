<?php 
use yii\helpers\Html;
use yii\helpers\Url;
?>
<?php 
/**
 * 网站底部
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
?>
<footer class="footer">
    <div class="row service-bar">
        <div class="col">
            <div>
                <div><i class="fa fa-heartbeat"></i></div>
            </div>
            <div title>
                <div>设计匠心</div>
            </div>
            <div>
                <div>秉承工匠精神，专注使用体验</div>
            </div>
        </div>
        <div class="col">
            <div>
                <div><i class="fa fa-internet-explorer"></i></div>
            </div>
            <div title>
                <div>技术放心</div>
            </div>
            <div>
                <div>技术精华积累，系统稳定放心</div>
            </div>
        </div>
        <div class="col">
            <div>
                <div><i class="fa fa-ra"></i></div>
            </div>
            <div title>
                <div>服务用心</div>
            </div>
            <div>
                <div>专业售后服务，助力客户成功</div>
            </div>
        </div>
    </div>
    <div class="row link-bar">
        <div class="col">
            <div title>联系我们</div>
            <ul>
                <li><a href="#">联系我们</a></li>
                <li><a href="#">关于我们</a></li>
                <li><a href="#">营销中心</a></li>
                <li><a href="#">销售联盟</a></li>
            </ul>
        </div>
        <div class="col">
             <div title>快速入口</div>
            <ul>
                <li><a href="#">卖家中心</a></li>
                <li><a href="#">登录注册</a></li>
                <li><a href="#">个人中心</a></li>
                <li><a href="#">我的订单</a></li>
            </ul>
        </div>
        <div class="col">
             <div title>帮助中心</div>
            <ul>
                <li><a href="<?= Url::to(['/issue/issue/index'])?>">常见问题</a></li>
                <li><a href="#">购物指南</a></li>
                <li><a href="#">配送问题</a></li>
                <li><a href="#">其他问题</a></li>
            </ul>
        </div>
        <div class="col">
             <div title>售后服务</div>
            <ul>
                <li><a href="#">售后政策</a></li>
                <li><a href="#">价格保护</a></li>
                <li><a href="#">退款说明</a></li>
                <li><a href="#">争议解决</a></li>
            </ul>
        </div>
    </div>
    <div class="row bottom-bar d-flex justify-content-center">
        <span class="mr-1">&copy; 2016-<?= date('Y') ?> <?= 'yashop开发者' ?> 版权所有</span>
        <a class="text-dark" href="#">京ICP备 123423112</a>
    </div>
</footer>