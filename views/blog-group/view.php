<?

use kartik\datetime\DateTimePicker;
use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\ElFinder;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;
?>

<? $this->title                   = 'Группы'; ?>
<? $this->params['breadcrumbs'][] = ["label" => $this->title, "url" => Url::toRoute([Yii::$app->controller->id.'/index'])]; ?>

<? if ($model): ?>
    <? $this->params['breadcrumbs'][] = $model->name; ?>
<? endif; ?>
 

<h3>Группа "<?= $model->name ?>"</h3>
<div class="tab-content">
    <div class="tab-pane fade in active" id="tab-main">
        <?
        $form = ActiveForm::begin([
                'id' => 'action-form',
                'method' => 'POST',
                'action' => Url::toRoute([Yii::$app->controller->id.'/view', 'id' => $model->id]),
                'options' => [
                    'enctype' => 'multipart/form-data',
                ],
                'enableAjaxValidation' => false,
                'enableClientValidation' => true
        ]);
        ?>
        <div class="hidden">
            <?= $form->field($model, 'id')->hiddenInput()->label(false); ?>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <h4>Обязательное</h4>
                <?= $form->field($model, 'name'); ?> 
                <div class="row">
                 

                    <div class="col-sm-3">
                        <label>&nbsp;</label>
                        <?=
                            $form->field($model, 'is_active', ["template" => "{input}{label}"])
                            ->checkbox(["class" => "checkbox"], false);
                        ?>
                    </div>
                </div>
                
            </div>
        
        </div>
 
        <div class="form-group">
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary', 'name' => 'action-button']) ?>
        </div>
        <? ActiveForm::end(); ?>
    </div>
</div>

