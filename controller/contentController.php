<?php
	namespace controllers;

	class ContentController extends Controller {
		function make_param($par){
			global $models;
			$param = array();
			$strSQL = "select *, date_format( content_created_at, '%Y/%m/%d' ) as content_sales_day from content_table
				left join author_table on content_author = author_id and author_deleted_at is null
				where content_id = " . $par['id'] . " and content_deleted_at is null";
			$content = ($models['content']->myFind( $strSQL ))[0];
			if ( $content['content_type'] == '1' ) {
				$content['content_type_word'] = "漫画";
			} else if ( $content['content_type'] == '2' ) {
				$content['content_type_word'] = "アニメ";
			} else if ( $content['content_type'] == '3' ) {
				$content['content_type_word'] = "ゲーム";
			} else if ( $content['content_type'] == '4' ) {
				$content['content_type_word'] = "音声・ボイス";
			}

			$strSQL = "select * from content_table
				where content_author = " . $content['content_author'] . " and content_id != " . $content['content_id'] . " and content_deleted_at is null order by content_sales desc limit 10";
			$content['others'] = $models['content']->myFind( $strSQL );
			foreach( $content['others'] as $i => $o ) {
				if ( $o['content_type'] == '1' ) {
					$content['others'][$i]['content_type_word'] = "漫画";
				} else if ( $o['content_type'] == '2' ) {
					$content['others'][$i]['content_type_word'] = "アニメ";
				} else if ( $o['content_type'] == '3' ) {
					$content['others'][$i]['content_type_word'] = "ゲーム";
				} else if ( $o['content_type'] == '4' ) {
					$content['others'][$i]['content_type_word'] = "音声・ボイス";
				}
			}

			$strSQL = "select * from favorite_table
				where favorite_user = " . $_SESSION['user_id'] . " and favorite_content = " . $par['id'] . " and favorite_deleted_at is null";
			$exist = $models['favorite']->myFind( $strSQL );
			$content['favorite'] = ( count($exist) > 0 );
			$param['data'] = $content;
			$param['title'] = $content['content_name'];
			return $param;
		}

		function submit( $par=array() ) {
			global $models;
			$return = array();
			$strSQL = "select * from favorite_table where favorite_user = " . $_SESSION['user_id'] . " and favorite_content = " . $par['id'];
			$favorite = $models['favorite']->myFind( $strSQL );
			if ( count($favorite) == 0 ) {
				$return['result'] = 'success';
				$return['data'] = 'false';
				$models['favorite']->insert( array(
					'favorite_user' => $_SESSION['user_id'],
					'favorite_content' => $par['id'],
					'favorite_created_at' => 'now()',
					'favorite_updated_at' => 'now()',
				) );
			} else if ( $favorite[0]['favorite_deleted_at'] != null ) {
				$return['result'] = 'success';
				$return['data'] = 'false';
				$strSQL = $models['favorite']->update( array(
					'favorite_deleted_at' => 'null',
				), $favorite[0]['favorite_id'], '', true );
			} else {
				$return['result'] = 'success';
				$return['data'] = 'true';
				$models['favorite']->update( array(
					'favorite_deleted_at' => 'now()',
				), $favorite[0]['favorite_id'] );
			}

			echo json_encode( $return );
		}
	}

?>
