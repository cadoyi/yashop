<?php

namespace common\assets;

use Yii;

/**
 * asset bundle
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class AssetBundle extends \yii\web\AssetBundle
{

    public $sourcePath = '@common/assets/resource';

    public $asset;


    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        if($this->asset !== null) {
            $this->sourcePath = $this->sourcePath . '/' . $this->asset;
        }
    }

}