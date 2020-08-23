<?php

namespace catalogsearch\models\filters;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use catalog\models\Product;


/**
 * 搜索过滤器
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class ProductFilter extends Model
{

    public $q;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
           [['q'], 'required'],
           [['q'], 'string', 'max' => 64],
        ];
    }



    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'q' => '搜索',
        ];
    }



    /**
     * @inheritdoc
     */
    public function formName()
    {
        return 'search';
    }



    /**
     * 搜索
     * 
     * @param  array $params   查询参数
     * @param  string $formName 表单名称
     * @return dataProvider
     */
    public function search( $params, $formName = null )
    {
        $query = Product::find()->andWhere(['on_sale' => "1"]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);
        if($this->load($params, $formName) && $this->validate()) {
            $query->andWhere(['like', 'title', $this->q]);
        }
        return $dataProvider;
    }

}