<?php

namespace catalog\models\forms;

use Yii;
use yii\base\DynamicModel;
use catalog\models\Product;
use catalog\models\ProductSku;

/**
 * product sku form
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class ProductSkuForm extends DynamicModel
{

    public $product;

    public $productSku;


    
    /**
     * @inheritdoc
     */
    public function __construct( $options = [] )
    {
        parent::__construct([], $options);
        if(is_null($this->productSku)) {
            $this->productSku = new ProductSku(['product' => $this->product]);
            $this->productSku->insertMode();
        }
        $this->defineAttributes();
    }


    /**
     * 定义当前类的属性.
     */
    public function defineAttributes()
    {
        foreach($this->productSku->attributes() as $attribute) {
            $value = $this->productSku->$attribute;
            $value = $this->prepareValue($attribute, $value);
            $this->defineAttribute($attribute, $value);
        }
        $attrs = $this->productSku->attrs;
        if(is_null($attrs)) {
            $attrs = [];
        }
        foreach($this->product->options as $option) {
            $value = $attrs[$option->name] ?? null;
            $this->defineAttribute($option->name,  $value);
            $this->addRule($option->name, 'required');
            $this->addRule($option->name, 'in', ['range' => $option->values]);
        }
        foreach($this->productSku->rules() as $rule) {
            $attributes = array_shift($rule);
            $validator = array_shift($rule);
            $params = $rule;
            $this->addRule($attributes, $validator, $params);
        }
    }



    /**
     * 处理属性值.
     * 
     * @param  string $value  属性值
     * @return mixed
     */
    public function prepareValue($attribute, $value)
    {
        if(is_null($value)) {
            switch($attribute) {
                case 'qty':
                    $value = $this->product->inventory->qty;
                    break;
                case 'price':
                    $value = $this->product->price;
                    break;
                case 'promote_price':
                    $value = $this->product->promote_price;
                    break;
                default:
                    break;
            }            
        }

        return $value;
    }


    /**
     * @inheritdoc
     */
    public function afterValidate()
    {
        $this->validateUnique();
        return parent::afterValidate();
    }



    /**
     * 验证 unique 值.
     */
    public function validateUnique()
    {
        foreach($this->product->skus as $sku) {
            if($sku->id === $this->productSku->id) {
                continue;
            }
            $data = $sku->attrs;
            $exist = true;
            foreach($data as $name => $value) {
                if($this->$name !== $value) {
                     $exist = false;
                }
            }
            if($exist) {
                foreach($data as $name => $value) {
                    $this->addError($name, '相同属性值的 SKU 已经存在');
                }
                return;
            }
        }
    }



    /**
     * 获取选项属性.
     * 
     * @return array
     */
    public function getOptions()
    {
        return $this->product->options;
    }




    /**
     * 获取选项 hash 值
     * 
     * @param  ProductOption $option
     * @return array
     */
    public function getOptionHashOptions( $option )
    {
        $values = $option->values;
        return array_combine($values, $values);
    }


    

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return $this->productSku->attributeLabels();
    }



    /**
     * @inheritdoc
     */
    public function attributeHints()
    {
        return $this->productSku->attributeHints();
    }



    /**
     * 保存
     */
    public function save()
    {
        if(!$this->validate()) {
            return false;
        }
        $productSku = $this->productSku;
        $excepts = ['id', 'attrs', 'product_id', 'sku'];
        $attrs = [];
        $sku = $this->product->sku;
        foreach($this->product->options as $option) {
            $name = $option->name;
            $excepts[] = $name;
            $attrs[$name] = $this->$name;
            $sku .= '-' . $this->$name;
        }
        $attributes = $this->attributes;
        foreach($attributes as $attribute => $value) {
            if(in_array($attribute, $excepts, true)) {
                continue;
            }
            $productSku->$attribute = $value;
        }
        $productSku->setProduct($this->product);
        $productSku->attrs = $attrs;
        $productSku->sku = $sku;
        return $productSku->save();
    }



}