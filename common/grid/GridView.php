<?php

namespace common\grid;

use Yii;
use yii\helpers\Html;

/**
 * grid view
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class GridView extends \yii\grid\GridView
{

    public $layout = "{header}\n{items}\n{footer}";

    public $footerLayout = "{pager}\n{jumper}\n{summary}\n{swicher}";

    public $summary = '<div class="summary"> {count} 条/页 {page}/{pageCount} 页 </div>';

    public $pager = [
        'class' => LinkPager::class,
    ];


    public $swicherRange = [10, 20, 30, 40, 50];




    /**
     * @inheritdoc
     */
    public function renderSection($name)
    {
        switch($name) {
            case '{header}':
                return $this->renderHeader();
            case '{footer}':
                return $this->renderFooter();
            case '{swicher}':
                return $this->renderSwicher();
            case '{jumper}':
                return $this->renderJumper();
            default:
                return parent::renderSection($name);
        }
    }




    /**
     * @inheritdoc
     */
    public function renderItems()
    {
        $items = parent::renderItems();
        return Html::tag('div', $items, [
            'class' => 'table-wrapper',
        ]);
    }



    public function renderHeader()
    {
        return '';
    }


    
    /**
     * 渲染底部.
     * 
     * @return string
     */
    public function renderFooter()
    {

        if ($this->dataProvider->getCount() > 0) {
            $footer = preg_replace_callback('/{\\w+}/', function ($matches) {
                $content = $this->renderSection($matches[0]);

                return $content === false ? $matches[0] : $content;
            }, $this->footerLayout);
        } else {
            $footer = '';
        }
        return Html::tag('div', $footer, [
            'class' => 'grid-view-footer',
        ]);
    }



    /**
     * 渲染输入后跳转
     * 
     * @return string
     */
    public function renderJumper()
    {
        if (($pagination = $this->dataProvider->getPagination()) !== false) {
            $page = $pagination->page + 1;
            $input = Html::input('number', null, $page, [
                'min' => 1,
                'max' => $pagination->pageCount,
                'page-param' => $pagination->pageParam,
            ]);
            $prev = Html::tag('span', '跳到');
            $next = Html::tag('span', '页');
            return Html::tag('div', $prev . $input . $next, [
                'class' => 'jumper',
            ]);
        }
        return '';
    }



    /**
     * 换页.
     * 
     * @return string
     */
    public function renderSwicher()
    {
        if (($pagination = $this->dataProvider->getPagination()) !== false) {
            $limits = $pagination->pageSizeLimit;
            $pageSize = $pagination->getPageSize();
            $sizes = [];
            foreach($this->swicherRange as $size) {
                if($limits === false || $size <= $limits[1]) {
                    $sizes[$size] = $size . ' 条/页';
                }
            }
            return Html::dropDownList(null, $pageSize, $sizes, [
                'class' => 'swicher',
                'page-size-param' => $pagination->pageSizeParam,
                'page-size' => $pageSize,
            ]);            
        }
        return '';
    }



}