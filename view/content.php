<div id="main">
	<div id="main_left">
		<div id="content_image">
			<a href="/fanzineShop/image/<?=display_text($param['data']['content_image'])?>" title="<?=display_text($param['data']['content_name'])?>の画像" data-target="outside" target="_blank">
				<img src="/fanzineShop/image/<?=display_text($param['data']['content_image'])?>" alt="<?=display_text($param['data']['content_name'])?>">
			</a>
			<div class="favorite_button" data-id="<?=display_text($param['data']['content_id'])?>"><img src="/fanzineShop/image/favorite.png" style="opacity:<?=($param['data']['favorite'])?'1':'0.3'?>"></div>
		</div>
		<div id="content_title"><?=display_text($param['data']['content_name'])?></div>
		<div id="content_discription">
			<h4>作品内容</h4>
			<hr>
			<p>&nbsp;&nbsp;<?=display_text($param['data']['content_discription'])?></p>
		</div>
		<div id="content_information">
			<div id="content_type"><?=display_text($param['data']['content_type_word'])?></div>
			<div id="content_author">
				Created By <a href="/fanzineShop/?mode=author&id=<?=display_text($param['data']['content_author'])?>" data-target="author" title="<?=display_text($param['data']['author_name'])?>"><?=display_text($param['data']['author_name'])?></a>
			</div>
			<div id="content_price">&bsol;<?=number_format($param['data']['content_price'])?></div>
			<div id="content_sales_day"><?=display_text($param['data']['content_sales_day'])?>&nbsp;発売</div>
			<div id="content_sales_amount">販売数&nbsp;<?=number_format($param['data']['content_sales'])?></div>
			<div id="content_cart_in">
				<a href="#" data-target="no_move" data-mode="cart_in" data-id="<?=display_text($param['data']['content_id'])?>" title="カートに入れる"><img src="/fanzineShop/image/cart_mini.png" alt="カート">カートに入れる</a>
			</div>
			<div id="content_buy_soon">
				<a href="/fanzineShop/?mode=buy&id=<?=display_text($param['data']['content_id'])?>" data-target="buy" title="今すぐ買う">今すぐ買う</a>
			</div>
		</div>
		<div id="other_contents">
			<h4>同作者の作品</h4>
			<hr>
<?php
	foreach( $param['data']['others'] as $o ) {
?>
			<div class="others">
				<a href="/fanzineShop/?mode=content&id=<?=display_text($o['content_id'])?>" title="<?=display_text($o['content_name'])?>" data-target="content"><img src="/fanzineShop/image/<?=display_text($o['content_image'])?>" alt="<?=display_text($o['content_name'])?>"></a>
				<span class="other_title"><a href="/fanzineShop/?mode=content&id=<?=display_text($o['content_id'])?>" title="<?=display_text($o['content_name'])?>" data-target="content"><?=display_text($o['content_name'])?></a></span>
				<span class="other_type"><?=display_text($o['content_type_word'])?></span>
			</div>
<?php
	}
?>
			<a href="/fanzineShop/?mode=author&id=<?=display_text($param['data']['content_author'])?>" id="check_more" data-target="author" title="<?=display_text($param['data']['author_name'])?>">もっと見る</a>
		</div>
	</div>
<?php include( "view/frame/main_right.php" ); ?>
	<div id="bottom_area"><button type="button" id="to_top_button">△ページの先頭へ</button></div>
</div>
