<?php

namespace wolverineo250kr\modules\blog\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use common\models\Blocks; 
use yii\web\NotFoundHttpException; 
use common\models\Team;
use backend\models\BlockDataForm;
use common\models\Social; 
use common\models\ActionSlider;
use yii\widgets\ActiveForm; 
use yii\web\Response;
use common\models\SiteAvailable;
use yii\data\ActiveDataProvider;
use common\models\PriceList; 
 
 use common\models\blog\Blog;
use common\models\blog\BlogGroup;
use common\models\blog\form\BlogGroupForm;
use common\models\blog\search\BlogGroupSearch;

/**
 * BlogGroupController Controller
 */
class BlogGroupController extends Controller
{

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => [
                            'view',
                            'index', 
                        ],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
                'layout' => false,
            ],
        ];
    }

    public function beforeAction($action)
    {
		    		  
	             $SxGeo = new \common\extensions\sypexgeo\Sypexgeo();
            $geo   = $SxGeo->get();
      
         if(!isset($geo["country"]["iso"]) || empty($geo["country"]["iso"])){
                        Yii::$app->response->statusCode = 500;
                       throw new \yii\web\ServerErrorHttpException();
         } 
      
           if($geo["country"]["iso"] != 'ru' && $geo["city"]["id"] != 1486209 ){
                Yii::$app->response->statusCode = 500;
                      throw new \yii\web\ServerErrorHttpException();
           }
           
           
        if (!Yii::$app->user->isGuest) {

            $orders = \common\models\Request::find()
                ->where(['new' => 1])
                ->count();

            $siteStatus = SiteAvailable::findOne(['id' => 1]);

            Yii::$app->params['newOrders']  = $orders;
            Yii::$app->params['siteStatus'] = $siteStatus->status;


            Yii::$app->params['blocks'] = Blocks::findAll(['is_active' => Blocks::ACTIVE]);
        }

        return parent::beforeAction($action);
    }
	
	    public function actionIndex()
    {
        $cookiePanel  = (isset(Yii::$app->request->cookies["panel-action"])) ? Yii::$app->request->cookies["panel-action"]->value : NULL;
        $searchModel  = new BlogGroupSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $modelForm    = new BlogGroupForm();

        return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'modelForm' => $modelForm,
                'cookiePanel' => $cookiePanel,
        ]);
    }

 
        public function actionView(int $id = 0)
    {
        if (!$id) {
            $model = new BlogGroupForm();
            $model->save(false);
            return $this->redirect(Url::toRoute([Yii::$app->controller->id.'/view', 'id' => $model->id]));
        }

        $model = BlogGroupForm::findOne(['id' => $id]);
        if ($model && $model->load(Yii::$app->request->post()) && $model->save()) {
              $records = Blog::find()
              ->where(['blog_group_id' => $model->id])
              ->all();
              foreach($records as $record){
                    $record->is_group_active = $model->is_active;
                    $record->save();
              }
            Yii::$app->getSession()->setFlash('success', 'Элемент сохранен.');
            $this->clearCache($model->id);
        }

        if (!$model) {
            throw new NotFoundHttpException();
        }

        return $this->render('view', [
                'model' => $model,
        ]);
    }
    
           private function actionDeleteItems(int $id)
    {
            $items = Blog::find()
            ->where(['blog_group_id' =>$id])
            ->all();
            
            foreach($items as $item){
                  $item->delete();
            }
    }
    
       public function actionDelete()
    {
        if (!Yii::$app->request->isAjax) {
            throw new NotFoundHttpException();
        }

        Yii::$app->response->format = Response::FORMAT_JSON;
        $selectModels               = Yii::$app->request->post('gridSelected');

        foreach ($selectModels as $id) {
            $model = BlogGroup::findOne(['id' => (int) $id]);
            $model->delete();
            $this->clearCache($id);
        }
        Yii::$app->getSession()->setFlash('danger', 'Выбранные элементы удалены.');
        return true;
    }

    private function clearCache(int $id)
    {
        $model = BlogGroup::findOne(["id" => $id]);
        if ($model) {
           // Yii::$app->cache->delete('blog-group-'.$model->url); 
        }
    }
    
}