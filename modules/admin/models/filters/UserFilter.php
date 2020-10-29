<?php

namespace admin\models\filters;

use Yii;
use cando\db\ActiveFilter;
use admin\models\User;

/**
 * 过滤用户
 * 
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class UserFilter extends ActiveFilter
{

    public $modelClass = User::class;



    public function dataProviderConfig( $query )
    {
        return [
            'pagination' => [
                'pageSizeParam' => 'limit',
            ],
        ];
    }

    
       /**
     * @inheritdoc
     */
    protected function _search($query)
    {
        $query->andFilterWhere([
            'and',
            ['id' => $this->id],
            ['like', 'username', $this->username],
            ['like', 'nickname', $this->nickname],
            ['is_active' => $this->is_active],            
        ]);
    }



    /**
     * @inheritdoc
     */
    public function formName()
    {
        return 'uf';
    }




}