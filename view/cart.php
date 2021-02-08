<div id="main">
	<div id="main_left">
		<h4>カート内商品</h4>
		<hr>
		<div id="contents">
<?php foreach( $param['data']['cart'] as $cart ) { ?>
			<div class="content">
				<div class="content_image">
					<a href="/fanzineShop/?mode=content&id=<?=display_text($cart['cart_content'])?>" title="<?=display_text($cart['content_name'])?>" data-target="content">
						<img src="/fanzineShop/image/<?=display_text($cart['content_image'])?>" alt="<?=display_text($cart['content_name'])?>">
					</a>
					<div class="favorite_button" data-id="<?=display_text($cart['cart_content'])?>"><img src="/fanzineShop/image/favorite.png" style="opacity:<?=($cart['favorite'])?'1':'0.3'?>"></div>
					<div class="select_button" data-id="<?=display_text($cart['cart_content'])?>"></div>
				</div>
				<div class="content_information">
					<input type="hidden" class="content_id" value="<?=display_text($cart['cart_content'])?>">
					<div class="content_type"><?=display_text($cart['content_type_word'])?></div>
					<div class="content_name"><a href="/fanzineShop/?mode=content&id=<?=display_text($cart['cart_content'])?>" title="<?=display_text($cart['content_name'])?>" data-target="content"><?=display_text($cart['content_name'])?></a></div>
					<div class="author_name"><a href="/fanzineShop/?mode=author&id=<?=display_text($cart['author_id'])?>" title="<?=display_text($cart['author_name'])?>" data-target="author"><?=display_text($cart['author_name'])?></a></div>
					<div class="cart_amount">個数&nbsp;<input class="cart_amount_input" type="number" value="<?=display_text($cart['cart_amount'])?>" min=0><button type="button" class="amount_plus">+</button><button type="button" class="amount_minus">-</button>
						<input type="hidden" class="single_price" value="<?=display_text($cart['content_price'])?>"></div>
					<div class="content_price">小計&nbsp;&bsol;<?=number_format($cart['content_price']*$cart['cart_amount'])?></div>
				</div>
			</div>
<?php } ?>
<?php if ( count($param['data']['cart']) == 0 ) { ?>
			<div class="cart_empty">カートには現在商品が入っていません。</div>
<?php } ?>
		</div>
		<div id="buy">
			<a href="#" id="buy_all" <?=(count($param['data']['cart'])==0)?'class="btn_disabled"':''?> data-target="no_move" data-mode="buy_all" title="カート内の商品をすべて購入">カート内の商品をすべて購入</a>
			<a href="#" id="buy_checked" <?=(count($param['data']['cart'])==0)?'class="btn_disabled"':''?> data-target="no_move" data-mode="buy_checked" title="チェックをつけた商品のみ購入">チェックをつけた商品のみ購入</a>
		</div>
	</div>
<?php include( "view/frame/main_right.php" ); ?>
	<div id="bottom_area"><button type="button" id="to_top_button">△ページの先頭へ</button></div>
</div>
