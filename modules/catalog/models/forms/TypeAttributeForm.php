<?php

namespace catalog\models\forms;

use Yii;
use yii\helpers\Json;
use yii\base\DynamicModel;
use catalog\models\Type;
use catalog\models\TypeAttribute;

/**
 * type attribute form
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class TypeAttributeForm extends DynamicModel
{

    public $type;

    public $product;

    protected $_values;
    protected $_labels = [];


    /**
     * @inheritdoc
     */
    public function __construct( $options = [])
    {
        parent::__construct([], $options);
        $this->product->setTypeAttributeForm($this);
        if(!$this->type) {
            $this->type = $this->product->type;
        }
        $this->defineTypeAttributes();
    }



    /**
     * 定义类型属性。
     */
    public function defineTypeAttributes()
    {
        $attributes = $this->type->activedTypeAttributes;
        foreach($attributes as $attribute) {
            $name = 'attr_' . $attribute->id;
            $value = $this->getProductTypeAttributeValue($attribute);
            $this->defineAttribute($name, $value);
            $this->addRule($name, 'required');
            $this->_labels[$name] = $attribute->name;
        }

    }



    /**
     * 获取产品中保持的类型属性值。
     * 
     * @return array
     */
    public function getProductTypeAttributeValues()
    {
        $values = $this->product->type_data;
        if(empty($values)) {
            $values = [];
        }
        return $values;
    }


    
    /**
     * 获取类型属性值。
     * 
     * @return array
     */
    public function getProductTypeAttributeValue($attribute)
    {
        $values = $this->getProductTypeAttributeValues();
        $name = $attribute->name;
        if(isset($values[$name])) {
            $value = $values[$name];
            return $value;
        }
        return null;
    }



    /**
     * 属性 labels
     * 
     * @return array
     */
    public function attributeLabels()
    {
        return $this->_labels;
    }




    /**
     * @inheritdoc
     */
    public function formName()
    {
        return 'taf';
    }



    /**
     * 获取 input type
     * 
     * @param  [type] $inputName [description]
     * @return [type]            [description]
     */
    public function getTypeAttribute($inputName)
    {
        $id = str_replace('attr_', '', $inputName);
        foreach($this->type->activedTypeAttributes as $attribute) {
            if($attribute->id == $id) {
                return $attribute;
            }
        }
        return null;
    }



    /**
     * 渲染
     * 
     * @param  [type] $form [description]
     * @param  [type] $name [description]
     * @return [type]       [description]
     */
    public function render($form, $name)
    {
        $typeAttribute = $this->getTypeAttribute($name);
        if($typeAttribute) {
            $config = $typeAttribute->getTypeConfig();
            $config->typeAttribute = $typeAttribute;
            $render = $config->getRender();
            return $render->render($form, $this, $name);
        }
        return $form->field($this, $name)->textInput();
    }





    /**
     * 获取数据.
     * 
     * @return array
     */
    public function getProductTypeData()
    {
        $data = [];
        foreach($this->attributes() as $name) {
            $attribute = $this->getTypeAttribute($name);
            $data[$attribute->name] = $this->$name;
        }
        return $data;
    }

}