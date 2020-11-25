<?php

namespace core\widgets\pjaxmodal;

use Yii;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\widgets\InputWidget;

/**
 * pjaxmodal 输入框基类.
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class PjaxModalInput extends InputWidget
{


    /**
     * @var string 指定 pjaxmodal 的 id
     */
    public $pjaxmodal = 'pjaxmodal';


    /**
     * @var array 值的 hash 键为元素的值, 值为元素的 label
     */
    public $data = null;

    
    /**
     * @var string 请求 pjax 的链接
     */
    public $link;


    /**
     * @var array pjax 链接的选项. title 如果不设置,默认为Select value
     */
    public $linkOptions = [];

 
    /**
     * @var array 渲染值的标签
     */
    public $valueOptions = [];


    /**
     * @var array 渲染值的标签的容器
     */
    public $valuesOptions = [];

    
    /**
     * @var array 渲染 input 的选项
     *    无论是单选还是多选, 都会渲染一个隐藏的 select
     *    multiple 无法设置,即使设置了也会被去掉.
     *    tag 无法被设置, 设置了也会被改成 select
     */
    public $inputOptions = [];


    /**
     * @var array 容器的选项.
     */
    public $options = [];


    public $isMultiple = false;

    
    /**
     * @var array 容器选项
     */
    public $containerOptions = [];

    



    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        PjaxModal::widget([
            'id' => $this->pjaxmodal,
        ]);

        PjaxModalInputAsset::register($this->getView());
        if(!isset($this->linkOptions['id'])) {
            $this->linkOptions['id'] = $this->options['id'] . '_link';
        }

        if($this->data === null) {
            if($this->hasModel()) {
                $this->data = $this->model->{$this->attribute};
            } else {
                $this->data = $this->value;
            }
        }
        if(is_string($this->data) || is_numeric($this->data)) {
            $k = $this->data;
            $this->data = [$k => $k];
        } elseif(!is_array($this->data)) {
            $this->data = [];
        }

        $this->registerClientOptions();
    }


    /**
     * @inheritdoc
     */
    public function run()
    {
        $options = $this->containerOptions;
        $tag = ArrayHelper::remove($options, 'tag', 'div');
        Html::addCssClass($options, 'pminput-container');
        if($this->isMultiple) {
            // multiple values pjaxmodal input
            Html::addCssClass($options, 'pminput-mv');
        } else {
            // single value pjaxmodal input
            Html::addCssClass($options, 'pminput-sv');
        }
        $html = Html::beginTag($tag, $options);
        $html .= $this->renderInput();
        $html .= $this->renderValues();
        $html .= $this->renderPjaxLink();
        $html .= Html::endTag($tag);
        return $html;
    }


    /**
     * 渲染隐藏的输入框
     * 
     * @return string
     */
    public function renderInput()
    {
        $options = $this->options;
        unset($options['tag']);
        $options['multiple'] = $this->isMultiple;
        Html::addCssClass($options, 'pminput-input hidden');
        if($this->isMultiple) {
            $options['value'] = array_keys($this->data);
        } else {
            $options['value'] = key($this->data);
        }
        
        $content = '';
        // 加隐藏 input
        if(!$this->isMultiple) {
            if($this->hasModel()) {
                $content .= Html::activeHiddenInput($this->model, $this->attribute, [
                    'value' => '',
                    'id' => null,
                ]);
            } else {
                $content .= Html::hiddenInput($this->name, '', [
                    'id' => null,
                ]);
            }
        } else {
            $options['unselect'] = '';
        }
        
        if($this->hasModel()) {
            return $content .= Html::activeDropDownList($this->model, $this->attribute, $this->data, $options);
        }
        return $content .= Html::dropDownList($this->name, $this->value, $this->data, $options);
    }



    /**
     * 渲染所有值以及值的容器
     * 
     * @return string
     */
    public function renderValues()
    {
        $content = '';
        foreach($this->data as $value => $title) {
            $content .= $this->renderValue($value, $title);
        }
        $options = $this->valuesOptions;
        $tag = ArrayHelper::remove($options, 'tag', 'div');
        Html::addCssClass($options, 'pminput-values');
        return Html::tag($tag, $content, $options);
    }


    /**
     * 渲染值
     * 
     * @param  string $value 值
     * @param  string $title 值的title
     * @return string  值标签
     */
    public function renderValue($value, $title)
    {
        $close = Html::tag('i', '', [
            'class' => 'fa fa-close delete-value'
        ]);
        $title = Html::encode($title);
        $options = $this->valueOptions;
        Html::addCssClass($options, 'pminput-value');
        $options['data-pminput-value'] = $value;
        $options['data-pminput-title'] = $title;
        $options['title'] = $title;
        $tag = ArrayHelper::remove($options, 'tag', 'a');
        if($tag === 'a' && !isset($options['href'])) {
            $options['href'] = '#';
        }
        return Html::tag($tag, $title . $close, $options);
    }



    /**
     * 渲染 pjax 连接
     * 
     * @return string
     */
    public function renderPjaxLink()
    {
        $options = $this->linkOptions;
        $options[PjaxModal::DATA_ATTRIBUTE] = '#' . $this->pjaxmodal;
        if(!isset($options['title'])) {
            $title = $options['title'] = Yii::t('app', 'Select value');
        } else {
            $title = $options['title'];
        }
        Html::addCssClass($options, 'pminput-pjaxlink');
        return Html::a($title, $this->link, $options);
    }



    /**
     * 注册客户端选项
     */
    public function registerClientOptions()
    {
        $id = $this->linkOptions['id'];
        $this->getView()->registerJs("\$('#{$id}').pjaxModalInput();");
    }


}