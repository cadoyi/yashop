<?php

namespace catalog\backend\models;

use Yii;
use yii\base\Model;
use yii\helpers\Json;
use yii\helpers\ArrayHelper;
use catalog\models\ProductGallery;

/**
 * 产品图表单
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class GalleryForm extends Model
{

    public $product;


    public $galleries = [];


    
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        if(!$this->product->isNewRecord) {
            $galleries = $this->product->galleries;
            foreach($galleries as $gallery) {
                $this->galleries[] = $gallery->image;
            }            
        }

    }



    /**
     * 获取 hash 选项.
     * 
     * @return array
     */
    public function hashOptions()
    {
        $options = [];
        foreach($this->galleries as $image) {
            $options[$image] = (string) Yii::$app->storage->getUrl($image, 90);
        }       
        return $options;
    }



    /**
     * 获取预览的 json 数据.
     *  
     * @return json
     */
    public function getPreviewsJson()
    {
        return Json::encode($this->hashOptions());
    }



    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['galleries'], 'required'],
            ['galleries', 'each', 'rule' => ['string', 'max' => 255]],
        ];
    }



    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'galleries' => Yii::t('app', 'Product galleries'),
        ];
    }



    /**
     * 保存
     */
    public function save()
    {
        $product = $this->product;
        if(!$this->product->isNewRecord) {
            $galleries = $this->product->galleries;
        } else {
            $galleries = [];
        }
        $models = [];
        foreach($this->galleries as $index => $image) {
            $exist = false;
            foreach($galleries as $id => $gallery) {
                if($gallery->image === $image) {
                    $models[] = $gallery;
                    $gallery->sort_order = $index;
                    $exist = true;
                    break;
                }
            }
            if(!$exist) {
                $models[] = new ProductGallery([
                    'product' => $product,
                    'image'   =>  $image,
                    'sort_order' => $index,
                ]);
            }
        }
        $deletes = [];
        foreach($galleries as $gallery) {
            if(!in_array($gallery, $models, true)) {
                $gallery->delete();
            }
        }
        foreach($models as $model) {
            if(false === $model->save()) {
                throw new \Exception('Product gallery save failed');
            }
        }
        return true;
    }





}