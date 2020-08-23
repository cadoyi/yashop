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
?>
<table class="table table-hover table-bordered">
    <tbody>
    <?php foreach($product->type_data as $label => $value): ?>
        <tr>
            <th><?= Html::encode($label) ?></th>
            
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