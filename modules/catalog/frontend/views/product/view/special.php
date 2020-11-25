<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>
<?php 
/**
 * @var  $this yii\web\View
 * @var  $product catalog\models\Product
 * 
 */
$category = $product->category;
$attributes = $category->categoryAttributes;
$specs = $product->productSpecs;
?>
<table class="detail-table table table-hover table-bordered">
    <tbody>
    <?php foreach($attributes as $attribute): ?>
        <?php $spec = $specs[$attribute->id] ?? null; ?>
        <?php if(!$spec):  continue; endif; ?>

        <tr>
            <th><?= Html::encode($attribute->name) ?></th>
            <?php $value = $spec->value; ?>
            <?php if(is_array($value)): ?>
                <td>
                    <ul class="m-0 list-unstyled">
                        <?php foreach($value as $strvalue): ?>
                        <li><?= Html::encode($strvalue) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </td>
            <?php else: ?>
                <td><?= Html::encode($value) ?></td>   
            <?php endif; ?>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>