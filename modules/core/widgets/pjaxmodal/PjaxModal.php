<?php
/**
 * 每次修改的时候, 记得修改版本号.
 *
 * @version  v1.0.2 基本的 pjax 通信.
 * @package  pjaxmodal
 */

namespace core\widgets\pjaxmodal;

use Yii;
use yii\base\Widget;
use yii\base\InvalidConfigException;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;
use yii\bootstrap4\Modal as bs4Modal;
use yii\web\View;
use yii\helpers\Html;
use yii\helpers\Json;


/**
 * pjax 和 modal 组合
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class PjaxModal extends Widget
{
    /**
     * string 指定链接的 data 属性.
     */
    const DATA_ATTRIBUTE = 'data-pjaxmodal';

    public static $modalIndex = 1052;


    public static $instanceIds = [];


    public $bsVersion = 4;

    /**
     * 输出这个插件的位置
     *  View::EVENT_END_BODY
     *  View::EVENT_BEGIN_BODY
     *  View::EVENT_BEGIN_PAGE
     *  View::EVENT_END_PAGE
     *  null : 表示当前位置输出
     * 
     * @var string 
     */
    public $position = View::EVENT_END_BODY;


    public $zIndex = null;


    /**
     * @var array modal 的选项
     */
    public $modalOptions = [
        'clientOptions' => [
            'backdrop' => 'static',
            'keyboard' =>  false,
        ],
        'size' => Modal::SIZE_LARGE,
    ];



    /**
     * @var array pjax 的选项
     */
    public $pjaxOptions = [
        'enablePushState'    => false,
        'enableReplaceState' => false,
        'timeout'            => 3000,
    ];


    /**
     * @var string 当前id
     */
    public $id;

    
    /**
     * @var boolean  是否为 widget
     */
    public $isWidget = false;


    protected $_modal;
    protected $_pjax;
    protected $_asset;

   
    protected $_rendered = false;



    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        if(!isset($this->id)) {
            throw new InvalidConfigException("The 'id' property must be set.");
        }

        if(is_null($this->zIndex)) {
            $this->zIndex = static::$modalIndex++;
        }

        // 保证一个 id 只渲染一次.
        if(array_key_exists($this->id, static::$instanceIds)) {
            $this->_rendered = true;      
        } else {
            static::$instanceIds[$this->id] = $this->id;
        }

        if($this->_rendered) {
            if(!$this->isWidget) {
                ob_start();
                ob_implicit_flush(false);
            }     
        } else {
            $this->realInit();
        }
    }

    /**
     * 真实的 init
     */
    public function realInit()
    {
        $this->_asset = PjaxModalAsset::register($this->getView());

        if(!isset($this->modalOptions['id'])) {
            $this->modalOptions['id'] = $this->id . '_modal';
        }
        $this->pjaxOptions['id'] = $this->id;

        $this->addCssClass('modalOptions', 'options', 'pjaxmodal-modal');
        $this->addCssClass('modalOptions', 'options', 'fade');
        $this->addCssClass('pjaxOptions', 'options', 'pjaxmodal-container');

        if(empty($this->modalOptions['options']['style'])) {
            $this->modalOptions['options']['style'] = [];
        }
        $this->modalOptions['options']['style']['z-index'] = $this->zIndex;


        if(!isset($this->pjaxOptions['formSelector'])) {
            $this->pjaxOptions['formSelector'] = '#' . $this->id . ' form:not([data-pjax="0"])'; 
        }
        if(!isset($this->pjaxOptions['linkSelector'])) {
            $this->pjaxOptions['linkSelector'] = '#' . $this->id . ' a:not([data-pjax="0"])';
        }

        ob_start();
        ob_implicit_flush(false);
        
        if($this->bsVersion === 4) {
            $this->_modal = bs4Modal::begin($this->modalOptions);
        } else {
            $this->_modal = Modal::begin($this->modalOptions);
        }
        

        $this->_pjax = Pjax::begin($this->pjaxOptions);

        if(!$this->isWidget) {
            ob_start();
            ob_implicit_flush(false);
        }        
    }


    /**
     * 增加 CSS 类
     * 
     * @param 当前类的属性值 $attribute 
     * @param string $key   属性键
     * @param string|array $class    css 类
     */
    public function addCssClass($attribute, $key, $class)
    {
        if(!isset($this->$attribute[$key])) {
            $this->$attribute[$key] = [];
        }
        Html::addCssClass($this->$attribute[$key], $class);
    }


    /**
     * @inheritdoc
     */
    public function run()
    {
        if($this->_rendered) {
            if(!$this->isWidget) {
                ob_get_clean();
            }
            return '';
        }
        return $this->realRun();
    }

 
    /**
     * 真实的运行
     */
    public function realRun()
    {
        if(!$this->isWidget) {
            $content = ob_get_clean();
        } else {
            $content = Html::beginTag('div', [
                'class' => 'pjaxmodal-content-placeholder text-center'
            ]);
            $content .= Html::img($this->_asset->getLoaderUrl(), [
                'style' => [
                     'display' => 'block',
                     'margin'  => 'auto',
                ],
            ]);
            $content .= Html::endTag('div');
        }

        echo $content; 

        Pjax::end();
        if($this->bsVersion === 4 ) {
            bs4Modal::end();
        } else {
            Modal::end();
        }
        

        $modalContent = ob_get_clean();


        if($this->position === null) {
           echo $modalContent;
        } else {
            $this->getView()->on($this->position, function($event) {
                echo $event->data;
            }, $modalContent);
        }

        $options = [
            'id'              => $this->id,
            'modal'           => $this->_modal->id,
            'content'         => $content,
            'dataAttribute'   => static::DATA_ATTRIBUTE,
            'push'            => $this->_pjax->enablePushState,
            'replace'         => $this->_pjax->enableReplaceState,
            'timeout'         => $this->_pjax->timeout,
            'scrollTo'        => $this->_pjax->scrollTo,
            'container'       => '#' . $this->id,
        ];

        if(isset($this->_pjax->clientOptions['container'])) {
             $options['container'] = $this->_pjax->clientOptions['container'];
        }
        
        $this->registerClientOptions($options);
    }





    /**
     * 注册客户端选项
     * 
     * @param  array $options 选项
     * @return 
     */
    public function registerClientOptions($options)
    {
        $jsOptions = Json::encode($options);

        $this->getView()->registerJs("\$.pjaxModal({$jsOptions})");
    }



    /**
     * 如果是 widget 调用,则自动设置 content, 否则使用现有的content
     * 
     * @param  array  $config 配置选项
     * @return $this
     */
    public static function widget($config = [])
    {
        $config['isWidget'] = true;
        return parent::widget($config);
    }


    /**
     * 表示不是 widget 调用.
     * 
     * @param  array  $config 
     * @return $this
     */
    public static function begin($config = [])
    {
        $config['isWidget'] = false;
        return parent::begin($config);
    }

}