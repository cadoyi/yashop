<?php

namespace catalog\backend\models;

use Yii;
use yii\base\Component;
use catalog\models\Product;
use catalog\models\Type;
use catalog\models\Category;
use catalog\models\ProductSales;
use catalog\models\ProductInventory;

//use backend\models\catalog\forms\product\CategoryForm;
//use backend\models\catalog\forms\product\TypeAttributeForm;
//use backend\models\catalog\forms\product\OptionsForm;
//use backend\models\catalog\forms\product\SkusForm;
//use backend\models\catalog\forms\product\GalleryForm;

/**
 * 编辑产品的表单
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class ProductForm extends Component
{

    /**
     * @var Product 产品实例
     */
    public $product;



    /**
     * @var Type 分类产品类型实例.
     */
    public $type;

    
    /**
     * @var product\CategoryForm 选择分类的表单
     */
    public $category;


    public $typeAttribute;


    public $salesForm;


    public $inventoryForm;


    public $galleryForm;


    public $optionsForm;



    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->typeAttribute = new TypeAttributeForm([
            'type'      => $this->type,
            'product'   => $this->product,
        ]);

        if($this->product->isNewRecord) {
            $this->salesForm = new ProductSales([
                'product' => $this->product,
            ]);
            $this->salesForm->insertMode();
            $this->inventoryForm = new ProductInventory([
                'product' => $this->product,
            ]);
            $this->inventoryForm->insertMode();
        } else {
            $this->salesForm = $this->product->salesData;
            $this->salesForm->updateMode();
            $this->inventoryForm = $this->product->inventory;
            $this->inventoryForm->updateMode();
        }

        $this->galleryForm = new GalleryForm(['product' => $this->product]);
        $this->optionsForm = new OptionsForm(['product' => $this->product]);
        
 
        /*
        $this->options = new OptionsForm([
            'product' => $this->product,
        ]);
        $this->skus = new SkusForm([
            'product' => $this->product,
            'options' => $this->options,
        ]);
        $this->gallery = new GalleryForm([
           'product' => $this->product,
        ]);
        */
    }





   

    /**
     * 加载
     * 
     * @param  array $data 需要加载的数据
     * @return boolean
     */
    public function load($data)
    {
        if(Yii::$app->request->isPost) {
            $this->product->load($data);
            $this->typeAttribute->load($data);
            $this->inventoryForm->load($data);
            $this->salesForm->load($data);
            $this->galleryForm->load($data);
            $this->optionsForm->load($data);
            //$this->skus->load($data);
            return true;
        }
        return false;
    }


    /**
     * 验证
     * 
     * @return boolean
     */
    public function validate()
    { 
        $result = false;
        $this->product->validate() &&
        $this->typeAttribute->validate() &&
        $this->salesForm->validate() &&
        $this->inventoryForm->validate() &&
        $this->galleryForm->validate() &&
        $this->optionsForm->validate() &&
        //$this->skus->validate() &&
        $result = true;
        return $result;
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
        $trans = Product::getDb()->beginTransaction();
        try {
            $result = $this->product->save();
            if($result === false) {
                throw new \Exception('Product save faild');
            }
            $this->typeAttribute->save();

            $this->salesForm->setProduct($this->product);
            if(false === $this->salesForm->save()) {
                throw new \Exception('Product sales faild');
            }

            $this->inventoryForm->setProduct($this->product);
            if(false === $this->inventoryForm->save()) {
                throw new \Exception('Product inventory failed');
            }
            $this->galleryForm->product = $this->product;
            $this->galleryForm->save();
            $this->optionsForm->save();
            //$this->skus->save();
            $trans->commit();
        } catch(\Throwable $e) {
            $trans->rollBack();
            throw $e;
        }
        return true;
    }
}