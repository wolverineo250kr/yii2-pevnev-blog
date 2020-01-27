<?
	use wolverineo250kr\blog\modules\frontend\assets\PevnevBlogAsset;
	use yii\helpers\Html;
	use yii\helpers\Url;
	
$this->title                   = ($this->title) ? $this->title : $model->name;
$this->params['header']        = ($this->params['header']) ? $this->params['header'] : $model->name;
$this->params['breadcrumbs'][] = ["label" => "Блог", "url" => "/blog"];
$this->params['breadcrumbs'][] = $this->params['header'];

PevnevBlogAsset::register($this);
?>

<div class="content">
    <h1 class="h2 big-head"><?= $this->params['header'] ?></h1>
    <div class="row">        
        <div class="col-sm-8 right-menu">
			<div class="row i-hope-line">
			        <div class="col-xs-12 col-sm-4 ">
			                <i class="fa fa-2x fa-clock-o" aria-hidden="true"></i><span>На чтение <b><?=$readTime?></b></span> 
			                    </div>
			                    		          <div class="col-xs-12 col-sm-4 ">
			                 <i class="fa fa-2x fa-eye" aria-hidden="true"></i><span>Просмотров <b><?=$model->views?></b></span>  
			                    </div>
			                    		         <div class="col-xs-12 col-sm-4 ">
			                    		              <i class="fa fa-2x fa-calendar" aria-hidden="true"></i>
			          <span>Опубликовано<br/><b><?= Yii::$app->formatter->asDate($model->timestamp_start, 'd MMMM yyyy'); ?></b></span>
			                    </div>
			      </div>
			      
			      	<div class="row">
			        <div class="col-sm-12">
			              <div class="line-of-hope"></div>
			                   </div>
			                        </div>
			                       <div class="content-power">  
             <?= $model->text ?> 
                 </div>
        </div>
            <div class="col-sm-4 left-menu" >
                  <div class="menushka">
                        <span class='interesno'>Интересное</span>
                  <?foreach($recomended as $record):?> 
                  <a href="<?=Url::toRoute(['/blog/'.$record->url])?>" class="group-block">
                         <div class='block-image' style="background-image:url(<?=$record->getSrc(true)?>);">
							 
                               </div>
                        
					<div class="info-block">
				<div class="category"><?=$record->blogGroup->name?></div>
                        	<div class="title"><?=$record->name?></div>
                        		<div class="views"><i class="fa fa-eye" aria-hidden="true"></i>&nbsp;<?=$record->views?></div>
                        	  </div>
                  </a>
                <?endforeach;?>
                </div>
                   </div>
    </div>

    <span class="hidden" itemprop="datePublished"><?= explode(' ', $model->timestamp_start)[0] ?></span>
    <span class="hidden" itemprop="dateModified"><?= explode(' ', $model->timestamp_update)[0] ?></span>
    <span class="hidden" itemprop="author"><?= Yii::$app->name ?></span>
    <span class="hidden" itemprop="mainEntityOfPage"><?= Yii::$app->request->absoluteUrl ?></span>
    <div  class="hidden" itemtype="https://schema.org/Organization" itemscope="itemscope" itemprop="publisher">
        <link itemprop="url" href="<?= $domain ?>">
        <span itemprop="name"><?= Yii::$app->name ?></span>
        <span itemprop="address"><?= isset(Yii::$app->geography->mainAddress["value"]) ? Yii::$app->geography->mainAddress["value"] : 'ул. 8 Марта, 269' ?></span>
        <span itemprop="telephone"><?= isset(Yii::$app->geography->phone->value) ? Yii::$app->geography->phone->value : '8 800 234-59-60' ?></span>
        <span itemprop="logo" itemscope itemtype="https://schema.org/ImageObject">
            <span href='<?= $image ?>' itemprop="thumbnail"><?= $image ?></span>
            <span href='<?= $image ?>' itemprop="url"><?= $image ?></span>
            <meta itemprop="width" content="750">
            <meta itemprop="height" content="291">
        </span>
        <a itemprop="url" href="<?= $domain ?>" target="_blank" itemprop="sameAs" rel="noopener"><?= Yii::$app->name ?></a>
    </div>
    <div class='hidden' itemprop="image" itemscope itemtype="http://schema.org/ImageObject">
        <p itemprop="caption"><?= $this->params['header'] ?></p>
        <span href='<?= $image ?>' itemprop="thumbnail"><?= $image ?></span>
        <span href='<?= $image ?>' itemprop="url"><?= $image ?></span>
    </div>
</div> 
 
