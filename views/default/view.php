<?

use kartik\datetime\DateTimePicker;
use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\ElFinder;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;
?>

<? $this->title                   = 'Записи'; ?>
<? $this->params['breadcrumbs'][] = ["label" => $this->title, "url" => Url::toRoute([Yii::$app->controller->id.'/index'])]; ?>

<? if ($model): ?>
    <? $this->params['breadcrumbs'][] = $model->name; ?>
   <? $this->title = $model->name; ?>
<? endif; ?>



<h3>Новость "<?= $model->name ?>"</h3>
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
                  <?= $form->field($model, 'text_fantomas')->hiddenInput()->label(false); ?> 

        </div>
        <div class="row">
            <div class="col-sm-6">
                <h4>Обязательное</h4>
                <?= $form->field($model, 'name'); ?>
                                    <?=
                    $form->field($model, 'news_group_id')->label(false)->dropDownList(
                        \yii\helpers\ArrayHelper::map($groups, 'id', 'name'), [
                        'prompt' => 'Выбор категории',
                         
                        ]
                    );
                    ?>
                <?= $form->field($model, 'url'); ?>
                <?= $form->field($model, 'text_announcement')->textarea(); ?>
                <div class="row">
                    <div class="col-sm-5">
                        <div class="row">
                            <div class="col-sm-4">
                                <? if ($model->image): ?>
                                    <div class="form-group">
                                        <img height="50" src="<?= $model->src ?>">
                                    </div>
                                <? endif; ?>
                            </div>
                            <div class="col-sm-8">
                                <?= $form->field($model, 'imageFile')->fileInput(); ?>
                            </div>
                        </div>
                    </div>

                </div>
                <div class='row'>
                    <div class="col-sm-6">
                        <?=
                        $form->field($model, 'timestamp')->widget(DateTimePicker::classname(), [
                            'options' => [
                                'value' => (!$model->timestamp || $model->timestamp == "0000-00-00 00:00:00") ? date('Y-m-d H:i:s') : $model->timestamp,
                            ],
                            'pluginOptions' => [
                                'startDate' => date('Y-m-d H:i:s'),
                                'format' => 'yyyy-mm-dd hh:ii:ss',
                                'autoclose' => true,
                            ]
                        ]);
                        ?>
                    </div>
                    <div class="col-sm-6">
                        <?=
                        $form->field($model, 'timestamp_start')->widget(DateTimePicker::classname(), [
                            'options' => [
                                'value' => (!$model->timestamp_start || $model->timestamp_start == "0000-00-00 00:00:00") ? date('Y-m-d H:i:s') : $model->timestamp_start,
                            ],
                            'pluginOptions' => [
                                'startDate' => date('Y-m-d H:i:s'),
                                'format' => 'yyyy-mm-dd hh:ii:ss',
                                'autoclose' => true,
                            ]
                        ]);
                        ?>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <h4>SEO</h4>
                <?= $form->field($model, 'meta_title'); ?>
                <?= $form->field($model, 'meta_keywords')->textarea(); ?>
                <?=
                $form->field($model, 'meta_description')->textarea();
                ?>
                     
                        <label>&nbsp;</label>
                        <?=
                            $form->field($model, 'is_active', ["template" => "{input}{label}"])
                            ->checkbox(["class" => "checkbox"], false);
                        ?>
                                   <div class='row'>
                    <div class="col-sm-4">
                         <?= $form->field($model, 'views'); ?>
                                </div>
            </div>
            </div>
        </div>
        <?=
        $form->field($model, 'text')->widget(CKEditor::className(), [
            'editorOptions' => ElFinder::ckeditorOptions(['elfinder-images', 'path' => '/dynamic/text/news/'.$model->id], []),
        ]);
        ?>
      
         
        <? ActiveForm::end(); ?>
          <div class="form-group">
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary dva']) ?>
                  </div>
    </div>
</div>
<div id='recycle' class='hidden'></div>
