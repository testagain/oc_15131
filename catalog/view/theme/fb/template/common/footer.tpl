<div id="cart_overlay" class="productOverlay popup hidden"></div>
<div class="">
<div class="SubCategoryList">
		<ul>
			<?php foreach($informations as $information){?>
				<li><a href="<?php echo $information['href']?>"><?php echo $information['title']?></a></li>
			<?php }?>
		
		</ul>
	</div>
</div>
</div>
<script type="text/javascript">
		$('document').ready(function(){
			$('#cart_overlay').dialog({
				autoOpen: false,
				modal: false,
				width: 350,
				resizable: false,
				title: '<?php echo $text_add_to_cart ?>' 
			});
		});	
</script>
<div id="fb-root"></div>
<script src="http://connect.facebook.net/en_US/all.js"></script>
<script>
FB.init({
appId : '<?php echo $facebook_application_id ?>',
status : true, // check login status
cookie : true, // enable cookies to allow the server to access the session
xfbml : true // parse XFBML
});
</script>


</body></html>			
