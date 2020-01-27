<?

use wolverineo250kr\helpers\text\TextHelper;
use yii\helpers\Html;
use yii\helpers\Url;

 
?><? $countModels = count($models); ?><? foreach ($models as $index => $model): ?><? if (($index + 1) % 3 == 1): ?><div class="row separator" style="display:none;"><? endif; ?><div class="col-xs-12 col-sm-6 col-md-4 ">
    <a href='<?= Url::toRoute(['/blog/default/view', 'url' => $model->url]) ?>' class='news-link'>
        <div class="news-box">
            <div class="image">
                <? $imageSrc = $model->getSrc(false) ?>
                <? if ($imageSrc): ?>
                    <?=
                    Html::img($imageSrc, [
                        'alt' => $model->name,
                        'title' => $model->name,
                    ])
                    ?>
                <? endif; ?>
            </div>

            <h4><?= TextHelper::cut($model->name, 35, '...') ?></h4>
            <div class="text-announcement">
                <? if (strip_tags($model->text_announcement)): ?>
                    <?= $model->text_announcement; ?>
                <? elseif ($model->text): ?>
                    <?= TextHelper::cut($model->text, 113, '...') ?>
                <? endif; ?>
            </div>
			<div class="views">
                <i class="fa fa-eye" aria-hidden="true"></i>&nbsp;<?= $model->views ?>
            </div>
            <div class="date">
                <?= Yii::$app->formatter->asDate($model->timestamp_start, 'd MMMM yyyy'); ?>
            </div>

        </div>
    </a>
    </div>
	<? if (($index + 1) % 3 == 0 || ($index + 1) == $countModels): ?>
	<span class="hidden dobro"><?=$pagesCount?></span>
	</div>
	<? endif; ?>
	<? endforeach; ?>
