<?php

namespace wolverineo250kr\modules\blog\controllers;

use Yii;
use yii\helpers\Url;
use yii\web\Response; 
use yii\web\Controller;
use yii\widgets\ActiveForm; 
use yii\filters\VerbFilter;
use yii\filters\AccessControl;  
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;  
use wolverineo250kr\modules\blog\models\Blog;
use wolverineo250kr\modules\blog\models\BlogGroup;
use wolverineo250kr\modules\blog\models\form\BlogForm;
use wolverineo250kr\modules\blog\models\search\BlogSearch;

/**
 *  
 */
class DefaultController extends Controller
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
	
        return parent::beforeAction($action);
    }
	
	    public function actionIndex()
    {
        $cookiePanel  = (isset(Yii::$app->request->cookies["panel-action"])) ? Yii::$app->request->cookies["panel-action"]->value : NULL;
        $searchModel  = new BlogSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $modelForm    = new BlogForm();

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
            $model = new BlogForm();
            $model->save(false);
            return $this->redirect(Url::toRoute([Yii::$app->controller->id.'/view', 'id' => $model->id]));
        }
         
        $model = BlogForm::findOne(['id' => $id]);
        
        
        if ($model && $model->load(Yii::$app->request->post())) {
               
                       $groupActiveCheck = BlogGroup::find()
        ->where(['id' => $model->blog_group_id])
        ->one();
        
        $model->is_group_active = $groupActiveCheck->is_active;
         
        if($model->save()){    
            Yii::$app->getSession()->setFlash('success', 'Элемент сохранен.');
            $this->clearCache($model->id);
        }
        }

        if (!$model) {
            throw new NotFoundHttpException();
        }
        
        $groups = BlogGroup::find()
        ->where(['is_active' => 1])
        ->andWhere(['!=', 'id', 0])
        ->all();

        return $this->render('view', [
                'model' => $model,
                'groups' => $groups
        ]);
    }

       public function actionDelete()
    {
        if (!Yii::$app->request->isAjax) {
            throw new NotFoundHttpException();
        }

        Yii::$app->response->format = Response::FORMAT_JSON;
        $selectModels               = Yii::$app->request->post('gridSelected');

        foreach ($selectModels as $id) {
            $model = Blog::findOne(['id' => (int) $id]);
            $model->delete();
            $this->clearCache($id);
        }
        Yii::$app->getSession()->setFlash('danger', 'Выбранные элементы удалены.');
        return true;
    }

    private function clearCache(int $id)
    {
        $model = Blog::findOne(["id" => $id]);
        if ($model) {
            Yii::$app->cache->delete('news-'.$model->url);
            Yii::$app->cache->delete('news-site-index');
        }
    }
    
}