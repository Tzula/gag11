<?php
get_header();
?>
<div class="single">
	<div class="single_content">
		<div class="single_container">
			<div class="single_post_content">
				<div class="archive_title">
					<h2>Search Results: <?php echo get_search_query(); ?></h2>
				</div><!--//archive_title-->
				
					<?php
						$args = array_merge( $wp_query->query, array( 'posts_per_page' => 6 ) );					
						$query = new WP_Query($args);

						if ( $query->have_posts() ) : ?>

			<div class="home_posts">
						<?php	while ( $query->have_posts() ) : $query->the_post();
								echo '<div class="grid_post">
										<h3><a href="'.get_permalink().'">'.get_the_title().'</a></h3>';
								$type = get_post_meta($post->ID,'page_featured_type',true);
								switch ($type) {
									case 'youtube':
										echo '<iframe width="560" height="315" src="http://www.youtube.com/embed/'.get_post_meta( get_the_ID(), 'page_video_id', true ).'?wmode=transparent" frameborder="0" allowfullscreen></iframe>';
										break;
									case 'vimeo':
										echo '<iframe src="http://player.vimeo.com/video/'.get_post_meta( get_the_ID(), 'page_video_id', true ).'?title=0&amp;byline=0&amp;portrait=0&amp;color=03b3fc" width="500" height="338" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>';
										break;
									default:
										echo '<div class="grid_post_img">
													<a href="'.get_permalink().'">'.get_the_post_thumbnail().'</a>
												</div>';
										break;
								}
								echo '<div class="grid_home_posts">
											<p>'.dess_get_excerpt(120).'</p>
										</div>
									</div>
									';
							endwhile;
							
					?>
			</div>
			<?php
				echo '<div class="load_more_content"><div class="load_more_text">';
						ob_start();
							next_posts_link('LOAD MORE');
							$buffer = ob_get_contents();
						ob_end_clean();
						if(!empty($buffer)) echo $buffer;
					echo'</div></div>';					
					$max_pages = $query->max_num_pages;
					wp_reset_postdata();
			?>
			<span id="max-pages" style="display:none"><?php echo $max_pages ?></span>
			<?php
				else :
			?>

					<h2>No results found</h2>
					<p>Try to search again.</p>
					<?php get_search_form(); ?>
					
			<?php
				endif;
			?>
			
			</div>
			<?php //get_sidebar(); ?>
		</div>
	  </div>
	<div class="single_sidebar">
		<div class="single_sidebar_one_title"><strong><span><em><h2>What's Hot</h2></em></span></strong></div>
			<ul class="asidepost-list">  
			<?php if (function_exists('get_most_viewed')): ?>   
			<?php get_timespan_most_viewed('post',10,7, true); ?>   
			<?php endif; ?>  
			</ul>
	</div>
</div>
<?php
get_footer();
?>