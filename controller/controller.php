<?php
	namespace controllers;

	class Controller {
		var $par;

		// do override.
		// make and return parameters which can be used when view.
		function make_param($par) {
			return array(
				'data' => array()
			);
		}

		// dont do override.
		// show the page content.
		function view( $par=array() ) {
			$this->par = $par;
			$class = explode( '\\', get_class( $this ) );
			$class = $class[count($class)-1];
			$name = strtolower( str_replace( 'Controller', '', $class ) );
			$param = $this->make_param( $par );
			$param['file'] = $name;
			$param['given'] = $par;
			$param['main_right'] = array();
			$param['main_right']['favorite'] = $this->getFavorite();
			$param['main_right']['property'] = $this->getProperty();
			if ( !(isset($par['in_site'])) or $par['in_site']!=='true' ) {
				include( "view/frame/header.php" );
			}
			include( "view/$name.php" );
			if ( !(isset($par['in_site'])) or $par['in_site']!=='true' ) {
				include( "view/frame/footer.php" );
			}
		}

		// do override if you want create post method.
		function submit( $par=array() ) {

		}

		// dont do override.
		// get user's favorite items.
		function getFavorite(){
			global $models;
			$strSQL = "select * from favorite_table
				left join content_table on favorite_content = content_id and content_deleted_at is null
				where favorite_user = " . $_SESSION['user_id'] . " and favorite_deleted_at is null";
			$favorite = $models['favorite']->myFind( $strSQL );
			return $favorite;
		}

		//dont do override.
		//get user's properties.
		function getProperty(){
			global $models;
			$strSQL = "select * from property_table
				left join content_table on property_content = content_id and content_deleted_at is null
				where property_user = " . $_SESSION['user_id'] . " and property_deleted_at is null";
			$property = $models['property']->myFind( $strSQL );
			return $property;
		}
	}
?>
