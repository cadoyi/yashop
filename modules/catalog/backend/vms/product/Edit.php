<?php

namespace catalog\backend\vms\product;

use Yii;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use cando\web\ViewModel;

/**
 * edit product view models
 * 
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class Edit extends ViewModel
{

    public $placeholderUrl;



    /**
     * 或许产品选项.
     * 
     * @return array
     */
    public function getProductOptions()
    {
        $options = $this->product->options;
        if(empty($options)) {
            $options = [];
        }
        return $options;
    }


    /**
     * 获取产品选项 json 数据
     * 
     * @return string
     */
    public function getProductOptionsJson()
    {
        return Json::encode($this->getProductOptions());
    }



    /**
     * 获取 skus 数据.
     * 
     * @return array
     */
    public function getSkusData()
    {
        $skus = $this->product->skus;
        if(empty($skus)) {
            $skus = [];
        }
        foreach($skus as $i => $sku) {
            if(isset($sku['image']) && is_string($sku['image']) && Yii::$app->storage->has($sku['image'])) {
                $sku['image_url'] = (string) Yii::$app->storage->getUrl($sku['image']);
            } else {
                $sku['image_url'] = $this->placeholderUrl;
            }
            $skus[$i] = $sku;
        }
        return $skus;
    }



    /**
     * 获取 sku 的 previews
     * @return array
     */
    public function getSkuPreviews()
    {
        $data = $this->getSkusData();
        $previews = ArrayHelper::getColumn($data, 'image_url');
        return Json::encode($previews);
    }



    /**
     * 获取 sku json 数据.
     * 
     * @return string
     */
    public function getSkusJson()
    {
        return Json::encode($this->getSkusData());
    }




    /**
     * 获取 gallery hash options
     * 
     * @return array
     */
    public function getGalleryHashOptions()
    {
        $gallery = $this->product->galleries;
        if(empty($gallery)) {
            $gallery = [];
        }
        $options = [];
        foreach($gallery as $filename) {
            $options[$filename] = (string) Yii::$app->storage->getUrl($filename);
        }
        return $options;
    }



    /**
     * 获取 previews json
     * 
     * @return string
     */
    public function getPreviewsJson()
    {
        $options = $this->getGalleryHashOptions();
        $data = array_values($options);
        return Json::encode($data);
    }




}