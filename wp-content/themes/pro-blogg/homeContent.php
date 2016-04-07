<?php wp_homeContent(); ?>
<div class="index_content" style="margin:10px auto;">

		<!--此处引入轮播 -->
		<?php 
		if (dess_setting('dess_show_slider') == 1) :
			
			$args = array(
				'post_type' => 'post',
				'meta_key' => 'show_in_slider',
				'meta_value' => 'yes',
				'posts_per_page' => -1,
				'ignore_sticky_posts' => true
				);
			$the_query = new WP_Query( $args );
			$sliderImg = array();
			$images = array();
			$i = 0; 
			$j = 0;
			if ( $the_query->have_posts() ) :
				while ( $the_query->have_posts() ) : $the_query->the_post();
					$type = get_post_meta($post->ID,'page_featured_type',true);
					switch ($type) {
						case 'youtube':
							echo '<li><iframe width="560" height="315" src="http://www.youtube.com/embed/'.get_post_meta( get_the_ID(), 'page_video_id', true ).'?wmode=transparent" frameborder="0" allowfullscreen></iframe></li>';
							break;
						case 'vimeo':
							echo '<li><iframe src="http://player.vimeo.com/video/'.get_post_meta( get_the_ID(), 'page_video_id', true ).'?title=0&amp;byline=0&amp;portrait=0&amp;color=03b3fc" width="500" height="338" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe></li>';
							break;
						default: 
							$thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full' );
							$sliderImg[] = array('imgUrl' => $thumbnail[0], 'title' => get_the_title(), 'getTheLink' => get_permalink());;
																			
							break; 
						}
				endwhile;
				wp_reset_postdata();
			endif;
			//从此处开始循环输出轮播图片,每三张图片存入一个数组组成一个三维数组
			foreach ($sliderImg as $key => $list) {
				if ($key < 16) {
					for ($i = 0; $i<4; $i++) {
						if (!is_int(($key+1)/5)) {
							$images[$i][] = $list;
						}		
					}
				}	
			}
			echo '<div id="owl-demo" class="owl-carousel">';
			//循环输出轮播图
			foreach ($images as $key => $list) {
				echo '<div class="itme">';
					echo '<ul>';
						echo '<li class="li1">
							  <a href="'.$list[0]['getTheLink'].'"><img src="'.$list[0]['imgUrl'].'" alt="yi Photos lost" style="width:584px;height:389px;"></a>
							  <div class="txt">
								<h3><a href="'.$list[0]['getTheLink'].'">'.$list[0]['title'].'</a></h3>
								<p></p>
							 </div>
						</li>';
						echo '<li class="li2">
							  <a href="'.$list[1]['getTheLink'].'"><img src="'.$list[1]['imgUrl'].'" alt="yi Photos lost"
							  style="width:396px;height:210px;"></a>
							  <div class="txt">
								<h4><a href="'.$list[1]['getTheLink'].'">'.mb_strimwidth($list[1]['title'],0,60,'……').'</a></h4>
								<p></p>
							 </div>
						</li>';
						echo '<li class="li3 li-3" style="width:193px;">
							  <a href="'.$list[2]['getTheLink'].'"><img src="'.$list[2]['imgUrl'].'" alt="yi Photos lost"
							  style="width:193px;height:170px;"></a>
							  <div class="txt">
								<h5><a href="'.$list[2]['getTheLink'].'">'.mb_strimwidth($list[2]['title'],0,40,'……').'</a></h5>
								<p></p>
							 </div>
						</li>';
						echo '<li class="li3" style="width:193px;">
							  <a href="'.$list[3]['getTheLink'].'"><img src="'.$list[3]['imgUrl'].'" alt="yi Photos lost"
							  style="width:193px;height:170px;"></a>
							  <div class="txt">
								<h5><a href="'.$list[3]['getTheLink'].'">'.mb_strimwidth($list[3]['title'],0,40,'……').'</a></h5>
								<p></p>
							 </div>
						</li>';

					echo '</ul>';
				echo '</div>';
			}
		echo '</div>';
		endif;
		?>	<!--导航部分结束 -->
	<!-- 精选热门部分开始-->
	<div class="home_hot">
		<div class="home_content_title">精选热门</div>
		<div class="home_hot_posts">
			<ul class="hotpost-list">  
				<?php if (function_exists('get_most_viewed')): ?>   
				<?php get_timespan_most_viewed('post',10,7, true); ?>   
				<?php endif; ?>  
			</ul>
		</div>
	</div>
	<!--类别精选 5-->
	<div class="home_cate">
	
	<?php 
		$args = array_merge( $wp_query->query, array( 'posts_per_page' => 5) );
		$query = new WP_Query($args);
		if ($query->have_posts()) 
		{
			$type = get_post_meta(15,'page_featured_type',true);
			$categories = get_the_category($post->ID);
			//将object的对象转化成数组get_obhect_vars();
			$categories = get_object_vars($categories[0]);
			echo '<div class="home_content_title">'.$categories['name'].'</div>';
			while($query->have_posts())
				{
					$query->the_post();
					
					echo '<div class="home_grid_post">';
					

					//获取文章的浏览次数
					$rows = $wpdb->get_results( "SELECT meta_value FROM yy_postmeta WHERE meta_key = 'views' AND post_id = $post->ID" );
					$views = get_object_vars($rows[0]);
					switch ($type) {
						case 'youtube':
							echo '<iframe width="560" height="315" src="http://www.youtube.com/embed/'.get_post_meta( get_the_ID(), 'page_video_id', true ).'?wmode=transparent" frameborder="0" allowfullscreen></iframe>';
							break;
						case 'vimeo':
							echo '<iframe src="http://player.vimeo.com/video/'.get_post_meta( get_the_ID(), 'page_video_id', true ).'?title=0&amp;byline=0&amp;portrait=0&amp;color=03b3fc" width="500" height="338" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>';
							break;
						default:
						echo '<div class="grid_img">
								 <a href="'.get_permalink().'"><img src="'.catch_that_image().'" ></a>';
						echo '</div>';
						echo '<div class="grid_post_info">';
							echo '<div class="grid_post_title" ><a href="'.get_permalink().'">'.mb_strimwidth(get_the_title(),0,60,'……').'</a></div>';
							echo '<div class="grid_post_views" ><img src="/wp-content/uploads/2016/03/hits.png" width="20px";height="20px"; style="float:left;">';
							echo '<span class="grid_views">';  echo $views['meta_value'];
							echo '</span></div>';
						echo '</div>';
						break;

					}//switch结束
					
					echo '</div>';	//class="index_content_posts_grid_post“结束				
				} //while 结束
		}
	?>
		</div>
	</div>
</div> 