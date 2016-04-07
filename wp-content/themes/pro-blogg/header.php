<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php wp_title( '|', true, 'right' ); ?></title>
	<?php wp_head(); ?>
	</head> 
<body <?php body_class(); ?>>
<div class="header_container clearfix">
	<div class="header_main">
		<div class="header_main_left">
		
				<a href="#" style="width:34px;height:30px;float:left;padding-left:0;" id="web_links">
				<img src="./wp-content/themes/pro-blogg/imagegs/share-links.png" width="34px" height="30px">
				</a>				
			
			<a href="http://www.gag11.com" style="width:auto;height:30px;padding-left:0;float:left;">
				<img src="./wp-content/themes/pro-blogg/imagegs/web.png" width="75px" height="30px">
			</a>
		</div>
		<div class="header_main_center">
			<div class="head_search">
				<form role="search" method="get" class="search-form" action="<?php echo home_url( '/' ); ?>">
					<label>
						<span class="screen-reader-text">Search for:</span>
						<input type="text" class="search-field" placeholder="Search" value="<?php echo get_search_query() ?>" name="s" />
						<input type="image" src="<?php echo get_stylesheet_directory_uri(); ?>/images/search-icon.jpg">
					</label>
				</form>
			</div><!--搜索框 -->
		</div>
		<div class="header_main_right">
			<div class="head_socials">
				<ul>
					<?php
						$socials = array('twitter','facebook','google-plus','instagram','pinterest','vimeo','youtube','linkedin');
						for($i=0;$i<count($socials);$i++){
							$url = '';
							$s = $socials[$i];
							$url = dess_setting('dess_'.$s);
							echo ($url != '' ? '<li><a target="_blank" href="'.$url.'"><img src="'.esc_url( get_stylesheet_directory_uri() ).'/images/'.$s.'-icon.png" alt="'.$s.'" /></a></li>':'');
						}
					?>
				</ul>
			</div> <!-- 社交链接结束-->
		</div>
	</div>
</div>
		<div id="show_links" style="display:none">
			<ul class="blog-list related-blog-list">
				<li class="li-1">
					<ul class="li-1-ul">
						<li class="title" style="color:#aaa;font-size:20px;">Related blogs</li>
						<br>
						<li>
							<a href="http://gossip44.com">
							<img src="/wp-content/uploads/2016/03/links-icon.png" width="16" height="16">&nbsp;&nbsp;Entertainment
							</a>
						</li>
						<li>
							<a href="http://sneaker11.com">
							<img src="/wp-content/uploads/2016/03/links-icon.png" width="16" height="16">&nbsp;&nbsp;Sneaker
							</a>
						</li>
						<li>
							<a href="http://gamewoz.com">
							<img src="/wp-content/uploads/2016/03/links-icon.png" width="16" height="16">&nbsp;&nbsp;Game(Client)
							</a>
						</li>
						<li>
							<a href="http://wcgbee.com">
							<img src="/wp-content/uploads/2016/03/links-icon.png" width="16" height="16">&nbsp;&nbsp;Game(WCG)
							</a>
						</li>
						<li>
							<a href="http://0rzzzz.com">
							<img src="/wp-content/uploads/2016/03/links-icon.png" width="16" height="16">&nbsp;&nbsp;ACG
							</a>
						</li>
						<li>
							<a href="http://gag11.com">
							<img src="/wp-content/uploads/2016/03/links-icon.png" width="16" height="16">&nbsp;&nbsp;Funny Series
							</a>
						</li>
					</ul>
				</li>
				<li class="li-2">
					<ul class="li-2-ul">
						<li class="title" style="color:#aaa;font-size:20px;">Related blogs</li>
						<br>
						<li>
							<a href="http://prank11.com">
							<img src="/wp-content/uploads/2016/03/links-icon.png" width="16" height="16">&nbsp;&nbsp;Prank Compilation
							</a>
						</li>
						<li>
							<a href="http://teaserme.com">
							<img src="/wp-content/uploads/2016/03/links-icon.png" width="16" height="16">&nbsp;&nbsp;Sexy 
							</a>
						</li>
						<li>
							<a href="http://popond.com">
							<img src="/wp-content/uploads/2016/03/links-icon.png" width="16" height="16">&nbsp;&nbsp;Music
							</a>
						</li>
						<li>
							<a href="http://geeklots.com">
							<img src="/wp-content/uploads/2016/03/links-icon.png" width="16" height="16">&nbsp;&nbsp;GEEK
							</a>
						</li>
						<li>
							<a href="http://techwoz.com">
							<img src="/wp-content/uploads/2016/03/links-icon.png" width="16" height="16">&nbsp;&nbsp;Techcrunch
							</a>
						</li>
						<li>
							<a href="http://apphiton.com">
							<img src="/wp-content/uploads/2016/03/links-icon.png" width="16" height="16">&nbsp;&nbsp;APP Review
							</a>
						</li>
						
					</ul>
				</li>
			</ul>
				
			</div>
	<script type="text/javascript" src="./wp-content/themes/pro-blogg/js/jquery-1.8.3.min.js"></script>
	<script>	
		$("#web_links").click(function(){
			if ($('#show_links').css('display') == 'none')
			{
				$('#show_links').css('display','block');
			} else {
				$('#show_links').css('display','none');
			}
			
		});
	
	</script>