<div id="main">
	<div id="main_left">
		<div id="search_conditions">
			<span>検索条件</span>
<?php if ( $param['given']['search']['mode'] === 'search_keyword' ) { ?>
			<div class="search_condition">キーワード：<?=display_text($param['given']['search']['keyword'])?></div>
			<div class="paging_row"><a href="#" data-target="no_move" data-mode="to_previous">前の10件</a><a href="#" data-target="no_move" data-mode="to_next">次の10件</a></div>
			<div id="search_result">
<?php 	foreach( $param['data'] as $data ) { ?>
				<div class="result_row">
					<a href="/fanzineShop/?mode=content&id=<?=display_text($data['content_id'])?>" data-target="content" title="<?=display_text($data['content_name'])?>">
						<img src="/fanzineShop/image/<?=display_text($data['content_image'])?>" alt="<?=display_text($data['content_name'])?>">
					</a>
				</div>
<?php 	} ?>
			</div>
<?php } else if ( $param['given']['search']['mode'] === 'search_detail' ) { ?>
<?php } ?>
		</div>
	</div>
<?php include( "view/frame/main_right.php" ); ?>
	<div id="bottom_area"><button type="button" id="to_top_button">△ページの先頭へ</button></div>
</div>
