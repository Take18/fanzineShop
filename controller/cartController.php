<?php
	namespace controllers;

	class CartController extends Controller {
		function make_param(){
			global $models;
			$param = array();
			$strSQL = "select * from cart_table
				left join content_table on cart_content = content_id and content_deleted_at is null
				left join author_table on content_author = author_id and author_deleted_at is null
				where cart_user = " . $_SESSION['user_id'] . " and cart_deleted_at is null";
			$cart = $models['cart']->myFind( $strSQL );
			foreach( $cart as $i => $c ) {
				$strSQL = "select * from favorite_table where favorite_user = " . $_SESSION['user_id'] . " and favorite_content = " . $c['content_id'] . " and favorite_deleted_at is null";
				if ( count( $models['favorite']->myFind( $strSQL ) ) > 0 ) {
					$cart[$i]['favorite'] = true;
				} else {
					$cart[$i]['favorite'] = false;
				}
				if ( $c['content_type'] == 1 ) {
					$cart[$i]['content_type_word'] = '漫画';
				} else if ( $c['content_type'] == 2 ) {
					$cart[$i]['content_type_word'] = 'アニメ';
				} else if ( $c['content_type'] == 3 ) {
					$cart[$i]['content_type_word'] = 'ゲーム';
				} else if ( $c['content_type'] == 4 ) {
					$cart[$i]['content_type_word'] = '音声・サウンド';
				}
			}
			$param['data']['cart'] = $cart;
			$param['title'] = 'カート';
			return $param;
		}

		function submit( $par ) {
			global $models;
			$strSQL = "select * from cart_table where cart_user = " . $_SESSION['user_id'] . " and cart_content = " . $par['id'] . " and cart_deleted_at is null";
			$param = array(
				'cart_user' => $_SESSION['user_id'],
				'cart_content' => $par['id'],
				'cart_updated_at' => 'now()',
			);
			$exist = $models['cart']->myFind($strSQL);
			if ( count($exist) > 0 ) {
				$param['cart_amount'] = $exist[0]['cart_amount'] + 1;
				$models['cart']->update( $param, $exist[0]['cart_id'] );
			} else {
				$param['cart_amount'] = '1';
				$param['cart_created_at'] = 'now()';
				$models['cart']->insert( $param );
			}
			$error = $models['cart']->getError();
			if ( $error != '' ) {
				echo json_encode( array(
					'result' => 'failure',
					'error' => $error,
				) );
			} else {
				echo json_encode( array(
					'result' => 'success',
				) );
			}
		}
	}
?>
