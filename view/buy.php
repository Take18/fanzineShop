<div id="main">
	<div id="main_left">
		<div class="buy_text">以下の商品を購入します。よろしいですか？</div>
		<div class="buy_row">
			<span class="buy_title"><?=display_text($param['data']['content_name'])?></span><span class="buy_amount">×1</span>
			<span class="buy_price">&nbsp;&bsol;<?=number_format($param['data']['content_price'])?></span>
		</div>
		<div class="buy_row buy_sum">合計&nbsp;<strong>&bsol;<?=number_format($param['data']['content_price'])?></strong></div>
		<div class="buy_row">
			<div class="buy_ok"><a href="#" data-target='no_move' data-mode='buy_sure_single'>購入</a></div><div class="buy_ng"><a href="#" data-target='no_move' data-mode='buy_cancel_single'>戻る</a></div>
		</div>
		<input type="hidden" name="content_id" value="<?=display_text($param['data']['content_id'])?>">
		<input type="hidden" name="content_price" value="<?=display_text($param['data']['content_price'])?>">
		<input type="hidden" name="content_name" value="<?=display_text($param['data']['content_name'])?>">
	</div>
<?php include( "view/frame/main_right.php" ); ?>
	<div id="bottom_area"><button type="button" id="to_top_button">△ページの先頭へ</button></div>
</div>
