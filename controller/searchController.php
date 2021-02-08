<?php
	namespace controllers;

	class SearchController extends Controller {
		function make_param($par){
			global $models;
			$param = array();
			if ( $par['search']['mode'] === 'search_keyword' ) {
				$strSQL = "select * from content_table
					left join author_table on content_author = author_id and author_deleted_at is null
					where ( content_name like '%" . $par['search']['keyword'] . "%' or content_discription '%" . $par['search']['keyword'] . "%' or
					author_name like '%" . $par['search']['keyword'] . "%' or author_discription like '%" . $par['search']['keyword'] . "%' ) and content_deleted_at is null";
				$contents = $models['content']->myFind( $strSQL );
				$param['data'] = $contents;
				$param['title'] = "商品検索：" . display_text($par['search']['keyword']);
				return $param;
			} else if ( $par['search']['mode'] === 'search_detail' ) {
				$param['title'] = "商品検索：詳細モード";
			}
		}
	}

?>
