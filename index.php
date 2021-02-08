<?php
	require_once( 'setting.php' );


	//require controller
	require_once( 'controller/controller.php' );

	//require models
	require_once( 'model/model.php' );
	require_once( 'model/content.php' );
	require_once( 'model/cart.php' );
	require_once( 'model/author.php' );
	require_once( 'model/favorite.php' );
	require_once( 'model/property.php' );


	//namespace use models
	use models\Content;
	use models\Cart;
	use models\Author;
	use models\Favorite;
	use models\Property;


	//create objects
	$models = array(
		'content' => new Content,
		'cart' => new Cart,
		'author' => new Author,
		'favorite' => new Favorite,
		'property' => new Property,
	);


	//routing

	if ( empty($_SERVER['PATH_INFO']) ) {
		if ( $_SERVER['REQUEST_METHOD'] === 'GET' and !isset($_GET['mode']) ) {
			include( "controller/homeController.php" );
			$obj = new controllers\HomeController;
			$req = $_GET;
			$obj->view($req);
		} else if ( $_SERVER['REQUEST_METHOD'] === 'GET' and file_exists( "controller/" . $_GET['mode'] . "Controller.php" ) ) {
			include( "controller/" . $_GET['mode'] . "Controller.php" );
			$class = "controllers\\" . largize($_GET['mode']) . "Controller";
			$obj = new $class();
			$req = $_GET;
			$obj->view($req);
		} else if ( $_SERVER['REQUEST_METHOD'] === 'POST' and file_exists( "controller/" . $_POST['mode'] . "Controller.php" ) ) {
			include( "controller/" . $_POST['mode'] . "Controller.php" );
			$class = "controllers\\" . largize($_POST['mode']) . "Controller";
			$obj = new $class();
			$req = $_POST;
			$obj->submit($req);
		}
	}

?>
