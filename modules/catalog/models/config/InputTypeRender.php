<?php

namespace catalog\models\config;

use Yii;
use yii\base\Component;

/**
 * 渲染器。
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class InputTypeRender extends Component
{

    /**
     * @var InputTypeConfig
     */
    public $config;


    /**
     * @var CategoryAttribute
     */
    protected $_attribute;


    /**
     * @var yii\widgets\ActiveForm
     */
    protected $_form;


    /**
     * 渲染指定的 input
     * 
     * @param  ActiveForm $form 
     * @param  CategoryAttribute $attribute 
     * @param  catalog\models\forms\product\CategoryAttributeForm
     * @param  string $name  模型的属性
     * @return string
     */
    public function render($form, $attribute, $model, $name)
    {
        $this->_attribute = $attribute;
        $this->_form = $form;
        $inputType = $this->config->type;
        switch($inputType) {
            case "text":
            case "password":
            case "boolean":
            case "textarea":
            case "select":
            case "multiselect":
            case "radio":
            case "radiolist":
            case "checkbox":
            case "checkboxlist":
               $method = 'render' . ucfirst($inputType);
               return $this->$method($model, $name);
               break;
            default:
               throw new \Exception('Unknown render in type : ' . $inputType);
        }
    }



    /**
     * 获取 input 选项.
     * 
     * @return array
     */
    public function getInputOptions()
    {
        return $this->config->getRenderInputOptions();
    }


    
    /**
     * 获取 items
     * 
     * @return array
     */
    public function getItems()
    {
        return $this->_attribute->items;
    }
 


    /**
     * 渲染 boolean 框
     * 
     * @param  Model  $model 
     * @param  string $name  
     * @return string
     */
    public function renderBoolean($model, $name)
    {
         $items = $this->_attribute->items;
         $options = $this->getInputOptions();
         $options['prompt'] = Yii::t('app', 'Please select');
         if(empty($items)) {
             $items = ['是' => '是', '否' => '否'];
         }
         return $this->_form->field($model, $name)->dropDownList($items, $options);
    }




    /**
     * 渲染单选列表
     * 
     * @param  Model  $model 
     * @param  string $name  
     * @return string
     */
    public function renderRadioList($model, $name)
    {
        $items = $this->getItems();
        $options = $this->getInputOptions();
        return $this->_form->field($model, $name)->radioList($items, $options);
    }



    /**
     * 渲染多选列表
     * 
     * @param  Model  $model 
     * @param  string $name  
     * @return string
     */
    public function renderCheckboxList($model, $name)
    {
        $items = $this->getItems();
        $options = $this->getInputOptions();
        return $this->_form->field($model, $name)->checkboxList($items, $options);
    }



    /**
     * 渲染多选框
     * 
     * @param  ActiveForm $form 
     * @param  Model  $model 
     * @param  string $name  
     * @return string
     */
    public function renderCheckbox($model, $name)
    {
        $options = $this->getInputOptions();
        $options['value'] = '是';
        $options['uncheck'] = '否';
        return $this->_form->field($model, $name)->checkbox($options);
    }



    /**
     * 渲染单选框
     * 
     * @param  ActiveForm $form 
     * @param  Model  $model 
     * @param  string $name  
     * @return string
     */
    public function renderRadio($model, $name)
    {
        $options = $this->getInputOptions();
        $options['value'] = '是';
        $options['uncheck'] = '否';
        return $this->_form->field($model, $name)->radio($options);
    }



    /**
     * 渲染 select 框。
     * 
     * @param  [type] $form  [description]
     * @param  [type] $model [description]
     * @param  [type] $name  [description]
     * @return [type]        [description]
     */
    public function renderSelect($model, $name)
    {
        $options = $this->getInputOptions();
        if(isset($options['multiple']) && $options['multiple']) {
            return $this->renderMultiselect($form, $model, $name);
        }
        $options['prompt'] = Yii::t('app', 'Please select');
        $items = $this->getItems();
        return $this->_form->field($model, $name)->dropDownList($items, $options);
    }



  
    /**
     * 渲染多选框
     * 
     * @param  [type] $form  [description]
     * @param  [type] $model [description]
     * @param  [type] $name  [description]
     * @return [type]        [description]
     */
    public function renderMultiselect($model, $name)
    {
        $options = $this->getInputOptions();
        $options['multiple'] = true;
        $items = $this->getItems();
        return $this->_form->field($model, $name)->dropDownList($items, $options);
    }
   

    /**
     * 渲染 password 字段。
     * 
     * 
     * @param  ActiveForm $form 
     * @param  Model  $model 
     * @param  string $name  
     * @return string
     */
    public function renderPassword($model, $name)
    {
        return $this->_form->field($model, $name)->passwordInput($this->getInputOptions());
    }




    /**
     * 渲染 textarea
     * 
     * @param  ActiveForm $form 
     * @param  Model  $model 
     * @param  string $name  
     * @return string
     */
    public function renderTextarea($model, $name)
    {
        return $this->_form->field($model, $name)->textarea($this->getInputOptions());
    }



    /**
     * 渲染文本框
     * 
     * @param  ActiveForm $form 
     * @param  Model  $model 
     * @param  string $name  
     * @return string
     */
    public function renderText($model, $name)
    {
        $options = $this->getInputOptions();
        return $this->_form->field($model, $name)->textInput($this->getInputOptions());
    }




}