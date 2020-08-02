<?php


namespace catalog\backend\vms\product;

use Yii;
use yii\helpers\Json;
use cando\web\ViewModel;
use catalog\models\Category;
use catalog\models\Type;

/**
 * 选择产品分类
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class SelectCategory extends ViewModel
{

    public $category_id;

    public $type_id;

    protected $_category;
    protected $_type;



    /**
     * 获取分类。
     */
    public function getCategory()
    {
        if($this->_category) {
            return $this->_category;
        }
        if($this->category_id) {
            $this->_category = Yii::$app->controller->findModel($this->category_id, Category::class, true);
            return $this->_category;
        }
        if($this->getType()) {
            $this->_category = $this->getType()->category;
        }
        return $this->_category;
    }



    /**
     * 获取产品类型。
     */
    public function getType()
    {
        if(!$this->_type) {
            $this->_type = Yii::$app->controller->findModel($this->type_id, Type::class, false);
        }
        return $this->_type;
    }




    /**
     * 获取分类和 type 的数组
     * 
     * @return array
     */
    public function getCategoriesTypes()
    {
        $types = Type::find()
            ->select(['id', 'name', 'category_id'])
            ->tableCache()
            ->asArray()
            ->all();
        $data = [];
        foreach($types as $type) {
            $id = $type['id'];
            $categoryId = $type['category_id'];
            $data[$categoryId][$id] = $type['name'];
        }
        return $data;
    }


}