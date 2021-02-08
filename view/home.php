<div id="main">
	<div id="main_left" class="content_list">
<?php foreach( $param['data'] as $c ) { ?>
		<div class="contents <?=display_text($c['size'])?>">
			<a href="/fanzineShop/?mode=content&id=<?=display_text($c['content_id'])?>" title="<?=display_text($c['content_name'])?>" data-target="content"><img src="/fanzineShop/image/<?=display_text($c['content_image'])?>" alt="<?=display_text($c['content_name'])?>"></a>
			<span class="content_title"><a href="/fanzineShop/?mode=content&id=<?=display_text($c['content_id'])?>" title="<?=display_text($c['content_name'])?>" data-target="content"><?=display_text($c['content_name'])?></a></span><span class="content_genre"><?=display_text($c['content_genre'])?></span>
			<span class="content_author"><a href="/fanzineShop/?mode=author&id=<?=display_text($c['author_id'])?>" title="<?=display_text($c['author_name'])?>" data-target="author"><?=display_text($c['author_name'])?></a></span><span class="content_price">&bsol;<?=number_format($c['content_price'])?></span>
		</div>
<?php } ?>
	</div>
<?php include( "view/frame/main_right.php" ); ?>
	<div id="bottom_area"><button type="button" id="to_top_button">△ページの先頭へ</button></div>
</div>
