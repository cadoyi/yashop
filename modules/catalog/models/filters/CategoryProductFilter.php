<?php

namespace catalog\models\filters;

use Yii;
use cando\db\ActiveFilter;
use catalog\models\Category;
use catalog\models\Product;

/**
 * 分类产品搜索
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class CategoryProductFilter extends ActiveFilter
{

    public $modelClass = Product::class;

    public $category;


    /**
     * 获取分类和子分类的 ID 值
     * 
     * @return array
     */
    public function getCategoryIds()
    {
        $path = $this->category->path;
        $where = ['like', 'path', $path . '/%', false];
        $ids = Category::find()
            ->select('id')
            ->tableCache()
            ->andWhere($where)
            ->column();
        array_unshift($ids, (string) $this->category->id);
        return $ids;
    }



    /**
     * @inheritdoc
     */
    public function query()
    {
        $ids = $this->getCategoryIds();
        return parent::query()
            ->andWhere(['is_deleted' => 0])
            ->andWhere(['status' => "1"])
            ->andWhere(['category_id' => $ids ]);
    }



    /**
     * @inheritdoc
     */
    public function dataProviderConfig( $query )
    {
        return [
            'pagination' => [
                'pageSize' => 20,
            ],
        ];
    }

}