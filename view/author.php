<div id="main">
	<div id="main_left" class="content_list">
		<div id="author_name"><?=display_text($param['data']['author']['author_name'])?></div>
		<div id="author_image">
			<a href="/fanzineShop/image/<?=display_text($param['data']['author']['author_image'])?>" title="<?=$param['data']['author']['author_name']?>" data-target="no_move" target="_blank">
				<img src="/fanzineShop/image/<?=display_text($param['data']['author']['author_image'])?>" alt="<?=$param['data']['author']['author_name']?>の画像">
			</a>
		</div>
		<div id="author_discription">
			<h4>作者紹介</h4>
			<hr>
			<p><?=display_text($param['data']['author']['author_discription'])?></p>
		</div>
		<div id="author_information">
			<span>作品数&nbsp;<?=number_format($param['data']['author']['content_amount'])?></span>
			<span>販売数&nbsp;<?=number_format($param['data']['author']['content_sales'])?></span>
			<span>活動開始日&nbsp;<?=display_text($param['data']['author']['author_created_at_day'])?></span>
			<span>最終更新日&nbsp;<?=display_text($param['data']['author']['author_updated_at_day'])?></span>
		</div>
		<div id="author_contents">
			<h4>この作者の作品</h4>
			<hr>
<?php
	foreach( $param['data']['contents'] as $c ) {
?>
			<div class="contents">
				<a href="/fanzineShop/?mode=content&id=<?=display_text($c['content_id'])?>" title="<?=display_text($c['content_name'])?>" data-target="content"><img src="/fanzineShop/image/<?=display_text($c['content_image'])?>" alt="<?=display_text($c['content_name'])?>"></a>
				<span class="content_title"><a href="/fanzineShop/?mode=content&id=<?=display_text($c['content_id'])?>" title="<?=display_text($c['content_name'])?>" data-target="content"><?=display_text($c['content_name'])?></a></span>
				<span class="content_type"><?=display_text($c['content_type_word'])?></span>
			</div>
<?php
	}
?>
		</div>
	</div>
<?php include( "view/frame/main_right.php" ); ?>
	<div id="bottom_area"><button type="button" id="to_top_button">△ページの先頭へ</button></div>
</div>
