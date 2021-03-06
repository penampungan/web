<?php

namespace frontend\backend\inventory\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;
use yii\data\ArrayDataProvider;
use yii\base\DynamicModel;
use yii\web\Response;
use app\models\UploadForm;
use yii\web\UploadedFile;
use yii\base\Model;
use frontend\backend\inventory\models\StockOutSearch;
use frontend\backend\inventory\models\ProductStockClosing;
use frontend\backend\inventory\models\ProductStockClosingSearch;
use ptrnov\postman4excel\Postman4ExcelBehavior;

class StockOpnameController extends Controller
{
	public function behaviors()
    {
        return [
			/*EXCEl IMPORT*/
			'export4excel' => [
				'class' => Postman4ExcelBehavior::className(),
				//'downloadPath'=>Yii::getAlias('@lukisongroup').'/cronjob/',
				//'downloadPath'=>'/var/www/backup/ExternalData/',
				'widgetType'=>'download',
			], 
            // 'verbs' => [
                // 'class' => VerbFilter::className(),
                // 'actions' => [
                    // 'delete' => ['POST'],
                // ],
            // ],
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
		$paramCari=date('Y-m-d');
		//PencarianIndex
		$modelPeriode = new \yii\base\DynamicModel([
			'TAHUNBULAN','TAHUN','BULAN'
		]);		
		$modelPeriode->addRule(['TAHUNBULAN'], 'required')
         ->addRule(['TAHUNBULAN','TAHUN','BULAN'], 'safe');			
		if ($modelPeriode->load(Yii::$app->request->post())) {
			$hsl = \Yii::$app->request->post();	
			$paramCari=$hsl['DynamicModel']['TAHUNBULAN']."-01";
		};		
		
		//PUBLIC PARAMS	
		$cari=[
			'TAHUN'=>date('Y', strtotime($paramCari)),
			'BULAN'=>date('m', strtotime($paramCari)),
		
		];	
		
		//DINAMIK MODEL PARAMS
		// $searchModel = new StockOutSearch($cari);
        // $dataProvider = $searchModel->searchOpname(Yii::$app->request->queryParams);
		
		//DINAMIK MODEL PARAMS
		$searchModel = new ProductStockClosingSearch($cari);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		
		// print_r($dataProvider->getModels());
		//LOAD DEFAULT INDEX
		return $this->render('index', [
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
			'paramCari'=>$paramCari
		]);	       
    }
	
	/**====================================
	* PENCARIAN INDEX VIEW
	* @return mixed
	* @author piter [ptr.nov@gmail.com]
	* @since 1.2
	* ====================================
	*/
	public function actionPencarianIndex(){
		$modelPeriode = new \yii\base\DynamicModel([
			'TAHUNBULAN','TAHUN','BULAN'
		]);		
		$modelPeriode->addRule(['TAHUNBULAN'], 'required')
         ->addRule(['TAHUNBULAN','TAHUN','BULAN'], 'safe');
		 
		if (!$modelPeriode->load(Yii::$app->request->post())) {
			return $this->renderAjax('form_cari',[
				'modelPeriode' => $modelPeriode
			]);
		}
	}
	
	/**====================================
	* CLOSING STOCK - RUNNING
	* @return mixed
	* @author piter [ptr.nov@gmail.com]
	* @since 1.2
	* ====================================
	*/
	public function actionClosingStock($paramcari){

		if (!empty($paramcari)=='1') {
			// print_r($paramcari);die();
			//PUBLIC PARAMS	
			$cari=['thn'=>$paramcari];	
			
			//DINAMIK MODEL PARAMS
			$searchModel = new StockOutSearch($cari);
			$dataProvider = $searchModel->searchOpname(Yii::$app->request->queryParams);
			//LOAD DEFAULT INDEX
			return $this->render('index', [
				'searchModel' => $searchModel,
				'dataProvider' => $dataProvider,
				'paramCari'=>$paramcari
			]);
		} else {
			
			Yii::$app->session->setFlash('error', "Tanggal Belum diinputkan");
			return $this->redirect(['index']);
		}
		
	}
	
	/**====================================
	* DOWNLOAD OPNAME - FORMAT
	* @return mixed
	* @author piter [ptr.nov@gmail.com]
	* @since 1.2
	* ====================================
	*/
	public function actionDownload($paramcari){
		
		if (!empty($paramcari)=='1') {
			//PUBLIC PARAMS	
		$date = explode('-',$paramcari);
		$searchModeldownload = new ProductStockClosingSearch(['TAHUN'=>$date['0'],'BULAN'=>$date['1']]);
        $dataProviderdownload = $searchModeldownload->searchDownload(Yii::$app->request->queryParams);
		$dinamikFielddownload=$dataProviderdownload->allModels;
		
		$excel_dataProdukStokdownload = Postman4ExcelBehavior::excelDataFormat($dinamikFielddownload);
        $excel_titleProdukStokdownload = $excel_dataProdukStokdownload['excel_title'];
        $excel_ceilsProdukStokdownload = $excel_dataProdukStokdownload['excel_ceils'];

		
		// print_r(!empty($excel_titleProdukStokdownload));
		// die();
		$user = (empty(Yii::$app->user->identity->ACCESS_GROUP)) ? '' : Yii::$app->user->identity->ACCESS_GROUP;
		
		if (!empty($excel_titleProdukStokdownload)) {
			
		//DATA IMPORT
		$excel_contentdownload = [
			[
				'sheet_name' => 'Produk-Stok',
                'sheet_title' => $excel_titleProdukStokdownload,
				'ceils' => $excel_ceilsProdukStokdownload,
				'freezePane' => 'A2',
				'columnGroup'=>false,
				'autoSize'=>false,
				'unlockCell'=>'D,D,'.(count($excel_ceilsProdukStokdownload)+1).'',
				'headerColor' => Postman4ExcelBehavior::getCssClass("header"),
                'headerStyle'=>[	
					[
						'UNIX_BULAN_ID ' =>['font-size'=>'9','width'=>'15','valign'=>'center','align'=>'center'],
						'STORE_NM' =>['font-size'=>'9','width'=>'15','valign'=>'center','align'=>'center'],
						'PRODUCT_ID' =>['font-size'=>'9','width'=>'17','valign'=>'center','align'=>'center'],
						'STOCK_INPUT_ACTUAL' =>['font-size'=>'9','width'=>'7','valign'=>'center','align'=>'center'],
						
					]						
				],
				'contentStyle'=>[
					[						
						'UNIX_BULAN_ID ' =>['font-size'=>'9','width'=>'15','valign'=>'center','align'=>'center'],
						'STORE_NM' =>['font-size'=>'9','width'=>'15','valign'=>'center','align'=>'center'],
						'PRODUCT_ID' =>['font-size'=>'9','width'=>'17','valign'=>'center','align'=>'center'],
						'STOCK_INPUT_ACTUAL' =>['font-size'=>'9','width'=>'7','valign'=>'center','align'=>'center'],
						
					]
				],
               'oddCssClass' => Postman4ExcelBehavior::getCssClass("odd"),
               'evenCssClass' => Postman4ExcelBehavior::getCssClass("even"),
			],
		];
		// print_r($excel_content);
		// die();
		$excel_filedownload = "Stock Opname After Closing ".$user."";
		$this->export4excel($excel_contentdownload, $excel_filedownload,0);
		} else {
			Yii::$app->session->setFlash('error', "Tidak ada data pada tanggal ini");
			return $this->redirect(['index']);
		}		
		} else {			
			Yii::$app->session->setFlash('error', "Tanggal Belum diinputkan");
			return $this->redirect(['index']);
		}
	}
	
	/**====================================
	* UPLOAD OPNAME - FORMAT
	* @return mixed
	* @author piter [ptr.nov@gmail.com]
	* @since 1.2
	* ====================================
	*/
	public function actionUploadFile(){
		$modelPeriode = new StockOutSearch;
		 
		if ($modelPeriode->load(Yii::$app->request->post())) {
			$modelPeriode->uploadExport = UploadedFile::getInstance($modelPeriode, 'uploadExport');
			// print_r($fileType);die();	
            if ($modelPeriode->upload()) {			
				$file='uploads/'.$modelPeriode->uploadExport->baseName.'.'.$modelPeriode->uploadExport->extension.'';
				try{
					$FileType = \PHPExcel_IOFactory::identify($file);
					$objReader = \PHPExcel_IOFactory::createReader($FileType);
					$objPHPExcel = $objReader->load($file);
				}catch(Exception $e){
					die('error');
				}
				$sheet = $objPHPExcel->getSheet(0);
				$highestRow = $sheet->getHighestRow();
				$highestColumn=$sheet->getHighestColumn();
				// print_r($highestRow);die();
				for($row = 1; $row <= $highestRow; $row++){
					$rowData = $sheet->rangeToArray('A'.$row.':'.$highestColumn.$row,NULL,TRUE,FALSE);

					if ($row==1) {
						continue;
					}
					// print_r($rowData[0][3]);die();
					if (empty($rowData[0][0])) {
						unlink('uploads/'.$modelPeriode->uploadExport->baseName.'.'.$modelPeriode->uploadExport->extension);
						Yii::$app->session->setFlash('error', "UNIX_BULAN_ID Kosong");
                        return $this->redirect(['index']);
					} else {
						if(is_numeric($rowData[0][3])){
						$model = ProductStockClosingSearch::find()->where(['UNIX_BULAN_ID'=>$rowData[0][0]])->one();
						$model->STOCK_INPUT_ACTUAL = $rowData[0][3];
						$model->update();
						}else{
							$dataserror[]=['UNIX_BULAN_ID'=>$rowData[0][0],'STORE_NM'=> $rowData[0][1],'PRODUCT_NM'=> $rowData[0][2],'STOCK_INPUT_ACTUAL'=> $rowData[0][3]];
						}
					}
					// print_r($model->getErrors());
					// print_r($dataserror);
				}
				// print_r($dataserror);die();
				// foreach ($dataserror as $key => $value) {
				// 	# code...
				// }
				$dataProvider = new ArrayDataProvider([
					'allModels'=>$dataserror
				]);
				// print_r($dataProvider);die();
				if(!empty($dataProvider)){
					unlink('uploads/'.$modelPeriode->uploadExport->baseName.'.'.$modelPeriode->uploadExport->extension);
					return $this->render('modal_error',[
						'dataProvider' => $dataProvider
					]);
				// print_r($dataserror);die();
				}else{
				unlink('uploads/'.$modelPeriode->uploadExport->baseName.'.'.$modelPeriode->uploadExport->extension);
				return $this->redirect(['index']);
				}
            }
		}else{
			return $this->renderAjax('form_upload',[
				'modelPeriode' => $modelPeriode
			]);
		}
	}
	public function actionBatchUpdate()
{
    // $sourceModel = ProductStockClosingSearch::find()->indexBy('UNIX_BULAN_ID')->all();
	// $sourceModel = (Yii::$app->request->isPost);
    // $model  = new ProductStockClosingSearch;
	// $model->load(Yii::$app->request->post());
	$sourceModel = new ProductStockClosingSearch();
	if ($sourceModel->load(Yii::$app->request->post())) {
		$hsl = Yii::$app->request->post();	
		$paramCari=$hsl['kvTabForm']['0']['UNIX_BULAN_ID'];
	};
    // print_r(Yii::$app->request->post(['kvTabForm']['0']));die();
    if (!$sourceModel->load(Yii::$app->request->post(['kvTabForm']['0']))) {
        // $count = 0;
        foreach (Yii::$app->request->post(['kvTabForm']['0']) as $index => $datas) {
			// foreach($model as $mod){
				// print_r($datas['UNIX_BULAN_ID']);
				Yii::$app->db->createCommand("
				UPDATE product_stock_closing SET STOCK_INPUT_ACTUAL='".$datas['STOCK_INPUT_ACTUAL']."' WHERE UNIX_BULAN_ID='".$datas['UNIX_BULAN_ID']."'")->execute();
				// $sourceModel->UNIX_BULAN_ID=$datas['UNIX_BULAN_ID'];
				// $sourceModel->STOCK_INPUT_ACTUAL=$datas['STOCK_INPUT_ACTUAL'];
				// $model = ProductStockClosingSearch::find()->where(['UNIX_BULAN_ID'=>$datas['']])->one();
				// $sourceModel->update();
			// }
		}
		// die();
        Yii::$app->session->setFlash('success', "Processed records successfully.");
		return $this->redirect(['index']); // redirect to your next desired page

    } 
}
	/**====================================
	* EXPORT DATA
	* @return mixed
	* @author piter [ptr.nov@gmail.com]
	* @since 1.2
	* ====================================
	*/
	public function actionExport(){
		$modelPeriode = new \yii\base\DynamicModel([
			'TAHUN'
		]);		
		$modelPeriode->addRule(['TAHUN'], 'required')
         ->addRule(['TAHUN'], 'safe');
		 
		if ($modelPeriode->load(Yii::$app->request->post())) {
		$id=$modelPeriode->TAHUN;
		// print_r($id);die();
		$date=explode('-',$id);
		//DINAMIK MODEL PARAMS
		$searchModel = new ProductStockClosingSearch(['TAHUN'=>$date['0'],'BULAN'=>$date['1']]);
        $dataProvider = $searchModel->searchExport(Yii::$app->request->queryParams);
		$dinamikField=$dataProvider->allModels;
		$user = (empty(Yii::$app->user->identity->ACCESS_GROUP)) ? '' : Yii::$app->user->identity->ACCESS_GROUP;
		
		$excel_dataProdukStok = Postman4ExcelBehavior::excelDataFormat($dinamikField);
        $excel_titleProdukStok = $excel_dataProdukStok['excel_title'];
        $excel_ceilsProdukStok = $excel_dataProdukStok['excel_ceils'];

		
		// print_r($excel_titleProdukStok);
		// die();
		//DATA IMPORT
		$excel_content = [
			[
				'sheet_name' => 'Produk-Stok',
                'sheet_title' =>[$excel_titleProdukStok],
				'ceils' => $excel_ceilsProdukStok,
				'freezePane' => 'A2',
				'columnGroup'=>false,
				'autoSize'=>false,
				'headerColor' => Postman4ExcelBehavior::getCssClass("header"),
                'headerStyle'=>[	
					[
						'STORE_NM' =>['font-size'=>'9','width'=>'15','valign'=>'center','align'=>'center'],
						'ACCESS_GROUP' =>['font-size'=>'9','width'=>'15','valign'=>'center','align'=>'center'],
						'NAMA_TOKO' =>['font-size'=>'9','width'=>'17','valign'=>'center','align'=>'center'],
						'TTL_LALU' =>['font-size'=>'9','width'=>'7','valign'=>'center','align'=>'center'],
						'TTL_MASUK' =>['font-size'=>'9','width'=>'7','valign'=>'center','align'=>'center'],
						'TTL_JUAL' =>['font-size'=>'9','width'=>'7','valign'=>'center','align'=>'center'],
						'TTL_SISA' =>['font-size'=>'9','width'=>'7','valign'=>'center','align'=>'center'],
						'Closing' =>['font-size'=>'9','width'=>'7','valign'=>'center','align'=>'center'],
						'Actual' =>['font-size'=>'9','width'=>'7','valign'=>'center','align'=>'center'],
					]						
				],
				'contentStyle'=>[
					[						
						'STORE_NM' =>['font-size'=>'8','valign'=>'center','align'=>'left'],
						'ACCESS_GROUP' =>['font-size'=>'8','valign'=>'center','align'=>'left'],
						'NAMA_TOKO'=>['font-size'=>'8','valign'=>'center','align'=>'left'],
						'TTL_LALU' =>['font-size'=>'8','valign'=>'right','align'=>'RIGHT'],
						'TTL_MASUK' =>['font-size'=>'8','valign'=>'right','align'=>'RIGHT'],
						'TTL_JUAL' =>['font-size'=>'8','valign'=>'right','align'=>'RIGHT'],
						'TTL_SISA' =>['font-size'=>'8','valign'=>'right','align'=>'RIGHT'],
						'Closing' =>['font-size'=>'8','valign'=>'right','align'=>'RIGHT'],
						'Actual' =>['font-size'=>'8','valign'=>'right','align'=>'RIGHT']
					]
				],
               'oddCssClass' => Postman4ExcelBehavior::getCssClass("odd"),
               'evenCssClass' => Postman4ExcelBehavior::getCssClass("even"),
			],
		];
		// print_r($excel_content);
		// die();
		$excel_file = "Stock Opname Closing fix".$user."";
		$this->export4excel($excel_content, $excel_file,0);
		}else{
			return $this->renderAjax('form_cari_export',[
				'modelPeriode' => $modelPeriode
			]);
		}
	}
}
