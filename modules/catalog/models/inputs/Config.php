<?php

namespace catalog\models\inputs;

use Yii;

/**
 * input 配置
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class Config extends \yii\base\Component
{

    public static $config = null;



    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        if(is_null(static::$config)) {
            static::$config = Yii::$app->config->getParamConfig('catalog/type/input_type');
        }
    }


    
    /**
     * 获取 input_type 配置.
     * 
     * @return ParamConfigLoader
     */
    public function getConfig()
    {
        return static::$config;
    }




    /**
     * 获取 hash 选项.
     * 
     * @return array
     */
    public function getHashOptions()
    {
        $options = [];
        foreach($this->getConfig()->getData() as $type => $typeConfig) {
            $label = isset($typeConfig['label']) ? $typeConfig['label'] : $type;
            $options[$type] = Yii::t('app', $label);
        }
        return $options;
    }



    /**
     * 获取类型配置.
     * 
     * @param  string $inputType  输入类型
     * @return array
     */
    public function getTypeConfig($inputType)
    {
        $datas = $this->getConfig()->getData();
        $data = $datas[$inputType];
        $data['type'] = $inputType;
        return new TypeConfig($data, [
            'parent' => $this,
        ]);
    }



}