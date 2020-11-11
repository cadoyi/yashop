<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>
<?php 
/**
 * catalog/product/search
 *
 * @var  $this yii\web\View
 */
?>
<section class="row flex-nowrap justify-content-center align-items-center search">
    <form class="child-rounded-0" method="get">
         <div class="form-row">
            <div class="col-auto input-col p-0 ">
                <input class="form-control" 
                       type="search" 
                       name="q"
                       placeholder="请输入您要搜索的产品名" 
                />
            </div>
            <div class="d-flex flex-nowrap col p-0">
                <button class="btn btn-seagreen">搜全站</button>
                <button class="btn btn-molv">搜本店</button>
            </div>            
         </div>
         <div class="form-row keywords">
             <a href="#">马桶</a>
             <a href="#">抽水马桶</a>
             <a href="#">老年马桶</a>
             <a href="#">儿童马桶</a>
             <a href="#">家庭洁具</a>
         </div>
    </form>
</section>