<?php

namespace catalog\models\forms;

use Yii;
use yii\base\Exception;
use core\models\DynamicForm;
use catalog\models\Product;
use catalog\models\ProductSales;
use catalog\models\ProductInventory;
use catalog\models\forms\product\GalleryForm;
use catalog\models\forms\product\OptionsForm;
use catalog\models\forms\product\CategoryAttributeForm;

/**
 * 编辑产品的表单
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class ProductEditForm extends DynamicForm
{



    /**
     * 初始化对应的表单.
     * 
     * @return array
     */
    public function initForms()
    {
        $this->set('categoryAttributeForm', new CategoryAttributeForm([
            'form'    => $this,
            'product' => $this->product,
        ]));

        if($this->product->isNewRecord) {
            //$salesForm = new ProductSales([
            //    'product' => $this->product,
            //]);
            //$salesForm->insertMode();
            //$this->set('salesForm', $salesForm);


            $inventoryForm = new ProductInventory([
                'product' => $this->product,
            ]);
            $inventoryForm->insertMode();
            $this->set('inventoryForm', $inventoryForm);

        } else {
           // $this->set('salesForm', $this->product->salesData);
            $this->set('inventoryForm', $this->product->inventory);      
        }

        $this->set('galleryForm', new GalleryForm(['product' => $this->product]));
        $this->set('optionsForm', new OptionsForm(['product' => $this->product]));
    }




    /**
     * 保存
     * 
     * @return  boolean
     */
    public function save()
    {
        if(!$this->validate()) {
            return false;
        }
        $trans = Product::getDb()->beginTransaction();
        try {
            foreach($this->_forms as $form) {
                if($form->canSetProperty('product')) {
                    $form->product = $this->product;
                }
                if(!$form->save()) {
                    throw new Exception('表单保存失败!');
                }
            }
            $trans->commit();
        } catch(\Exception | \Throwable $e) {
            $trans->rollBack();
            throw $e;
        }
        return true;
    }



}