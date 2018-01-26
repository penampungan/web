<?php

namespace frontend\backend\master\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\helpers\Json;
use yii\helpers\ArrayHelper;
use yii\web\Cookie;
use yii\web\Request;
use frontend\backend\master\models\Store;
use frontend\backend\master\models\StoreSearch;
use common\models\LocateKota;

class StoreController extends Controller
{
	 public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
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

	public function actionIndex()
    {
        $user = (empty(Yii::$app->user->identity->ACCESS_GROUP)) ? '' : Yii::$app->user->identity->ACCESS_GROUP;
        $model= new Store(['ACCESS_GROUP'=>$user]);
		$searchModel = new StoreSearch(['ACCESS_GROUP'=>$user]);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		// print_r($user);die();
		return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model'=>$model
        ]);
       //return 'asd';
    }
	
	/**
     * Displays a single Store model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
    	$model =  $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            //return $this->redirect(['view', 'id' => $model->ID]);
            return $this->redirect(['index']);
        } else {
           return $this->renderAjax('view', [
                'model' => $model,
            ]);
        }
    }
	
	/**
     * Displays a single Store model.
     * @param integer $id
     * @return mixed
     */
    public function actionReview($id)
    {
    	$model =  $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            //return $this->redirect(['view', 'id' => $model->ID]);
            return $this->redirect(['index']);
        } else {
           return $this->renderAjax('review', [
                'model' => $model,
            ]);
        }
    }
	public function actionDelete($id)
    {
        // $this->findModel($ID, $PRODUCT_ID, $YEAR_AT, $MONTH_AT)->delete();
        $model = $this->findModel($id);
        $model->STATUS ="3";
        $model->update();
        // Yii::$app->session->setFlash('error', "Data Berhasil dihapus");

        return $this->redirect(['index']);
    }
	/**
     * Depdrop Sub Kota - depedence Province
     * @author Piter
     * @since 1.1.0
     * @return mixed
     */
   public function actionKotaSub() {
    $out = [];
		if (isset($_POST['depdrop_parents'])) {
        $parents = $_POST['depdrop_parents'];
			if ($parents != null) {
				$id = $parents[0];
				$model = LocateKota::find()->asArray()->where(['PROVINCE_ID'=>$id])->all();														
														
				foreach ($model as $key => $value) {
				   $out[] = ['id'=>$value['CITY_ID'],'name'=> $value['CITY_NAME']];
			    } 
				echo json_encode(['output'=>$out, 'selected'=>'']);
				return;
           }
       }
       echo Json::encode(['output'=>'', 'selected'=>'']);
   }
   
	protected function findModel($id)
    {
        if (($model = Store::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
	
	public function actionRestore(){
       
        $user = (empty(Yii::$app->user->identity->ACCESS_GROUP)) ? '' : Yii::$app->user->identity->ACCESS_GROUP;
        // print_r($user);die();
        $modelPeriode = new Store();
        $datas = StoreSearch::find()->where(['and','ACCESS_GROUP='.$user.'','STATUS=3'])->all();
        $items = ArrayHelper::map($datas, 'STORE_ID', 'STORE_NM');
        // print_r($items);die();
		if ($modelPeriode->load(Yii::$app->request->post())) {
                $modelPeriode;
                // print_r($data);die();
            foreach ($modelPeriode['STATUS'] as $value) {
                $datas = Store::findOne(['STORE_ID' => $value]);
                $datas->STATUS="2";
                $datas->update();
            }
            
	// $id=Yii::$app->request->cookies;
    //         $storeId=$id->getValue('STORE_ID');
    //         print_r($storeId);die();
            $tes=Yii::$app->response->cookies->remove('STORE_ID');
            // print_r($tes);die();
            return $this->redirect('/master/store');
        }else {
            return $this->renderAjax('form_restore',[
				'modelPeriode' => $modelPeriode,
                'items'=>$items
			]);
	   }
	}

	public function actionExpandDetail() {
		$id=$_POST['expandRowKey'];		
		if($id==0){ 
			//== Detail Toko ==
			//$modelToko=Store::find()->where(['STORE_ID'=>])->all();
			return $this->renderPartial('_detailToko',[
				//'data'=>$_POST['expandRowKey'],
				//'modelToko'=>$modelToko
			]);
		}elseif($id==1){
			//== Detail Prodak==
			return $this->renderPartial('_detailProduk',['data'=>$_POST['expandRowKey']]);
		}elseif($id==2){
			//== Detail Pelanggan==
			return $this->renderPartial('_detailPelanggan',['data'=>$_POST['expandRowKey']]);
		}elseif($id==3){
			//== Detail Karyawan==
			return $this->renderPartial('_detailkaryawan',['data'=>$_POST['expandRowKey']]);
		}elseif($id==4){
			//== Detail User Operatioal==
			return $this->renderPartial('_detailUserOps',['data'=>$_POST['expandRowKey']]);
		}
		// if (isset($_POST['expandRowKey'])) {
			// $model = \app\models\Book::findOne($_POST['expandRowKey']);
			// return $this->renderPartial('_book-details', ['model'=>$model]);
		// } else {
			// return '<div class="alert alert-danger">No data found</div>';
		// }
		
		
	}
	public function actionKota() {
        $paramCari=Yii::$app->getRequest()->getQueryParam('prov');
        // print_r($paramCari);die();
        if (!empty($paramCari)) {
               $data= LocateKota::find()->where(['PROVINCE'=>$paramCari])->count();
               if ($data>0) {
                $access= LocateKota::find()->select('PROVINCE_ID,CITY_NAME,CITY_ID,PROVINCE')->where(['PROVINCE'=>$paramCari])->all();
                
                echo "<option value=''>Cari Kota</option>";
                foreach($access as $accesss){
                    echo "<option value='".$accesss->CITY_NAME."'>".$accesss->CITY_NAME."</option>";
                }
                return;
               } else {
    
                echo "<option>Cari Kota</option>";
                   echo "<option value=''> - </option>";
                   return;
               }
        }
    }
}
