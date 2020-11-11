<?php

namespace catalog\models\config;

use Yii;
use yii\base\Component;

/**
 * 分类属性配置.
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class CategoryAttributeConfig extends Component
{

    protected static $_config = null;

    protected $_types;

    public $categoryAttribute;
    


    /**
     * 获取配置对象.
     * 
     * @return CategoryAttributeConfigData
     */
    public function getConfig()
    {
        if(is_null(static::$_config)) {
            static::$_config = Yii::$app->config->getCatalogCategoryInputType([
                'type'     => 'file',
                'filename' => 'catalog/category',
            ]);
        }
        return static::$_config;
    }



    /**
     * 获取输入类型,并将输入类型实例化.
     * 
     * @return array
     */
    public function getInputTypes()
    {
        if(is_null($this->_types)) {
            $this->_types = [];
            $inputTypes = $this->config->getNode('input_type', []);
            foreach($inputTypes as $name => $inputTypeConfig) {
                $config = InputTypeConfig::loadData($inputTypeConfig, ['name' => $name]);
                $this->_types[$name] = $config;
            }            
        } 
        return $this->_types;
    }



    /**
     * 获取输入类型的 hash 选项.
     * 
     * @return array
     */
    public function getInputTypeHashOptions()
    {
         $options = [];
         foreach($this->inputTypes as $name => $config) {
            $options[$name] = $config->label;
         }
         return $options;
    }



    /**
     * 当选择输入类型的时候的选项. 传递给 dropdownList 的 第二个参数的 options 参数.
     * 
     * @return array
     */
    public function getInputTypeDropdownOptions()
    {
        $options = [];
        foreach($this->inputTypes as $name => $config) {
            $options[$name] = [
                'it-required' => $config->requireItems() ? 1 : 0,
                'it-hint'     => $config->hint,
            ];
        }
        return $options;
    }








}