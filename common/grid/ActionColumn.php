<?php

namespace common\grid;

use Yii;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * action column
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class ActionColumn extends \yii\grid\ActionColumn
{

    public $template = '{update} {delete}';

    public $header = '操作';


    public $buttonOptions = [
        'aria-role' => 'action', 
    ];



    /**
     * Initializes the default button rendering callbacks.
     */
    protected function initDefaultButtons()
    {
        $this->initDefaultButton('view', 'eye-open', [
            'class' => 'action-view',
        ]);
        $this->initDefaultButton('update', 'pencil', [
            'class' => 'action-update',
        ]);
        $this->initDefaultButton('delete', 'trash', [
            'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
            'data-method' => 'post',
            'class' => 'action-delete',
        ]);
    }




    /**
     * @inheritdoc
     */
    protected function initDefaultButton($name, $iconName, $additionalOptions = [])
    {
        if (!isset($this->buttons[$name]) && strpos($this->template, '{' . $name . '}') !== false) {
            $this->buttons[$name] = function ($url, $model, $key) use ($name, $iconName, $additionalOptions) {
                switch ($name) {
                    case 'view':
                        $title = Yii::t('yii', 'View');
                        break;
                    case 'update':
                        $title = Yii::t('yii', 'Update');
                        break;
                    case 'delete':
                        $title = Yii::t('yii', 'Delete');
                        break;
                    default:
                        $title = ucfirst($name);
                }
                $options = array_merge([
                    'title' => $title,
                    'aria-label' => $title,
                    'data-pjax'  => '0',
                ], $additionalOptions, $this->buttonOptions);
                $icon = Html::tag('span', '', ['class' => "glyphicon glyphicon-$iconName"]);
                return Html::a($title.$icon, $url, $options);
            };
        }
    }



    /**
     * {@inheritdoc}
     */
    protected function renderDataCellContent($model, $key, $index)
    {
        return preg_replace_callback('/\\{([\w\-\/]+)\\}/', function ($matches) use ($model, $key, $index) {
            $name = $matches[1];

            if (isset($this->visibleButtons[$name])) {
                $isVisible = $this->visibleButtons[$name] instanceof \Closure
                    ? call_user_func($this->visibleButtons[$name], $model, $key, $index, $this)
                    : $this->visibleButtons[$name];
            } else {
                $isVisible = true;
            }

            if ($isVisible && isset($this->buttons[$name])) {
                $url = $this->createUrl($name, $model, $key, $index);
                return call_user_func($this->buttons[$name], $url, $model, $key, $this);
            }

            return '';
        }, $this->template);
    }


    
    /**
     * 构建 button
     * 
     * @return string
     */
    public function createButton($title, $url, $options = [])
    {
        $buttonOptions = array_merge([
            'title'      => $title,
            'aria-label' => $title,
            'data-pjax'  => 0,
        ], $options, $this->buttonOptions);
        return Html::a($title, $url, $buttonOptions);
    }


}