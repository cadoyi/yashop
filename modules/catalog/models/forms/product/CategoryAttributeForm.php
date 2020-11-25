<?php

namespace catalog\models\forms\product;

use Yii;
use cando\base\DynamicModel;
use catalog\models\CategoryAttribute;
use catalog\models\ProductSpec;


/**
 * 分类属性表单, 用于编辑产品的产品类型.
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class CategoryAttributeForm extends DynamicModel
{

    public $form;


    public $product;


    public $category;


    public $isNewRecord = false;


    /**
     * @inheritdoc
     */
    public function __construct( $options = [])
    {
        parent::__construct([], $options);
        $this->category = $this->product->category;
        $this->isNewRecord = $this->product->isNewRecord;
        $this->defineTypeAttributes();
    }



    /**
     * 定义当前类的属性.
     * 
     * @return array
     */
    public function defineTypeAttributes()
    {
        $attributes = $this->category->categoryAttributes;

        foreach($attributes as $attribute) {
            $name = 'attr_' . $attribute->id;
            $value = $this->getCategoryAttributeValueFormProduct($attribute);
            $this->defineAttribute($name, $value);
            $this->addRule($name, 'required');
            $this->_labels[$name] = $attribute->name;
        }
    }



    /**
     * 从产品中获取保存的属性值.
     * 
     * @param  CategoryAttribute $attribute 
     * @return mixed
     */
    public function getCategoryAttributeValueFormProduct( CategoryAttribute $attribute )
    {
        if($this->isNewRecord) {
            return null;
        }
        $specs = $this->product->productSpecs;
        $spec = $specs[$attribute->id] ?? null;

        return $spec ? $spec->value : null;
    }




    /**
     * 根据 input 名称或 ID 获取分类属性对象.
     * 
     * @param  string $inputNameOrId
     * @return CategoryAttribute
     */
    public function getCategoryAttribute($inputNameOrId)
    {
        if(is_numeric($inputNameOrId)) {
            $id = $inputNameOrId;
        } else {
            $id = str_replace('attr_', '', $inputNameOrId);
        }
        $attributes = $this->category->categoryAttributes;
        if(isset($attributes[$id])) {
            return $attributes[$id];
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
        $attribute = $this->getCategoryAttribute($name);
        if($attribute) {
            $config = $attribute->inputTypeConfig;
            $render = $config->render;
            return $render->render($form, $attribute, $this, $name);
        }
        return $form->field($this, $name)->textInput();
    }




    /**
     * @inheritdoc
     */
    public function formName()
    {
        return 'caf';
    }






    /**
     * 保存
     * 
     * @return boolean
     */
    public function save()
    {
        if(!$this->validate()) {
            return false;
        }
        if($this->isNewRecord) {
            $specs = [];
            foreach($this->attributes() as $attr) {
                $value = $this->$attr;
                $attribute = $this->getCategoryAttribute($attr);
                $spec = new ProductSpec([
                    'product'   => $this->product,
                    'category'  => $this->category,
                    'categoryAttribute' => $attribute,
                    'value'     => $value,
                ]);
                $spec->save();
                $specs[$attribute->id] = $spec;
            }
            $this->product->populateRelation('productSpecs', $specs);
        } else {
            $specs = $this->product->productSpecs;
            foreach($this->attributes() as $attr) {
                $value = $this->$attr;
                $attribute = $this->getCategoryAttribute($attr);
                $spec = $specs[$attribute->id] ?? new ProductSpec([
                    'product'   => $this->product,
                    'category'  => $this->category,
                    'categoryAttribute' => $attribute,
                ]);
                $spec->value = $value;
                $spec->save();
                $specs[$attribute->id] = $spec;
            }
            $this->product->populateRelation('productSpecs', $specs);
        }

        return true;
    }


}