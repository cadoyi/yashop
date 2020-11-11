<?php

namespace frontend\vms\site;

use Yii;
use catalog\models\filters\ProductFilter;

/**
 * 首页的视图helper
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class Index extends \cando\web\ViewModel
{

    /**
     * 过滤产品。
     * 
     * @param  array  $filter 搜索条件
     * @param  integer $limit  限制条数
     * @return yii\data\ActiveDataProvider
     */
    protected function products($filter, $limit = 20)
    {
        $filterModel = new ProductFilter();
        $dataProvider = $filterModel->search($filter, '');
        if(!is_null($limit)) {
            $dataProvider->query->limit($limit);
        }
        return $dataProvider;     
    }



    /**
     * 精品推荐
     * 
     * @return array
     */
    public function bestProducts($limit = 20)
    {
        $dataProvider = $this->products(['is_best' => "1"], $limit);
        return $dataProvider->getModels();
    }



    /**
     * 热销单品
     * 
     * @return array
     */
    public function hotProducts($limit = 20)
    {
        $dataProvider = $this->products(['is_hot' => "1"], $limit);
        return $dataProvider->getModels();
    }



    /**
     * 新品推荐
     * 
     * @param  integer $limit 
     * @return array
     */
    public function newProducts($limit = 20)
    {
        $dataProvider = $this->products(['is_new' => "1"], $limit);
        return $dataProvider->getModels();
    }








}