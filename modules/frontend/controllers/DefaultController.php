<?php

namespace wolverineo250kr\blog\modules\frontend\controllers;

use Yii;
use yii\helpers\Url;
use yii\data\Pagination;
use yii\helpers\ArrayHelper;
use wolverineo250kr\helpers\domain\DomainHelper; 
use wolverineo250kr\blog\models\Blog;
use wolverineo250kr\blog\models\BlogGroup;

class DefaultController extends \yii\web\Controller
{
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }
        public function beforeAction($action)
    {

        return parent::beforeAction($action);
    }
	
    public function actionIndex()
    {
        $groupActive = 0;

        if (Yii::$app->request->isAjax) {
            $groupActive = (int) Yii::$app->request->post('groupActive');
        }

        $blogGroup = BlogGroup::find()
            ->where([BlogGroup::tableName().'.is_active' => BlogGroup::ACTIVE])
            ->with(['newsToGroup'])
            ->all();

        $pagesCountQuery = Blog::find();        
        $pagesCountQuery->where(['is_active' => Blog::ACTIVE]);        
          $pagesCountQuery->andWhere(['<', 'timestamp_start', date('Y-m-d H:i:s')]);
        if($groupActive > 0){
                       $pagesCountQuery->andWhere(['blog_group_id' => $groupActive]);
                   }
        $pagesCount = $pagesCountQuery->count();
 
        $pageSize = 12;

        $query = Blog::find();

        $pages = new Pagination([
            'totalCount' => $query->count(),
            'pageSize' => $pageSize,
            'validatePage' => false
        ]);

       $query->offset($pages->offset);
        $query->where(['is_active' => Blog::ACTIVE]);        
          $query->andWhere(['<', 'timestamp_start', date('Y-m-d H:i:s')]);
              $query->andWhere(['is_group_active' => 1]);
        if($groupActive > 0){
            $query->andWhere(['blog_group_id' => $groupActive]);
       }
            $query->orderBy(['timestamp_start' => SORT_DESC]);
            $query->limit($pages->limit); 

        if (Yii::$app->request->isAjax) {
        $posts =  $query->all();
		
          if($groupActive > 0){
       shuffle($posts); // It makes user expirience more interesting
}
 
        return $this->renderPartial('_index', [
            'pages' => $pages,
            'models' => $posts,
            'pagesCount' => $pagesCount,
        ]);
		
        }
		
		      return $this->render('index', [
                'blogGroup' => $blogGroup,
                'pages' => $pages,
                'pagesCount' => $pagesCount,
                'pageSize' => $pageSize
            ]);
    }
 
    public function actionView(string $url)
    {
        $model = Blog::find()
         ->where(['url' => $url])
                ->andWhere(['is_active' => Blog::ACTIVE]) 
  ->one();
 
          if (!$model) {
            throw new \yii\web\NotFoundHttpException();
        }
        
           if ($model->timestamp_start >= date('Y-m-d H:i:s')) {
         throw new \yii\web\NotFoundHttpException();
        }
        
$isUnique = Yii::$app->cache->get($url.Yii::$app->session->id);

      if(!$isUnique && $model){
          $model->views += 1;
              $model->save();
            
            Yii::$app->cache->set($url.Yii::$app->session->id, $url.Yii::$app->session->id);
      }

$readTime = $model->countReadTime($model->text);

      $recomended =  Blog::find() 
          ->where(['NOT',['url'=>$url]])
          ->with(['blogGroup'])
          ->andWhere(['<', 'timestamp_start', date('Y-m-d H:i:s')])
      ->andWhere(['is_active' => Blog::ACTIVE])
        ->orderBy('RAND()')
    ->limit(4)
    ->all();

        $domain = DomainHelper::getScheme().'://'.DomainHelper::getBase();

$image = ''; // Path to your site logo
        $imageModel = $domain.$model->getSrc(false);
 
        $image      = ($imageModel) ? $imageModel : $image;

      $this->actionInjectMetaTags($model, $image, $url);
      
        return $this->render('view', [
              'recomended' => $recomended,
              'readTime' => $readTime,
                'domain' => $domain,
                'model' => $model,
                'image' => $image
        ]);
    }
    
            private function actionInjectMetaTags($model, $image, $url)
    {
          
       
                             Yii::$app->view->registerMetaTag([
        'name' => "pinterest-rich-pin",
        'content' => "true"
        ]); 
        
                      Yii::$app->view->registerMetaTag([
        'name' => "og:type",
        'content' => "article"
        ]); 
          
                      Yii::$app->view->registerMetaTag([
        'name' => "og:title",
        'content' => ($model->meta_title?$model->meta_title:$model->name)." - " . DomainHelper::getBase()
        ]); 
                Yii::$app->view->registerMetaTag([
        'name' => "og:description",
        'content' => $model->meta_description
         ]);
         
                     Yii::$app->view->registerMetaTag([
        'name' => 'og:image',
        'content' => $image
        ]);
          
                  Yii::$app->view->registerMetaTag([
        'name' => 'og:url',
        'content' => $domain.Url::toRoute(['/blog/'.$url])
        ]);
              Yii::$app->view->registerMetaTag([
        'name' => 'og:site_name',
        'content' => DomainHelper::getBase()
        ]);
  
                Yii::$app->view->registerMetaTag([
        'name' => 'article:published_time',
        'content' => date(DATE_W3C, strtotime($model->timestamp_start))
        ]);
        
                Yii::$app->view->registerMetaTag([
        'name' => 'article:author',
        'content' =>DomainHelper::getBase().' FASHIONCROCHET'
        ]);      
    }
}
