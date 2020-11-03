<?php

namespace catalog\models\inputs\renders;

use Yii;
use yii\base\Component;

/**
 * 渲染器。
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class Render extends Component
{

    public $typeConfig;



    /**
     * 获取 type_attribute
     * 
     * @return TypeAttribute
     */
    public function getTypeAttribute()
    {
        return $this->typeConfig->typeAttribute;
    }



    /**
     * 渲染指定的 input
     * 
     * @param  ActiveForm $form 
     * @param  yii\base\Model $model 
     * @param  string $name  模型的属性
     * @return string
     */
    public function render($form, $model, $name)
    {
        $inputType = strtolower($this->typeConfig->getType());
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
               return $this->$method($form, $model, $name);
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
        return $this->typeConfig->getOptions();
    }
 


    /**
     * 渲染 boolean 框
     * 
     * @param  ActiveForm $form 
     * @param  Model  $model 
     * @param  string $name  
     * @return string
     */
    public function renderBoolean($form, $model, $name)
    {
         $items = $this->typeConfig->getItems();
         $options = $this->getInputOptions();
         $options['prompt'] = Yii::t('app', 'Please select');
         if(empty($items)) {
             $items = ['是' => '是', '否' => '否'];
         }
         return $form->field($model, $name)->dropDownList($items, $options);
    }




    /**
     * 渲染单选列表
     * 
     * @param  ActiveForm $form 
     * @param  Model  $model 
     * @param  string $name  
     * @return string
     */
    public function renderRadioList($form, $model, $name)
    {
        $items = $this->typeConfig->getItems();
        $options = $this->getInputOptions();
        return $form->field($model, $name)->radioList($items, $options);
    }



    /**
     * 渲染多选列表
     * 
     * @param  ActiveForm $form 
     * @param  Model  $model 
     * @param  string $name  
     * @return string
     */
    public function renderCheckboxList($form, $model, $name)
    {
        $items = $this->typeConfig->getItems();
        $options = $this->getInputOptions();
        return $form->field($model, $name)->checkboxList($items, $options);
    }



    /**
     * 渲染多选框
     * 
     * @param  ActiveForm $form 
     * @param  Model  $model 
     * @param  string $name  
     * @return string
     */
    public function renderCheckbox($form, $model, $name)
    {
        $options = $this->getInputOptions();
        $options['value'] = '是';
        $options['uncheck'] = '否';
        return $form->field($model, $name)->checkbox($options);
    }



    /**
     * 渲染单选框
     * 
     * @param  ActiveForm $form 
     * @param  Model  $model 
     * @param  string $name  
     * @return string
     */
    public function renderRadio($form, $model, $name)
    {
        $options = $this->getInputOptions();
        $options['value'] = '是';
        $options['uncheck'] = '否';
        return $form->field($model, $name)->radio($options);
    }



    /**
     * 渲染 select 框。
     * 
     * @param  [type] $form  [description]
     * @param  [type] $model [description]
     * @param  [type] $name  [description]
     * @return [type]        [description]
     */
    public function renderSelect($form, $model, $name)
    {
        $options = $this->getInputOptions();
        if(isset($options['multiple']) && $options['multiple']) {
            return $this->renderMultiselect($form, $model, $name);
        }
        $options['prompt'] = Yii::t('app', 'Please select');
        $items = $this->typeConfig->getItems();
        return $form->field($model, $name)->dropDownList($items, $options);
    }



  
    /**
     * 渲染多选框
     * 
     * @param  [type] $form  [description]
     * @param  [type] $model [description]
     * @param  [type] $name  [description]
     * @return [type]        [description]
     */
    public function renderMultiselect($form, $model, $name)
    {
        $options = $this->getInputOptions();
        $options['multiple'] = true;
        $items = $this->typeConfig->getItems();
        return $form->field($model, $name)->dropDownList($items, $options);
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
    public function renderPassword($form, $model, $name)
    {
        return $form->field($model, $name)->passwordInput($this->getInputOptions());
    }




    /**
     * 渲染 textarea
     * 
     * @param  ActiveForm $form 
     * @param  Model  $model 
     * @param  string $name  
     * @return string
     */
    public function renderTextarea($form, $model, $name)
    {
        return $form->field($model, $name)->textarea($this->getInputOptions());
    }



    /**
     * 渲染文本框
     * 
     * @param  ActiveForm $form 
     * @param  Model  $model 
     * @param  string $name  
     * @return string
     */
    public function renderText($form, $model, $name)
    {
        $options = $this->getInputOptions();
        return $form->field($model, $name)->textInput($this->getInputOptions());
    }




}