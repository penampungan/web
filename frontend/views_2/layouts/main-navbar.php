<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
// use common\widgets\Alert;
use kartik\icons\Icon;

dmstr\web\AdminLteAsset::register($this);
?>
 <header class="main-header"> <header class="main-header">
	<div  class="logo" style="<?php echo Yii::$app->getTemplate->Template(Yii::$app->user->identity->TEMPLATE)['Navbar-Left']?>">
		<?php
		//#245F77,#1aa8bf
	     echo Html::img(Yii::$app->request->baseUrl.'/logo-dashboard3.png', ['width'=>'150px','height'=>'50px']);
		?>
		<!-- LOGO 
		LukisonGroup-->
		
	</div> 
	<?php
		NavBar::begin([
			// 'brandLabel' => '		
				// <img src="http://ptrnov.net/img/ptrnov-putih.png" class="navbar-header page-scroll" style="width:170px; height:40px; margin-left:50px; margin-top:0px"/>
			// ',
		   /*  'brandLabel' =>'
				 <div class="logo bg-red">                
					<a class="navbar-brand" href="#page-top">Kontrol Gampang</a>
				</div>
			', */
			'brandLabel' => '<!-- Sidebar toggle button-->
				<a id="kg" href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
					<span class="sr-only">Toggle Navigation</span>
				</a>'
			,
			'brandUrl' => Yii::$app->homeUrl,
			'options' => [
				'id'=>'mainNav',
				//'class' => 'navbar-inverse navbar-fixed-top',
				'class' => 'navbar navbar-inverse navbar-static-top',
			],
		]);
		
		if (Yii::$app->user->isGuest) {
			$menuItems[] = '<li class="hidden"> <a href="#page-top"></a></li>';
			$menuItems[] = '<li class="page-scroll"> <a href="#home" id="home-controller">Home</a></li>';
			$menuItems[] = '<li class="page-scroll"> <a href="#service" id="service-controller">Service</a></li>';
			$menuItems[] = '<li class="page-scroll"> <a href="#help" id="help-controller">Help</a></li>';
			$menuItems[] = '<li class="page-scroll"> <a href="#contact" id="contact-controller">Contact</a></li>';  
		
		   //$menuItems[] = ['label' => 'Signup', 'url' => ['/site/signup']];
			$menuItems[] = '<li class="page-scroll">  <a href="#signup-select" id="signup-controller">Signup</a></li>';
			$menuItems[] = '<li class="page-scroll">  <a href="#login-select" id="login-controller">Login</a></li>';
		
			//$menuItems[] = ['label' => 'Login', 'url' => ['/site/login']];
		} else {
			/* $menuItems[] = '<li>'
				. Html::beginForm(['/site/logout'], 'post')
				. Html::submitButton(
					'Logout (' . Yii::$app->user->identity->username . ')',
					['class' => 'btn btn-link logout']
				)
				. Html::endForm()
				. '</li>'; */
			$menuItems[] = [
				'label' => Icon::show('power-off') ,//. 'Logout',// (' . Yii::$app->user->identity->username . ')',
				//'label' => Icon::showStack('twitter', 'square-o', ['class'=>'fa-lg']) . 'Logout (' . Yii::$app->user->identity->username . ')',
				'url' => ['/site/logout'],
				'linkOptions' => ['data-method' => 'post']
			];
			// $menuItems[] = [
			// 	'label' => Icon::show('bell-o'),
			// 	'items'=>[
			// 		['label'=>'test','url' => ['/site/logout'],],
			// 		['label'=>'test','url' => ['/site/logout'],],
			// 	],
			// ];
		}
		?>
		 <!--<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">!-->
		 <?php
			echo Nav::widget([
				'options' => ['class' => 'navbar-nav  navbar-left'],
				'items' => $menuItems,
				'encodeLabels' => false,
			]);
		
		?>
		<!--</div>!-->
		<?php
		NavBar::end();
		?>
</header>
	<?php
	$this->registerJs("
		//$('body').scrollspy({ target: '.navbar-fixed-top' })
	",$this::POS_READY);
	?>
