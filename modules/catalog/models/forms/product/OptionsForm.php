<?php

namespace catalog\models\forms\product;

use Yii;
use yii\helpers\Json;
use yii\base\Component;
use catalog\models\ProductOption;

/**
 * 选项表单
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class OptionsForm extends Component
{

    public $product;


    protected $_options = [];

    protected $_isLoaded = false;


    /**
     * 表单名称
     * 
     * @return string
     */
    public function formName()
    {
        return 'options';
    }


    /**
     * 加载表单
     * 
     * @param  array $data      数据.
     * @param  string $formName 表单名
     * @return boolean
     */
    public function load($data)
    {
        /*
        if(!$this->product->is_selectable) {
            return true;
        } */
        if(!isset($data[$this->formName()])) {
            return false;
        }
        $this->_isLoaded = true;
        $this->_options = $data[$this->formName()];
        return true;
    }


    
    /**
     * 验证
     * 
     * @return boolean
     */
    public function validate()
    {
        /*
        if(!$this->product->is_selectable) {
            return true;
        } */
        $names = [];
        foreach($this->_options as $option) {
            if(empty($option['name'])) {
                $this->product->addError('is_selectable', '选项名不能为空');
                return false;
            }
            if(empty($option['values'])) {
                $this->product->addError('is_selectable', '选项值不能为空');
                return false;
            }
            $name = $option['name'];
            if(isset($names[$name])) {
                $this->product->addError('is_selectable', '选项名称重复');
                return false;
            }
            $names[$name] = true;
        }
        return true;
    }



    public function getErrors()
    {
        return $this->product->getErrors('is_selectable');
    }




    /**
     * 获取 json 数据.
     * 
     * @return string
     */
    public function getJson()
    {
        if(!$this->_isLoaded) {
            $options = $this->product->options;
            $data = [];
            foreach($options as $option) {
                $data[] = $option->attributes;
            }
            return Json::encode($data);
        }
        return Json::encode($this->_options);
    }



    /**
     * 保存
     * 
     * @return boolean
     */
    public function save()
    {
        /*
        if(!$this->product->is_selectable) {
            foreach($this->product->options as $option) {
                $option->delete();
            }
            return true;
        }  */
        $options = [];
        foreach($this->_options as $optionData) {
            $id = $optionData['id'];
            if(isset($this->product->options[$id])) {
                $options[] = $option = $this->product->options[$id];
            } else {
                $options[] = $option = new ProductOption(['product' => $this->product]);
            }
            $option->load($optionData, '');
            $result = $option->save();
            if($result === false) {
                throw new \Exception('Product option save failed');
            }
        }
        foreach($this->product->options as $option) {
            if(!in_array($option, $options, true)) {
                $option->delete();
            }
        }
        $this->product->populateRelation('options', $options);
        return true;
    }



     



}