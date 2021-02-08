<?php
	namespace controllers;

	class AuthorController extends Controller {
		function make_param($par){
			global $models;
			$param = array();
			$strSQL = "select *, date_format( author_created_at, '%Y/%m/%d' ) as author_created_at_day, date_format( author_updated_at, '%Y/%m/%d' ) as author_updated_at_day from author_table where author_id = " . $par['id'] . " and author_deleted_at is null";
			$param['data']['author'] = ($models['author']->myFind( $strSQL ))[0];
			if ( $param['data']['author']['author_discription'] == '' ) {
				$param['data']['author']['author_discription'] = '作者情報が登録されていません。';
			}
			if ( $param['data']['author']['author_image'] == null ) {
				$param['data']['author']['author_image'] = 'no_image.png';
			} else if ( !file_exists( '/fanzineShop/image/'.$param['data']['author']['author_image'] ) ) {
				$param['data']['author']['author_image'] = 'no_image.png';
			}
			$strSQL = "select * from content_table where content_author = " . $par['id'] . " and content_deleted_at is null";
			$contents = $models['author']->myFind( $strSQL );
			$param['data']['author']['content_amount'] = count( $contents );
			foreach( $contents as $i => $c ) {
				if ( $c['content_type'] == '1' ) {
					$contents[$i]['content_type_word'] = "漫画";
				} else if ( $c['content_type'] == '2' ) {
					$contents[$i]['content_type_word'] = "アニメ";
				} else if ( $c['content_type'] == '3' ) {
					$contents[$i]['content_type_word'] = "ゲーム";
				} else if ( $c['content_type'] == '4' ) {
					$contents[$i]['content_type_word'] = "音声・ボイス";
				}
			}
			$param['data']['contents'] = $contents;
			$strSQL = "select sum( content_sales ) as content_sales from content_table where content_author = " . $par['id'] . " and content_deleted_at is null";
			$param['data']['author']['content_sales'] = ($models['author']->myFind( $strSQL ))['content_sales'];
			$param['title'] = $param['data']['author']['author_name'];
			return $param;
		}
	}
?>
