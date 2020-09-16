<?php

namespace sales\models\db;

use Yii;
use yii\behaviors\TimestampBehavior;


/**
 * active record 基类
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
abstract class ActiveRecord extends \cando\db\ActiveRecord
{

   
     /**
      * @inheritdoc
      */
     public function behaviors()
     {
          return array_merge(parent::behaviors(), [
              'timestamp' => [
                  'class' => TimestampBehavior::class,
              ],
          ]); 
     }




     /**
      * @inheritdoc
      */
     public function save($runValidation = true, $attributeNames = null)
     {
         $result = parent::save($runValidation, $attributeNames);
         if(!$result) {
             throw new \Exception('Order save failed');
         }
         return $result;
     }

}