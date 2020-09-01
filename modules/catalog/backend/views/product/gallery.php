<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\Json;
?>
<?php 
/**
 * @var  $this yii\web\View
 * @var  $model  catalog\backend\models\ProductForm
 * @var  $product catalog\models\Product
 * @var  $form  yii\bootstrap4\ActiveForm
 * 
 */
$formName = $product->formName();
?>
<div id="product_gallery">
    <div class="d-none">
        <?= $form->field($model->galleryForm, 'galleries[]')->dropDownList($model->galleryForm->hashOptions(), [
            'multiple' => true,
        ]) ?>
    </div>
    <input class="d-none" type="file" id="product_gallery_fileinput" multiple />
    <label id="product_gallery_drop_zone" class="previews border" for="product_gallery_fileinput">
         拖拽区域
    </label>
</div>
<style>
    #product_gallery_drop_zone {
        width: 100%;
        min-height: 300px;
    }
</style>
<?php $this->beginScript() ?>
<script>
    $('#galleryform-galleries').find('option').each(function() {
        if(this.value) {
            $(this).prop('selected', true);
        }
    });
    $.uploader('#product_gallery', {
        'url': '<?= Url::to(['/core/file/upload', 'id' => 'catalog/product/gallery'])?>',
        'dropZone': $('#product_gallery_drop_zone'),
        'paramName': 'file',
        'views': {
            success: function(file_id, data) {
                var filename = data.filename;
                var option = $('<option>', {
                    value: filename, 
                    'selected': true
                });
                option.text(data.url);
                $('#galleryform-galleries').append(option);
                option.prop('selected', true);
            },
            error: function(file_id, message) {
                alert(message);
            },
            remove: function(file_id) {
                var preview = this.find('[' + file_id +']');
                var src = preview.find('img').attr('src');
                $('#galleryform-galleries').find('option').each(function() {
                    if($(this).text() === src ) {
                        $(this).remove();
                    }
                });
            },
            previews: <?= $model->galleryForm->getPreviewsJson() ?>
        }
    });
</script>
<?php $this->endScript() ?>