<?php

namespace issue\frontend\controllers;

use Yii;
use frontend\controllers\Controller;
use issue\models\Menu;
use issue\models\Content;
use issue\models\Category;
use yii\data\ActiveDataProvider;


/**
 * 帮助中心
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class IssueController extends Controller
{


    /**
     * 常见问题。
     */
    public function actionIndex()
    {
        return $this->render('index');
    }



    /**
     * 列出一个问题。
     */
    public function actionMenu($id)
    {
        $menu = $this->findModel($id, Menu::class);
        $query = Content::find()
            ->andWhere(['menu_id' => $menu->id])
            ->select(['id', 'title']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 15,
            ],
        ]);

        return $this->render('menu', [
           'menu' => $menu,
           'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * 问题内容。
     *
     * @param  int $mid  菜单 ID
     * @param  int $id   内容 ID
     */
    public function actionContent($mid, $id)
    {
        $menu = $this->findModel($mid, Menu::class);
        $content = $this->findModel($id, Content::class);

        if($content->menu_id != $menu->id) {
            return $this->notFound();
        }
        $content->menu = $menu;
        
        return $this->render('content', [
            'content' => $content,
        ]);
    }



    /**
     * 进行搜索。
     * 
     * @param  string $q 
     */
    public function actionSearch( $q )
    {
        $c = Yii::$app->request->get('c');
        $category = $this->findModel($c, Category::class,true, 'code');
        $query = Content::find()
           ->andWhere(['category_id' => $category->id])
           ->andWhere([
                'or',
                ['like', 'title', $q],
                ['like', 'content', $q],
           ]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 15,
            ],
        ]);

        return $this->render('search', [
            'dataProvider' => $dataProvider,
        ]);
    }

}