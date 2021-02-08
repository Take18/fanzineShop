<?php
	namespace controllers;

	class HomeController extends Controller {
		function make_param(){
			global $models;
			$param = array();
			$strSQL = "select * from content_table
			left join author_table on content_author = author_id and author_deleted_at is null
			where content_deleted_at is null
			order by content_sales desc limit 51";
			$contents = $models['content']->myFind( $strSQL );
			foreach ( $contents as $index => $c ) {
				if ( $index == 0 ) $contents[$index]['size'] = 'full_size';
				else if ( $index < 3 ) $contents[$index]['size'] = 'half_size';
				else $contents[$index]['size'] = 'quarter_size';

				$type = $c['content_type'];
				if ( $type == 1 ) $contents[$index]['content_genre'] = '漫画';
				else if ( $type == 2 ) $contents[$index]['content_genre'] = 'アニメ';
				else if ( $type == 3 ) $contents[$index]['content_genre'] = 'ゲーム';
				else if ( $type == 4 ) $contents[$index]['content_genre'] = '音声・ボイス';
				else $contents[$index]['content_genre'] = 'その他';
			}
			$param['title'] = 'ホーム';
			$param['data'] = $contents;
			return $param;
		}

		function test(){
			global $models;
			$param = array();
			$strSQL = "select * from content_table
			left join author_table on content_author = author_id
			where content_deleted_at is null and author_deleted_at is null
			order by content_sales desc limit 51";
			$contents = $models['content']->myFind( $strSQL );
			foreach ( $contents as $index => $c ) {
				if ( $index == 0 ) $contents[$index]['size'] = 'full_size';
				else if ( $index < 3 ) $contents[$index]['size'] = 'half_size';
				else $contents[$index]['size'] = 'quarter_size';
			}
			$param['data'] = $contents;
			return $param;
		}
	}
?>
