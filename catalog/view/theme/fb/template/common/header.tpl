<?php if (isset($_SERVER['HTTP_USER_AGENT']) && !strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE 6')) echo '<?xml version="1.0" encoding="UTF-8"?>'. "\n"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>" xml:lang="<?php echo $lang; ?>">
<head>
<meta http-equiv="X-UA-Compatible" content="IE=8" />
<title><?php echo $title; ?></title>
<?php if ($keywords) { ?>
<meta name="keywords" content="<?php echo $keywords; ?>" />
<?php } ?>
<?php if ($description) { ?>
<meta name="description" content="<?php echo $description; ?>" />
<?php } ?>
<base href="<?php echo $base; ?>" />
<?php if ($icon) { ?>
<link href="<?php echo $icon; ?>" rel="icon" />
<?php } ?>
<link rel="stylesheet" type="text/css" href="catalog/view/theme/fb/stylesheet/component.css" />
<script type="text/javascript" src="catalog/view/javascript/jquery/jquery-1.6.1.min.js"></script>
<script type="text/javascript" src="catalog/view/javascript/jquery/jcarousel/jquery.jcarousel.min.js"></script>
<script type="text/javascript" src="catalog/view/javascript/jquery/ui/jquery-ui-1.8.15.custom.min.js"></script>
<link rel="stylesheet" type="text/css" href="catalog/view/javascript/jquery/ui/themes/custom-theme/jquery-ui-1.8.15.custom.css" />
<script type="text/javascript" src="catalog/view/javascript/fb_common.js"></script>
<script type="text/javascript" src="catalog/view/javascript/jquery/tab.js"></script>
<link rel="stylesheet" type="text/css" href="catalog/view/theme/fb/stylesheet/stylesheet.css" />
<script type="text/javascript"><!--
	var KODEMALL = KODEMALL ||  { };

	KODEMALL.marketplace_base_url = '<?php echo HTTPS_MALL_SERVER; ?>';

	KODEMALL.store_base_url = '<?php echo HTTPS_SERVER; ?>';
</script>
<script type="text/javascript">
window.fbAsyncInit = function() {
FB.Canvas.setAutoGrow();
}
// Do things that will sometimes call sizeChangeCallback()
function sizeChangeCallback() {
FB.Canvas.setSize({ width: 520, height: 1400 });
}
</script>
</head>
<body>
<div id="container">
	<div id="header">
		<div id="searchform">
			<div class="form">
				<input type="text" value="<?php echo $keyword; ?>" id="filter_keyword" placeholder="<?php echo $text_placeholder_search ?>" />
				&nbsp;&nbsp;<a onclick="moduleSearch();" class="fb_bluebutton"><?php echo $text_search ?></a>
			</div>
			<div id="cart"><a class="fb_greybutton" href="<?php echo $cart ?>"><span id="view_cart"><?php echo $my_cart ?></span></a></div>
		</div>
	</div>

<?php if($categories) {?>
	<div id="SideCategoryList" class="Block CategoryList">
		<h2><?php echo $text_categories ?><span class="homeLink"><a href="<?php echo $home ?>"><?php echo $text_home ?></a></span></h2>
		<div class="slider">
			<div class="SideCategoryListClassic">
				<ul>
					<?php foreach($categories as $category) {?>
						<li><a href="<?php echo $category['href']?>"><?php echo $category['name'] ?></a></li>
					<?php }?>
				</ul>
			</div>
		</div>
		<?php if(count($categories)>6) {?>
		<div class="slider_menu">
			<a><span class="open"><?php echo $text_see_more ?></span></a>
		</div>
		<?php }?>
	</div>
<?php }?>	
	<div class="clear"></div>
	<?php if($show_banner && $banner) {?>
		<div id="LayoutColumn1" class="Content Widest">
			<img src="<?php echo $banner ?>" alt="<?php echo $store_name ?>"/>
		</div>
	<?php }?>
<div id="notification"></div>
<script type="text/javascript"><!--
$('#searchform input').keydown(function(e) {
	if (e.keyCode == 13) {
		moduleSearch();
	}
});

function moduleSearch() {	
	
	url = KODEMALL.store_base_url;

	url += 'index.php?route=fb/search';
		
	var filter_keyword = $('#filter_keyword').attr('value')
	
	if (filter_keyword) {
		url += '&keyword=' + encodeURIComponent(filter_keyword);
		location = url;
	}
	
}

var h = $('.slider').css('height');
$('.slider').css({height : '65px'});

$('.slider_menu a').click(function(){
	
	var className = $(this).children('span').attr('class');
	
	if(className == 'open'){
		$(".slider").animate({
		    height: h
		  }, 500 );
		$(this).children('span').attr('class','close');
		$(this).children('span').text('<?php echo $text_close ?>'); 
	}else{
		$(".slider").animate({
		    height: "65px"
		  }, 500 );
		$(this).children('span').attr('class','open');
		$(this).children('span').text('<?php echo $text_see_more ?>');
	}
	
	
});
//--></script>
