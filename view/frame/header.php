<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0">
	<title><?=( isset($param['title']) and $param['title']!='' )?display_text( $param['title'].'｜' ):''?>同人誌はFanzineShop!</title>
	<link rel="stylesheet" href="/fanzineShop/css/style.css">
<?php if ( isset($param['file']) and $param['file']!='' ) { ?>
	<link rel="stylesheet" href="/fanzineShop/css/<?=display_text( $param['file'] )?>.css" id="changable_css">
<?php } ?>
	<script type="text/javascript" src="/fanzineShop/js/script.js"></script>
</head>
<body>
	<div id="wrapper">
		<div id="header" class="clearfix">
			<div id="header_left">
				<a href="/fanzineShop/?mode=home" title="同人誌や同人音声など、二次創作品を主にご紹介する通販サイトです。" id="header_title" data-target="home">同人誌はFanzineShop!</a>
			</div>
			<div id="header_right">
				<a href="/fanzineShop/?mode=convention" title="利用規約" data-target="option">利用規約</a>｜<a href="/fanzineShop/?mode=query" title="問い合わせ" data-target="option">問い合わせ</a>
				<a href="/fanzineShop/?mode=cart" title="カート" data-target="cart"><img src="/fanzineShop/image/cart.png" alt="カートを見る"></a>
			</div>
<?php if ( isset($param['title']) and $param['title']!='' ) { ?>
			<div id="pankuzu_menu"><a href="/fanzineShop/?mode=home" data-target="home" title="<?=display_text($param['title'])?>"><?=display_text($param['title'])?></a></div>
<?php } else { ?>
			<div id="pankuzu_menu"><a href="/fanzineShop/?mode=home" data-target="home" title="ホーム">ホーム</a></div>
<?php } ?>
		</div>
