<?php wp_homeContent(); ?>
<?php $cateIds = array();?>
<script>
var cate = [];
$("#menu-tzula li").each(function(j, obj) 
{ 
	var url = $(this).children().attr('href');
	url = url.substr(url.indexOf('?')+1).split("&");
	var result = [];
	for(var i=0; i<url.length; i++){
		url[i] = url[i].split("=");
		result[i] = url[i][1];
	}
	//cate[] = result;
	
});
$("#cateIds").attr('value', cate);	
</script>
<?php //var_dump($cateIds); ?>


<div class="h_content">

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
			$m = 0;
			$i = 0;
			foreach ($sliderImg as $key => $list) {
				if ($key < 16) {
					switch ($key) {
						case $key - $m < 4 :
							$images[$i][] = $list;
							break;
						case $key - $m >= 4 :
							$i = $i + 1;
							$m = $key;
							if ($key - $m < 4) {
								$images[$i][] = $list;
							}
							break;
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
	
	
	<?php
		$catIds = array();
		$catId = wp_nav_menu_id(array('theme_location' => 'header-menu'));
		$args = array_merge( $wp_query->query, array( 'posts_per_page' => 5) );
		$query = new WP_Query($args);
		foreach ($catId as $key => $list) {
			$info = get_object_vars($list);
			//var_dump($info);exit;
			$catId = $info['object_id'];
			echo '<div class="home_content_title">'.strtoupper($info['title']).'</div>';
			echo '<div class="home_cate">';
			$posts = $wpdb->get_results("select * from yy_posts where ID in (select object_id from yy_term_relationships where term_taxonomy_id = ".$catId.") and post_status = 'publish' ORDER BY post_date DESC limit 5");
			//var_dump($posts);exit;
			foreach ($posts as $key => $list){
				$list = get_object_vars($list);
				$postId = $list[ID];
				//获取文章的浏览次数
				$rows = $wpdb->get_results( "SELECT meta_value FROM yy_postmeta WHERE meta_key = 'views' AND post_id = ".$postId );
				$views = get_object_vars($rows[0]);
				echo '<div class="home_grid_post" >';	
					echo '<div class="grid_img">
							 <a href="'.get_permalink($list[ID]).'"><img src="'.catch_that_image().'" ></a>';
					echo '</div>';
					echo '<div class="grid_post_info">';
						echo '<div class="grid_post_title" ><a href="'.get_permalink($list[ID]).'">'.mb_strimwidth($list['post_title'],0,60,'……').'</a></div>';
						echo '<div class="grid_post_views" ><img src="/wp-content/themes/pro-blogg/images/hits.png" width="20px";height="20px"; style="float:left;">';
						echo '<span class="grid_views">';  echo $views['meta_value'];
						echo '</span></div>';
					echo '</div>';
				echo '</div>';
			}
			echo '</div>';
			echo '<div class="home_content_cate_more"><a href="'.$info['url'].'"><img src="/wp-content/themes/pro-blogg/images/more.png"></a></div>';
	   }

   ?>
		
</div> 