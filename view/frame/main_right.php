<div id="main_right">
	<div id="search_area">
		<h4>検索</h4>
		<div id="search_box">
			<input type="text" name="search_keyword">
			<button type="button" id="search_submit"></button>
		</div>
		<input type="button" value="詳細検索" id="search_detail_btn">
	</div>
	<div id="category_area">
		<h4>カテゴリー</h4>
		<div id="category_box">
			<ul>
				<li><a href="/fanzineShop/?mode=category&category=comic" title="漫画" data-target="category"><img alt="カテゴリー：漫画" src="/fanzineShop/image/comic.png" title="漫画">&nbsp;漫画</a></li>
				<li><a href="/fanzineShop/?mode=category&category=anime" title="アニメ" data-target="category"><img alt="カテゴリー：アニメ" src="/fanzineShop/image/cd.png" title="アニメ">&nbsp;アニメ</a></li>
				<li><a href="/fanzineShop/?mode=category&category=game" title="ゲーム" data-target="category"><img alt="カテゴリー：ゲーム" src="/fanzineShop/image/game.png" title="ゲーム">&nbsp;ゲーム</a></li>
				<li><a href="/fanzineShop/?mode=category&category=voice" title="音声・ボイス" data-target="category"><img alt="カテゴリー：音声・ボイス" src="/fanzineShop/image/sound.png" title="音声・ボイス">&nbsp;音声・ボイス</a></li>
			</ul>
		</div>
	</div>
	<div id="favorite_area">
		<h4>お気に入り</h4>
		<div id="favorite_box">
			<ul>
<?php foreach( $param['main_right']['favorite'] as $favorite ) { ?>
				<li><a href="/fanzineShop/?mode=content&id=<?=display_text($favorite['favorite_content'])?>" title="<?=display_text($favorite['content_name'])?>" data-target="content" data-id="<?=display_text($favorite['content_id'])?>"><img alt="<?=display_text($favorite['content_name'])?>" src="/fanzineShop/image/favorite.png">&nbsp;<?=display_text($favorite['content_name'])?></a></li>
<?php } ?>
			</ul>
		</div>
	</div>
	<div id="property_area">
		<h4>購入済み</h4>
		<div id="property_box">
			<ul>
<?php foreach( $param['main_right']['property'] as $property ) { ?>
				<li><a href="/fanzineShop/?mode=property&id=<?=display_text($property['property_content'])?>" title="<?=display_text($property['content_name'])?>" data-target="property" data-id="<?=display_text($property['content_id'])?>">&nbsp;<?=display_text($property['content_name'])?></a></li>
<?php } ?>
			</ul>
		</div>
	</div>
</div>
