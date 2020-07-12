<?php

namespace customer\models\filters;

use Yii;
use cando\db\ActiveFilter;
use customer\models\Customer;
use customer\models\types\Phone;
use customer\models\types\Email;

/**
 * 客户过滤
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class CustomerFilter extends ActiveFilter
{

    public $modelClass = Customer::class;

    public $phone;

    public $email;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
           [['phone', 'email'], 'string'],
        ]);
    }



    /**
     * @inheritdoc
     */
    public function query()
    {
        return parent::query()->with('typePhone', 'typeEmail');
    }


    /**
     * @inheritdoc
     */
    protected function _search( $query )
    {
        $query->andFilterWhere([
            'and',
            ['like', 'nickname', $this->nickname ],
        ]);
        if(!empty($this->phone)) {
            $phoneQuery = Phone::find()
                ->select(['customer_id'])
                ->andWhere(['like', 'username', $this->phone]);
           $query->andWhere(['in', 'id', $phoneQuery]);
        }
        if(!empty($this->email)) {
            $emailQuery = Email::find()
                ->select(['customer_id'])
                ->andWhere(['like', 'username', $this->email]);
            $query->andWhere(['in', 'id', $emailQuery]);
        }

    }
    

}