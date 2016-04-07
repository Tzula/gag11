<?php
/*
Template Name: Blog Page
*/
get_header();
$args = array(
			 'post_type' => 'post',
			 'posts_per_page' => 3,
			 'paged' => ( get_query_var('paged') ? get_query_var('paged') : 1),
			 'category_name' => 'blog'
			 );
$query = new WP_Query($args);
if ( $query->have_posts() ) :
	?>
	<div class="content">
		<div class="container">
			<div class="post_content">
				<div class="blog_posts">
				<?php while ( $query->have_posts() ) : $query->the_post(); ?>
					<div class="blog_post_box <?php echo (is_sticky() ? 'sticky' : ''); ?>">
						<article id="post-<?php the_ID(); ?>">
						<div class="blog_box_featured_image">
						<?php
							$type = get_post_meta($post->ID,'page_featured_type',true);
				 			switch ($type) {
				 				case 'youtube':
				 					echo '<iframe width="560" height="315" src="http://www.youtube.com/embed/'.get_post_meta( get_the_ID(), 'page_video_id', true ).'?wmode=transparent" frameborder="0" allowfullscreen></iframe>';
				 					break;
				 				case 'vimeo':
				 					echo '<iframe src="http://player.vimeo.com/video/'.get_post_meta( get_the_ID(), 'page_video_id', true ).'?title=0&amp;byline=0&amp;portrait=0&amp;color=03b3fc" width="500" height="338" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>';
				 					break;
				 				default:
									echo '<a href="'.get_permalink().'">'.get_the_post_thumbnail(get_the_ID(),'blog_image').'</a>';
									break;
							}
						?>
						</div>
						<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
						<p class="blog_post_date"><?php the_time('M, d Y'); ?></p>
						<div class="blog_post_content"><?php echo dess_get_excerpt(530); ?></div>
						<a href="<?php the_permalink(); ?>" class="read-more">Read More</a>
						</article>
					</div>
				<?php endwhile; ?>
				</div>
				<div class="load_more_content">
					<div class="load_more_text">
					<?php
					ob_start();
						next_posts_link('LOAD MORE',$query->max_num_pages);
						$buffer = ob_get_contents();
					ob_end_clean();
					if(!empty($buffer)) echo $buffer;

					$max_pages = $query->max_num_pages;
					?>
					</div>
				</div>   					
				<span id="max-pages" style="display:none"><?php echo $max_pages ?></span>
				<?php wp_reset_query(); ?>
			</div>
			
			<?php get_sidebar(); ?>
		</div>
	</div>
	
	<?php
wp_link_pages();
else :
	echo '<p>Sorry, no posts matched your criteria.</p>'; 
endif;
get_footer();
?>