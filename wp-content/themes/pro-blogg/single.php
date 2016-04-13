<?php
 get_header();
?>
<section class="main news-main">
	<div class="clearfix">
	<div class="single_content"> 
		<div class="single_container">
			<div class="single_post_content">
				<?php while ( have_posts() ) : the_post();  
					//$categories = get_the_category(the_ID());
					//将object的对象转化成数组get_obhect_vars();
					//$categories = get_object_vars($categories[0]);
				?>
				<article class="post_box" id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<div class="post_nav">
						<span class="prev_post">
							<?php  previous_post_link('%link', '') ?>
						</span>
						<span class="next_post">
							<?php  next_post_link('%link', '') ?>
						</span>
					</div>
					<div class="clear"></div>
					<div class="single_top_title"><?php the_title(); ?></div>
					<div class="single_title_hr">
						<!--<div class="single_title_category">
							<a href="./category/<?php strtolower($categories['name'])?>"><?php $categories['name']?></a>
						</div>-->
						<hr>
					</div>
					<!--博客详情部分添加300*250广告位 -->
					<div class="single_srticle_ad_site">
						<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
						<!--  -->
						<ins class="adsbygoogle"
							 style="display:inline-block;width:300px;height:250px"
							 data-ad-client="ca-pub-3742939967040468"
							 data-ad-slot="2803209634"></ins>
						<script>
						(adsbygoogle = window.adsbygoogle || []).push({});
						</script>
					</div>
					<div class="single_detail_content">
						<?php the_content(); ?>
					</div>
					
					<!--博客详情部分添加300*250广告位 -->
					<div class="single_srticle_bottom_ad_site">
						<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
						<!-- orzzz content bottom 300250 -->
						<ins class="adsbygoogle"
							 style="display:inline-block;width:300px;height:250px"
							 data-ad-client="ca-pub-3742939967040468"
							 data-ad-slot="4315138836"></ins>
						<script>
						(adsbygoogle = window.adsbygoogle || []).push({});
						</script>
					</div><br/><br/>
						<?php
						wp_link_pages(array(
							'before' => '<div class="link_pages">'.__('Pages', 'pro-blogg'),
							'after' => '</div>',
							'link_before' => '<span>',
							'link_after' => '</span>'
						)); 
					?>
					<?php the_tags( '<div class="post_tags">Tags: ', ', ', '</div>' ); ?> 
					<!--此处为文章的评论部分，默认为隐藏状态-->
					[<a id="single_comments" href="#">Show Comment</a>]			
					<script type="text/javascript" src="/wp-content/themes/pro-blogg/js/jquery-1.8.3.min.js"></script>
					<script>
						
						$("#single_comments").click(function(){
							alert(3333);
							$('#single_comments_list').show(); alert(4444);
							//$('#single_comments_list').css('display','block');
							alert(4444);
						});
					
					</script>
					<div id="single_comments_list" style="display:none">
						<div class="clear"></div>
						<?php if ( comments_open() || '0' != get_comments_number() ) : ?>
									<div class="home_blog_box">
										<div class="comments_cont">
										<?php
											comments_template( '', true );
										?>
										</div>
									</div>
						<?php endif;?>
					</div>
					<!--评论部分结束-->
					
				</article>				
				<?php endwhile;?>		
			</div>
			
			
			<hr>
			<div class="guess_you_like"> <!-- class="guess_you_like"部分结束-->
				May be you like ~ ~ ~
			</div>
			<div class="include_homeContent" >				
					<div class="single_include_one_title" style="font-family:'Roboto',sans-serif;font-size:25px;font-weight:900;"><img src="/wp-content/themes/pro-blogg/images/moretrendingnews.png" width="850px" height:30px;></div>
					<div class="single_include_content" style="margin-left:auto;margin-right:auto;">
						<div class="single_include_container">
							<div class="single_include_post_content">
								<div class="single_include_home_posts">
								
									<?php
										$args2 = array(
										'post_type' => 'post',
										'posts_per_page' =>9,
										'paged' => ( get_query_var('paged') ? get_query_var('paged') : 1),
										);

										$query = new WP_Query( $args2 );
										if ( $query->have_posts() )
										{
											while ( $query->have_posts() )
											{						
												$query->the_post();
												echo '<div class="single_grid_post">';
												$type = get_post_meta($post->ID,'page_featured_type',true);
												switch ($type) {
													case 'youtube':
														echo '<iframe width="560" height="315" src="http://www.youtube.com/embed/'.get_post_meta( get_the_ID(), 'page_video_id', true ).'?wmode=transparent" frameborder="0" allowfullscreen></iframe>';
														break;
													case 'vimeo':
														echo '<iframe src="http://player.vimeo.com/video/'.get_post_meta( get_the_ID(), 'page_video_id', true ).'?title=0&amp;byline=0&amp;portrait=0&amp;color=03b3fc" width="500" height="338" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>';
														break;
													default:
														//echo '<div class="single_hr"><hr/></div>';
														echo '<div class="single_grid_post_img" >
																	<a href="'.get_permalink().'"><img src="'.catch_that_image().'" class="single_grid_post_img"></a>
																</div>';
														echo '<div class="single_grid_post_bottom">';
														echo '<div class="single_grid_post_title"><a href="'.get_permalink().'" style="font-color:#000000">'.mb_strimwidth(get_the_title(),0,70,'……').'</a></div>';
														
														echo '</div>';
													break;
												}
												echo '<div class="single_grid_home_posts"></div>';
												echo '</div>';
											}  //endwhile;
											
											?>
									</div>
									<?php
										echo '<div class="load_more_content"><div class="load_more_text">';
											ob_start();
												next_posts_link('LOAD MORE',$query->max_num_pages);
												$buffer = ob_get_contents();
											ob_end_clean();
											if(!empty($buffer)) {echo $buffer;}
										echo'</div></div>';					
										$max_pages = $query->max_num_pages;
										wp_reset_postdata();
									}//endif	
									?>
									<span id="max-pages" style="display:none"><?php echo $max_pages ?></span>
							</div>
							<div class="single_clear"></div>
					</div>
				</div>		
			<!--</div>		-->
		</div><!-- class="include_homeContent"部分结束-->
	</div><!-- class="single_container"部分结束-->	
		<div class="single_sidebar">
			<!--边栏广告位-->
			<div class="single_sidebar_ad_site">
				<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
				<!-- orzzzz content 300*600 -->
				<ins class="adsbygoogle"
					 style="display:inline-block;width:300px;height:600px"
					 data-ad-client="ca-pub-3742939967040468"
					 data-ad-slot="7373010037"></ins>
				<script>
				(adsbygoogle = window.adsbygoogle || []).push({});
				</script>
			</div>
			<div class="single_sidebar_one_title" >
				<img src="/wp-content/themes/pro-blogg/images/whathot.png" width="305px" height:30px;>
			</div>
			<ul class="asidepost-list">  
				<?php if (function_exists('get_most_viewed')): ?>   
				<?php single_get_timespan_most_viewed('post',20,7, true); ?>   
				<?php endif; ?>  
			</ul>
		</div><!-- class="single_sidebar"部分结束-->
	</div> <!-- class="single_content"部分结束-->
	</div> <!-- clearfix部分结束-->
</section>
<!-- 页面主题部分结束-->
<div class="single_footer">
<?php get_footer()?>
</div>

