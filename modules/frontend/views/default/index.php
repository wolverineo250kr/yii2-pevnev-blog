<?

use wolverineo250kr\blog\modules\frontend\assets\PevnevBlogGroupAsset;
use wolverineo250kr\helpers\TextHelper;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = ($this->title) ? $this->title : "Блог";
$this->params['header'] = ($this->params['header']) ? $this->params['header'] : $this->title;
$this->params['breadcrumbs'][] = $this->params['header'];

PevnevBlogGroupAsset::register($this);
?>
<div class="content">                  
    <h3 class='title__h3 set--bold'><?= $this->params['header'] ?></h3>
    <div class="row">
        <div class="col-sm-2 group-line left-menu">  
            <a href='#' class='hidden-sm hidden-md hidden-lg anti-caret buttonShowMobileMenu right'><i class="fa fa-4x fa-caret-left" aria-hidden="true"></i></a>
            <a href='#' class='hidden-sm hidden-md hidden-lg anti-caret buttonShowMobileMenu left hidden'><i class="fa fa-4x fa-caret-right" aria-hidden="true"></i></a>
            <div class="row">
                <? $q = 0 ?>
                <? $i = 0 ?>
                <? foreach ($newsGroup as $indexGroup => $group): ?> 
                    <? if (!empty($group->newsToGroup) || $group->id == 0): ?>
                        <div class="col-sm-12">
                            <div class="group-block <?= $q == 0 ? 'active' : '' ?>" data-group-id="<?= $group->id ?>">
                                <?= $group->name ?>  
                            </div>
                        </div> 
                        <? $q++ ?>
                        <? $i++ ?>
                    <? endif; ?>
                <? endforeach; ?>
            </div>  
        </div>  
        <div class="col-sm-10 right-menu">  
            <div id='error' class='row' style='display:none;'>
                <div class="col-sm-12 text-center">  
                    <span>Произошла ошибка</span>
                </div>
            </div>
            <div id='spin-day' class='row' style='display:none;'>
                <div class="col-sm-12 text-center">  
                    <i class="fa fa-4x fa-spin fa-spinner" aria-hidden="true"></i>
                </div>
            </div>
            <div class="row separator">
            </div>
            <div class="row">
                <div class="bolshoy-i-tolstiy col-sm-offset-3 col-sm-6 hidden">
  <?=
                    Html::a('Загрузить еще ...', Url::to('/'.Yii::$app->controller->module->defaultRoute.'?page=1&per-page=' . $pageSize), [
                        'class' => 'text-uppercase btn btn-primary',
                        'data-fact' => 1,
                        'data-all' => $pagesCount,
                        'data-page-size' => $pageSize,
                        'data-left' => $pagesCount,
                        'data-route' => Yii::$app->controller->module->defaultRoute,	
                        'data-loading-text' => 'Загрузка <i class="fa fa-circle-o-notch fa-spin"></i>',
                        'data-success-text' => 'Загрузить еще ...',
                        'data-error-text' => 'Произошла ошибка <i class="fa fa-warning"></i>',
                        'id' => 'moreGiveMemore'
                    ])
                    ?>
                </div>
            </div>       
        </div>   
    </div>
</div>

