<?php

namespace catalog\models;

use Yii;
use yii\base\Component;
use yii\base\StaticInstanceTrait;
use yii\base\InvalidParamException;
use catalog\models\inputs\ConfigData;
use catalog\models\inputs\InputTypeConfigData;

/**
 * type attribute 配置.
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class TypeAttributeConfig extends Component
{
    use StaticInstanceTrait;

    protected $_config;


    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->_config = Yii::$app->config->getTypeAttributeConfig([
            'type' => 'param',
            'key'  => 'catalog.type.input_type',
            'loader' => [
                 'dataClass' => ConfigData::class,
            ],
        ]);
    }



    /**
     * 获取输入类型的 hash 选项
     * 
     * @return array
     */
    public function hashOptions()
    {
        $options = [];
        foreach($this->_config->getTypes() as $inputType => $inputTypeConfig) {
            $inputConfig = InputTypeConfigData::loadData($inputTypeConfig, [
                'name' => $inputType,
            ]);
            $options[$inputConfig->name] = $inputConfig->trans('label');
        }
        return $options;
    }



    /**
     * 获取指定输入类型的配置.
     * 
     * @return InputTypeConfigData
     */
    public function getInputTypeConfig($inputType, $typeAttribute)
    {
        $types = $this->_config->getTypes();
        if(!array_key_exists($inputType, $types)) {
            throw new InvalidParamException('input_type ' . $inputType . ' unknown');
        }
        $options = $this->_config->get($inputType);
        $data = ['name' => $inputType];
        $config = InputTypeConfigData::loadData($options, $data);
        $config->set('typeAttribute', $typeAttribute);
        return $config;
    }


}