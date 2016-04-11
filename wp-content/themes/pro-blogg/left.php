<?php wp_left(); ?>

<div class="home_left" style="background-color:#FFFFFF;  border-right: 1px solid #e8e8e8; width:230px; min-height:700px;margin-left:0;">
		<div class="home_left_content">
			<dl >
				<dt>
					<div class="home_left_hr"><hr style="color:#e8e8e8"></div>
					<li>
						<a href="<?php echo 'http://'.$_SERVER['HTTP_HOST']; ?>">
						<img src="/wp-content/themes/pro-blogg/images/home-logo.png" width="186" height="28">
						</a>
					</li>
					<li>
						<a href="http://www.gag11.com">
							<img src="/wp-content/themes/pro-blogg/images/now-pop.png" width="20" height="20">时下流行
						</a>
					</li>
				</dt>

			</dl>
			<dl>
				<div class="home_left_hr"><hr ></div>
				<dt >
					<div class="home_left_nav">
					<?php wp_nav_menu(array('theme_location' => 'header-menu'));?>
					</div>				
				</dt>
				
			</dl>
			<dl>
				<div class="home_left_hr"><hr ></div>
				<dt>
				<li>
					更多精彩敬请期待~ ~ ~
				</li>
				
				
				</dt>
				
			</dl>
		</div><!--home_left_content结束 -->
	</div>