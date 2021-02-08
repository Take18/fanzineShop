<?php
	namespace controllers;

	class BuyController extends Controller {
		function make_param($par){
			global $models;
			$param = array();
			$content = $models['content']->findOrFail( $par['id'] );
			$param['data'] = $content;
			$param['title'] = "商品購入";
			return $param;
		}

		function submit($par){
			global $models;
			$exist = array();
			$failure = array();
			$data = array();
			$res = true;
			foreach( $par['id'] as $i => $id ) {
				$strSQL = "select * from cart_table where cart_user = " . $_SESSION['user_id'] . " and cart_content = " . $id . " and cart_deleted_at is null";
				$result = $models['cart']->myFind( $strSQL );
				if ( count($result) > 0 ) {
					$exist[] = $result[0]['cart_id'];
					$data[] = $result[0]['cart_content'];
				} else {
					$res = false;
					$failure[] = $id;
				}
			}

			if ( $res ) {
				$models['cart']->delete( $exist );
				foreach( $data as $d ) {
					$strSQL = "select * from property_table where property_user = " . $_SESSION['user_id'] . " and property_content = " . $d . " and property_deleted_at is null";
					$prop = $models['property']->myFind( $strSQL );
					if (count($prop)>0) {
						//already have
						$models['property']->update( array('property_amount'=>($prop[0]['property_amount']+1)), $prop[0]['property_id'] );
					} else {
						//dont have
						$models['property']->insert( array('property_user'=>$_SESSION['user_id'],'property_content'=>$d,'property_amount'=>'1','property_created_at'=>'now()','property_updated_at'=>'now()') );
					}
				}
				$return = array(
					'result' => 'success',
				);
			} else {
				$return = array(
					'result' => 'failure',
					'failure' => $failure,
				);
			}
			echo json_encode( $return );
		}
	}
?>
