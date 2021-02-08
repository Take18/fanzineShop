'use script';

window.addEventListener( 'load', onLoad, false );
var wrapper;
const xhr = new XMLHttpRequest();
var main;
var css;
var pankuzu;
var buy_contents;
var header_title;
var search;

function onLoad(){
	wrapper = document.getElementById( 'wrapper' );
	css = document.getElementById( "changable_css" );
	pankuzu = document.getElementById( "pankuzu_menu" );
	header_title = document.getElementById( "header_title" );
	var link = location.href.split('?');
	var target = 'home';
	if ( link.length > 1 ) {
		link = link[1].split('&');
		link.forEach( function(l){
			if ( l.substr( 0, 4 ) == 'mode' ) {
				target = l.substr( 5 );
			}
		});
		history.pushState( '', '', '/fanzineShop/' );
	}
	newLoad( target );
}

function showSearchDetail(e) {
	let menu = document.createElement('div');
	const body = document.body;
	menu.id = 'search_detail_menu';
	let menu_text = "<div id='menu_inner' class='detail_parts'>" + "<div class='close_btn detail_parts'>×</div>" + "<h4 class='detail_parts'>詳細検索</h4>"
		+ "<dl class='detail_parts'>"
			+ "<dt class='detail_parts'><label for='detail_keyword' class='detail_parts'>キーワード</label></dt>"
			+ "<dd class='detail_parts'><input type='text' id='detail_keyword' class='detail_parts'></dd>"
			+ "<dt class='detail_parts'><label for='detail_name' class='detail_parts'>作品名</label></dt>"
			+ "<dd class='detail_parts'><input type='text' id='detail_name' class='detail_parts'></dd>"
			+ "<dt class='detail_parts'><label for='detail_author' class='detail_parts'>作者名</label></dt>"
			+ "<dd class='detail_parts'><input type='text' id='detail_author' class='detail_parts'></dd>"
			+ "<dt class='detail_parts'><label for='detail_type' class='detail_parts'>種別</label></dt>"
			+ "<dd class='detail_parts'><select id='detail_type' class='detail_parts'>"
				+ "<option value='all'></option>"
				+ "<option value='comic'>漫画</option>"
				+ "<option value=anime>アニメ</option>"
				+ "<option value='game'>ゲーム</option>"
				+ "<option value='sound'>音声・ボイス</option>"
				+ "<option value='other'>その他</option>"
			+ "</select></dd>"
			+ "<dt class='detail_parts'><label for='detail_release_start' class='detail_parts'>発売日</label></dt>"
			+ "<dd class='detail_parts'>"
				+ "<input type='number' id='detail_start_year' class='detail_parts'>" + "<span class='detail_parts'>年</span>"
				+ "<input type='number' id='detail_start_month' class='detail_parts'>" + "<span class='detail_parts'>月</span>"
				+ "<input type='number' id='detail_start_day' class='detail_parts'>" + "<span class='detail_parts'>日</span>"
				+ "～"
			+ "</dd><dd class='detail_parts'>"
				+ "<input type='number' id='detail_end_year' class='detail_parts'>" + "<span class='detail_parts'>年</span>"
				+ "<input type='number' id='detail_end_month' class='detail_parts'>" + "<span class='detail_parts'>月</span>"
				+ "<input type='number' id='detail_end_day' class='detail_parts'>" + "<span class='detail_parts'>日</span>"
			+ "<dt class='detail_parts'><label for='detail_price_start' class='detail_parts'>価格</label></dt>"
			+ "<dd class='detail_parts'><input type='number' id='detail_price_start' class='detail_parts'>～<input type='text' id='detail_price_end' class='detail_parts'>"
			+ "<dd class='detail_parts' style='margin-top:40px;'><input class='checkbox detail_parts' type='checkbox' id='detail_favorite' value='true'><label class='detail_parts' for='detail_favorite' class='checkbox'>お気に入りから検索する</label></dd>"
			+ "<dd class='detail_parts'><input class='checkbox detail_parts' type='checkbox' id='detail_property' value='true'><label class='detail_parts' for='detail_property' class='checkbox'>購入済みから検索する</label></dd>"
		+ "</dl>"
		+ "<div class='detail_parts' id='detail_button'><input type='button' id='detail_submit' value='検索' class='detail_parts'></div></div>";
	menu.innerHTML = menu_text;
	body.appendChild( menu );
	body.addEventListener( 'click', removeSearchDetail, false );
	wrapper.style.opacity = 0.5;
	document.getElementById('detail_submit').addEventListener( 'click', searchWithDetail, false );
	e.stopPropagation();
}

function removeSearchDetail(e) {
	if ( e.target.classList.contains('detail_parts') && !(e.target.classList.contains('close_btn')) ) {
		return;
	}
	wrapper.style.opacity = 1;
	document.body.removeEventListener( 'click', removeSearchDetail, false );
	document.getElementById( 'search_detail_menu' ).remove();
}

function ajaxGet( url, param, func, return_type ) {
	let send_url = '';
	let keys = Object.keys(param);
	keys.forEach( function(key){
		send_url += ((send_url=='')?'?':'&') + key + '=' + param[key];
	});
	send_url = url + send_url;
	xhr.open( 'GET', send_url );
	xhr.send();
	xhr.onreadystatechange = function(){
		if ( xhr.readyState === 4 && xhr.status === 200 ) {
			if ( return_type==='json' ) {
				func(JSON.parse(xhr.responseText));
			} else if ( return_type==='text' ) {
				func(xhr.responseText);
			}
		}
	};
}

function ajaxPost( url, param, func, return_type ) {
	let send_data = '';
	let keys = Object.keys(param);
	keys.forEach( function(key){
		if ( Array.isArray(param[key]) ) {
			param[key].forEach( function(k) {
				send_data += ((send_data=='')?'':'&') + key + '[]=' + k;
			});
		} else {
			send_data += ((send_data=='')?'':'&') + key + '=' + param[key];
		}
	});
	xhr.open( 'POST', url );
	xhr.setRequestHeader( 'content-type', 'application/x-www-form-urlencoded;charset=UTF-8' );
	xhr.send( send_data );
	xhr.onreadystatechange = function(){
		if ( xhr.readyState === 4 && xhr.status === 200 ) {
			if ( return_type==='json' ) {
				func(JSON.parse(xhr.responseText));
			} else if ( return_type==='text' ) {
				func(xhr.responseText);
			} else if ( return_type==='test' ) {
				try {
					func(JSON.parse(xhr.responseText));
				} catch( e ) {
					console.log(xhr.responseText);
					console.error(e);
				}
			}
		}
	};
}

function rewritePage(e) {
	let a = e.target;
	while ( a.tagName != 'A' ) {
		a = a.parentNode;
	}
	if ( a.classList.contains('btn_disabled') ) {
		e.preventDefault();
	} else if ( a.dataset.target !== 'outside' ) {
		if ( a.dataset.target === 'no_move' ) {
			if ( a.dataset.mode === 'cart_in' ) {
				cartIn( a.dataset.id );
			} else if ( a.dataset.mode === 'buy_all' ) {
				let contents = [];
				Array.prototype.forEach.call( document.getElementsByClassName("content"), function(c) {
					let id = c.getElementsByClassName( 'content_id')[0].value;
					let amount = c.getElementsByClassName( 'cart_amount_input' )[0].value;
					let single_price = c.getElementsByClassName( 'single_price' )[0].value;
					let name = c.getElementsByClassName( 'content_name' )[0].textContent;
					contents.push( { id : id, amount : amount, price : single_price, name : name } );
				});
				buy_contents = contents;
				confirmBuy();
			} else if ( a.dataset.mode === 'buy_checked' ) {
				let contents = [];
				Array.prototype.forEach.call( document.getElementsByClassName("content"), function(c) {
					let select = c.getElementsByClassName( 'select_button' )[0];
					if ( select.classList.contains('selected') ) {
						let id = c.getElementsByClassName( 'content_id')[0].value;
						let amount = c.getElementsByClassName( 'cart_amount_input' )[0].value;
						let single_price = c.getElementsByClassName( 'single_price' )[0].value;
						let name = c.getElementsByClassName( 'content_name' )[0].textContent;
						contents.push( { id : id, amount : amount, price : single_price, name : name } );
					}
				});
				if ( contents.length == 0 ) {
					alert( 'チェックが付いた商品がありません。' );
				} else {
					buy_contents = contents;
					confirmBuy();
				}
			} else if ( a.dataset.mode === 'buy_sure' ) {
				buySure();
			} else if ( a.dataset.mode === 'buy_cancel' ) {
				document.getElementById( 'confirm_buy' ).remove();
				wrapper.style.opacity = 1;
				wrapper.removeEventListener( 'click', closeConfirm, true );
			} else if ( a.dataset.mode === 'buy_sure_single' ) {
				let id = document.querySelector( "input[name='content_id']" ).value;
				let price = document.querySelector( "input[name='content_price']" ).value;
				let name = document.querySelector( "input[name='content_name']" ).value;
				buy_contents = [ { id : id, amount : 1, price : price, name : name } ];
				buySure( "single" );
			} else if ( a.dataset.mode === 'buy_cancel_single' ) {
				let ancs = pankuzu.getElementsByTagName('a');
				ancs[ancs.length-1].remove();
				let href = ancs[ancs.length-1].href;
				let target = ancs[ancs.length-1].dataset.target;
				ajaxGet( href+'&in_site=true', {}, function(data){
					main.outerHTML = data;
					newLoad( target );
				}, 'text' );
			}
			e.preventDefault();
		} else {
			let href = a.href + "&in_site=true";
			ajaxGet( href, {}, function(data){
				main.outerHTML = data;
				newLoad( a.dataset.target );
			}, 'text' );
			if ( a.parentNode.id == 'pankuzu_menu' ) {
				var as = [].slice.call( pankuzu.getElementsByTagName('a') );
				var id = as.indexOf( a );
				as.forEach( function( anc, index ) {
					if ( id < index ) anc.remove();
				});
				document.title = a.title + '｜同人誌はFanzineShop!';
			} else if ( a.parentNode.id == 'header_left' ) {
				var anc = document.createElement("a");
				anc.href = a.href;
				anc.dataset.target = a.dataset.target;
				anc.innerHTML = 'ホーム';
				anc.title = 'ホーム';
				document.title = 'ホーム｜同人誌はFanzineShop!';
				pankuzu.appendChild( anc );
			} else {
				var anc = document.createElement("a");
				anc.href = a.href;
				anc.dataset.target = a.dataset.target;
				anc.innerHTML = a.title;
				anc.title = a.title;
				document.title = a.title + '｜同人誌はFanzineShop!';
				pankuzu.appendChild( anc );
			}
			e.preventDefault();
		}
	}
}

function newLoad( target ) {
	css.href = "/fanzineShop/css/" + target + ".css";
	document.getElementById( 'search_detail_btn' ).addEventListener( 'click', showSearchDetail, false  );
	document.getElementById( "to_top_button" ).addEventListener( 'click', toTop, false );
	let anchors = document.getElementsByTagName( 'a' );
	Array.prototype.forEach.call( anchors, function(a) {
		a.addEventListener( 'click', rewritePage, false );
	});
	let favorite_button = document.getElementsByClassName( 'favorite_button' );
	Array.prototype.forEach.call( favorite_button, function(f) {
		f.addEventListener( 'click', toggleFavorite, false );
	});
	let select_button = document.getElementsByClassName( 'select_button' );
	Array.prototype.forEach.call( select_button, function(s) {
		s.addEventListener( 'click', function(e){
			e.target.classList.toggle( 'selected' );
		}, false );
	});
	let amount_area = document.getElementsByClassName( 'cart_amount' );
	let price_area = document.getElementsByClassName( 'content_price' );
	let content_id = document.getElementsByClassName( 'content_id' );
	for ( let i=0; i<amount_area.length; i++ ) {
		calculatePrice( amount_area[i], price_area[i], content_id[i] );
	}
	main = document.getElementById( 'main' );
	document.getElementById( "search_submit" ).addEventListener( 'click', searchWithKeyword, false );
	document.querySelector("input[name='search_keyword']").addEventListener( 'keydown', function(e){
		if ( e.key == 'Enter' ) searchWithKeyword();
	}, false );
}

function toTop(){
	let duration = 500;
	let currentY = window.pageYOffset;
	let step = duration/currentY > 1 ? 10 : 20;
	console.log(step);
	let timeStep = duration/currentY * step;
	let intervalID = setInterval(scrollUp, timeStep);

	function scrollUp(){
		currentY = window.pageYOffset;
		if(currentY === 0) {
			clearInterval(intervalID);
		} else {
			scrollBy( 0, -step );
		}
	}
}

function toggleFavorite(e){
	let id;
	let div;
	let name;
	if ( e.target.tagName == 'IMG' ) {
		div = e.target.parentNode;
	} else {
		div = e.target;
	}
	id = div.dataset.id;
	name = div.parentNode.nextElementSibling.textContent;
	let param = {
		mode : 'content',
		id : id,
	}

	ajaxPost( '/fanzineShop/', param, function(json){
		if ( json.result == 'success' ) {
			if ( json.data == 'true' ) {
				div.children[0].style.opacity = 0.3;
				let anchors = document.getElementById('favorite_box').getElementsByTagName('a');
				let lis = document.getElementById('favorite_box').getElementsByTagName('li');
				Array.prototype.forEach.call( anchors, function(a, index){
					if ( a.dataset.id == id ) {
						lis[index].remove();
					}
				});
			} else if ( json.data == 'false' ) {
				div.children[0].style.opacity = 1;
				let li = document.createElement('li');
				li.innerHTML = "<a href='/fanzineShop/?mode=content&id=" + id + "' title='" + name + "' data-target='content' data-id=" + id + ">"
					+ "<img alt='" + name + "' src='/fanzineShop/image/favorite.png'>&nbsp;" + name + "</a></li>";
				document.getElementById('favorite_box').getElementsByTagName('ul')[0].appendChild( li );
			}
		} else {
			console.log( json );
		}
	}, 'test' );

}

function cartIn( id ) {
	let param = { mode : 'cart', id : id };
	ajaxPost( '/fanzineShop/', param, function(json){
		let result = document.createElement( 'div' );
		result.id = "post_result";
		console.log(json);
		if ( json.result == 'success' ) {
			result.innerHTML = 'カートに入れました。<a href="/fanzineShop/?mode=cart" data-target="cart" title="カート">カートを見る</a>';
		} else if ( json.result == 'failure' ) {
			result.innerHTML = 'カートに入れられませんでした。。';
			console.log( result.error );
		} else {
			console.log( json );
		}
		wrapper.appendChild( result );
		result.children[0].addEventListener( 'click', rewritePage, false );
		window.setTimeout( function(){
			result.remove();
		}, 2000 );
	}, 'json' );
}

function calculatePrice( amount, price, id ) {
	let input = amount.getElementsByTagName( 'input' )[0];
	let plus = amount.getElementsByClassName( 'amount_plus' )[0];
	let minus = amount.getElementsByClassName( 'amount_minus' )[0];
	let update = amount.getElementsByClassName( 'amount_update' )[0];
	let single = amount.getElementsByClassName( 'single_price' )[0].value;
	input.addEventListener( 'input', function(e){
		if ( e.data == '+' || e.data == '-' || e.data == '.' ) {
			input.value = input.value.substr( 0, input.value.length-1 );
			return;
		}
		price.innerHTML = "小計&nbsp;&bsol;" + ( input.value * single );
	}, false );
	plus.addEventListener( 'click', function(){
		input.value = Number(input.value) + 1;
		price.innerHTML = "小計&nbsp;&bsol;" + ( input.value * single );
	}, false );
	minus.addEventListener( 'click', function(){
		input.value = (Number(input.value)>0) ? ( Number(input.value) - 1 ) : 0;
		price.innerHTML = "小計&nbsp;&bsol;" + (input.value * single );
	}, false );
}

function confirmBuy() {
	let conf = document.createElement( 'div' );
	conf.id = "confirm_buy";
	let conf_text = "<div class='confirm_text'>以下の商品を購入します。よろしいですか？</div>";
	let sum_price = 0;
	buy_contents.forEach( function(c){
		conf_text += "<div class='confirm_row'><span class='confirm_title'>" + c.name + "</span>"
			+ "<span class='confirm_amount'>×" + c.amount + "</span>"
			+ "<span class='confirm_price'>&nbsp;&bsol;" + numberFormat(c.amount*c.price) + "</div>";
		sum_price += c.amount * c.price;
	});
	conf_text += "<div class='confirm_sum_price'>合計&nbsp;<strong>&bsol;" + numberFormat(sum_price) + "</strong></div>"
	conf_text += "<div class='confirm_ok'><a href='#' data-target='no_move' data-mode='buy_sure'>購入</a></div><div class='confirm_ng'><a href='#' data-target='no_move' data-mode='buy_cancel'>戻る</a></div>";
	conf.innerHTML = conf_text;
	wrapper.style.opacity = 0.5;
	wrapper.addEventListener( 'click', closeConfirm, true );
	document.body.appendChild( conf );
	let anchors = conf.getElementsByTagName( 'a' );
	Array.prototype.forEach.call( anchors, function(a) {
		a.addEventListener( 'click', rewritePage, false );
	});
}

function buySure( mode=false ){
	if ( !mode ) {
		let param = dataConvert( buy_contents );
		param.mode = 'buy';
		ajaxPost( '/fanzineShop/', param, function(json){
			if ( json.result === 'success'  ){
				let href = '/fanzineShop/?mode=home';
				ajaxGet( href+'&in_site=true', {}, function(data){
					main.outerHTML = data;
					newLoad( 'home' );
				}, 'text' );
				var anc = document.createElement("a");
				anc.href = href;
				anc.dataset.target = 'home';
				anc.innerHTML = 'ホーム';
				anc.title = 'ホーム';
				document.title = 'ホーム｜同人誌はFanzineShop!';
				pankuzu.appendChild( anc );

				let alrt = document.createElement( 'div' );
				alrt.id = 'buy_alert';
				let alrt_text = '購入が完了しました。';
				alrt.innerHTML = alrt_text;
				wrapper.appendChild( alrt );
				window.setTimeout( function(){
					alrt.remove();
				}, 2000 );
			} else if ( json.result === 'failure' ) {
				console.log( json.failure );
			}
		}, 'json' );
		document.getElementById( 'confirm_buy' ).remove();
		wrapper.style.opacity = 1;
		wrapper.removeEventListener( 'click', closeConfirm, true );
	} else if ( mode === 'single' ) {
		let param = dataConvert( buy_contents );
		param.mode = "buy";
		ajaxPost( '/fanzineShop/', param, function(json){
			let href = '/fanzineShop/?mode=home';
			ajaxGet( href+'&in_site=true', {}, function(data){
				main.outerHTML = data;
				newLoad( 'home' );
			}, 'text' );
			var anc = document.createElement("a");
			anc.href = href;
			anc.dataset.target = 'home';
			anc.innerHTML = 'ホーム';
			anc.title = 'ホーム';
			document.title = 'ホーム｜同人誌はFanzineShop!';
			pankuzu.appendChild( anc );

			let alrt = document.createElement( 'div' );
			alrt.id = 'buy_alert';
			let alrt_text = '購入が完了しました。';
			alrt.innerHTML = alrt_text;
			wrapper.appendChild( alrt );
			window.setTimeout( function(){
				alrt.remove();
			}, 2000 );
		}, 'json' );
	}
}

function numberFormat( num ) {
	let num_s = String(num);
	let ret = '';
	for( let i=0; num_s.length>=4; i++ ) {
		ret = num_s.substr(-3) + (ret==''?'':',') + ret;
		num_s = num_s.substr(0,num_s.length-3);
	}
	ret = num_s + (ret==''?'':',') + ret;
	return ret;
}

function closeConfirm(e){
	document.getElementById( 'confirm_buy' ).remove();
	wrapper.style.opacity = 1;
	wrapper.removeEventListener( 'click', closeConfirm, true );
}

function dataConvert( data ) {
	let ret = {};
	data.forEach( function(d) {
		let keys = Object.keys(d);
		keys.forEach(function(k){
			if ( ret[k] === undefined ) {
				ret[k] = [];
			}
			ret[k].push( d[k] );
		});
	});
	return ret;
}

function searchWithKeyword(e){
	let keyword = document.querySelector("input[name='search_keyword']").value;
	let param = { mode : 'search_keyword', keyword : keyword, in_site : 'true' };
	ajaxGet( '/fanzineShop/', param, function(data){
		main.outerHTML = data;
		newLoad( 'search' );
	}, 'text' );
}

function searchWithDetail(){
	let param = { mode : 'search_detail', in_site : 'true' };
	let dd = document.querySelectorAll("dd.detail_parts");
	Array.prototype.forEach.call( dd, function(d){
		let parts = d.querySelectorAll("input,select");
		Array.prototype.forEach.call( parts, function(p){
			if ( p.tagName == 'SELECT' || p.type != 'checkbox' ) {
				param[p.id] = p.value;
			} else {
				param[p.id] = (p.checked)?p.value:'';
			}
		});
	} );
	console.log( param );
	ajaxGet( '/fanzineShop/', param, function(data){

	}, 'text' );
}
