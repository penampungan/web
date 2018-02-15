<?php

namespace frontend\backend\sistem\controllers;

use Yii;
use frontend\backend\sistem\models\User;
use frontend\backend\sistem\models\UserProfile;
use frontend\backend\sistem\models\UserProfileSearch;
use frontend\backend\sistem\models\UserImage;
use frontend\backend\sistem\models\Store;
use frontend\backend\sistem\models\StoreSearch;
use frontend\backend\sistem\models\StoreKasir;
use frontend\backend\sistem\models\StoreKasirSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UserProfileController implements the CRUD actions for UserProfile model.
 */
class UserProfileController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }
    public function beforeAction($action){
        $modulIndentify=4; //OUTLET
       // Check only when the user is logged in.
       // Author piter Novian [ptr.nov@gmail.com].
       if (!Yii::$app->user->isGuest){
           if (Yii::$app->session['userSessionTimeout']< time() ) {
               // timeout
               Yii::$app->user->logout();
               return $this->goHome(); 
           } else {	
               //add Session.
               Yii::$app->session->set('userSessionTimeout', time() + Yii::$app->params['sessionTimeoutSeconds']);
               //check validation [access/url].
               $checkAccess=Yii::$app->getUserOpt->UserMenuPermission($modulIndentify);
               if($checkAccess['modulMenu']['MODUL_STS']==0 OR $checkAccess['ModulPermission']['STATUS']==0){				
                   $this->redirect(array('/site/alert'));
               }else{
                   if($checkAccess['PageViewUrl']==true){						
                       return true;
                   }else{
                       $this->redirect(array('/site/alert'));
                   }					
               }			 
           }
       }else{
           Yii::$app->user->logout();
           return $this->goHome(); 
       }
   }
    /**
     * Lists all UserProfile models.
     * @return mixed
     */
    public function actionIndex()
    {
        $user = (empty(Yii::$app->user->identity->ACCESS_ID)) ? '' : Yii::$app->user->identity->ACCESS_ID;
        
        $dataProvider = UserProfileSearch::find()->where(['ACCESS_ID'=>$user])->one();
        $dataProviderimage = UserImage::find()->where(['ACCESS_ID'=>$user])->one();
        if (empty($dataProviderimage)) {
            $dataProviderimage = new UserImage;
        } 
        $searchModelstore = new StoreSearch(['ACCESS_GROUP'=>$user]);
        $dataProviderstore = $searchModelstore->search(Yii::$app->request->queryParams);
        
        $paramCari=Yii::$app->getRequest()->getQueryParam('storeid');
        // print_r($paramCari);die();
        if ($paramCari==''){
            $modelGrp =StoreKasirSearch::find()->where(['ACCESS_GROUP'=>$user])->orderBy(['STORE_ID'=>SORT_ASC])->one();
            $searchModelKasir = new StoreKasirSearch(['STORE_ID'=>$modelGrp->STORE_ID]);
            $dataProviderKasir = $searchModelKasir->search(Yii::$app->request->queryParams);
        }else{
            $searchModelKasir = new StoreKasirSearch(['ACCESS_GROUP'=>$user,'KASIR_ID'=>$paramCari]);
            $dataProviderKasir = $searchModelKasir->search(Yii::$app->request->queryParams);
        }
        
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModelstore' => $searchModelstore,
            'dataProviderstore' => $dataProviderstore,
            'searchModelKasir' => $searchModelKasir,
            'dataProviderKasir' => $dataProviderKasir,
            'dataProviderimage'=>$dataProviderimage
        ]);
    }

    /**
     * Displays a single UserProfile model.
     * @param string $ID
     * @param string $ACCESS_ID
     * @param integer $YEAR_AT
     * @param integer $MONTH_AT
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($ID, $ACCESS_ID, $YEAR_AT, $MONTH_AT)
    {
        return $this->render('view', [
            'model' => $this->findModel($ID, $ACCESS_ID, $YEAR_AT, $MONTH_AT),
        ]);
    }

    /**
     * Creates a new UserProfile model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new UserProfile();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'ID' => $model->ID, 'ACCESS_ID' => $model->ACCESS_ID, 'YEAR_AT' => $model->YEAR_AT, 'MONTH_AT' => $model->MONTH_AT]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing UserProfile model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $ID
     * @param string $ACCESS_ID
     * @param integer $YEAR_AT
     * @param integer $MONTH_AT
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($ACCESS_ID)
    {
        $model = $this->findModel($ACCESS_ID);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', "Data Berhasil dirubah");
            return $this->redirect(['index']);      
        }

        return $this->renderAjax('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing UserProfile model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $ID
     * @param string $ACCESS_ID
     * @param integer $YEAR_AT
     * @param integer $MONTH_AT
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($ACCESS_ID)
    {
        $this->findModel($ACCESS_ID)->delete();

        return $this->redirect(['index']);
    }
    
    public function actionChange($ACCESS_ID)
    {
        $model =  User::findOne(['ACCESS_ID' => $ACCESS_ID]);
        if ($model->load(Yii::$app->request->post())) {
            $model->Password = $model->newPassword;
            if ($model->save(false)) {
                Yii::$app->session->setFlash('success', "Change Password Berhasil");
                return $this->redirect(['index']);   
            }
        return $this->redirect(['index']);
        }

        return $this->renderAjax('change', [
            'model' => $model,
        ]);
    }
    /**
     * Finds the UserProfile model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $ID
     * @param string $ACCESS_ID
     * @param integer $YEAR_AT
     * @param integer $MONTH_AT
     * @return UserProfile the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($ACCESS_ID)
    {
        if (($model = UserProfile::findOne(['ACCESS_ID' => $ACCESS_ID])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}