<?php

namespace catalog\backend\models;

use Yii;
use cando\base\DynamicModel;
use catalog\models\ProductType;


/**
 * 产品类型属性表单
 * 
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class TypeAttributeForm extends DynamicModel
{

    public $type;


    public $product;


    /**
     * @inheritdoc
     */
    public function __construct( $options = [])
    {
        parent::__construct([], $options);
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
    public function getProductTypeAttributeValue($attribute)
    {
        if($this->product->isNewRecord) {
            return null;
        }
        $types = $this->product->productTypes;
        $attributeId = $attribute->id;
        if(isset($types[$attributeId])) {
            $type = $types[$attributeId];
            return $type->value;
        }
        return null;
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
     * @inheritdoc
     */
    public function formName()
    {
        return 'taf';
    }



    /**
     * 保存
     * 
     * @return boolean
     */
    public function save()
    {
        $productTypes = $this->product->productTypes;
        $types = [];
        foreach($this->attributes as $name => $value) {
            $attribute = $this->getTypeAttribute($name);
            $id = $attribute->id;
            if(isset($productTypes[$id])) {
                $productType = $productTypes[$id];
                $productType->value = $value;
            } else {
                $productType = new ProductType([
                    'product'       => $this->product,
                    'type'          => $this->type,
                    'typeAttribute' => $attribute,
                    'value'         => $value,
                ]);
            }
            if(false === $productType->save()) {
                throw new \Exception('Product type validate failed');
            }
            $types[$productType->type_attribute_id] = $productType;
        }
        $newIds = array_keys($types);
        $oldIds = array_keys($productTypes);
        $deletes = array_diff($oldIds, $newIds);
        foreach($deletes as $id) {
            $productType = $productTypes[$id];
            $productType->delete();
        }
        return true;

    }




}