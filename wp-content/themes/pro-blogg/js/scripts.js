jQuery(document).ready(function($){	$('.head-nav .menu').slicknav({label: '' , prependTo: '.head-top .container'});	$('.head-nav ul li').hover(function(){		$('.sub-menu:first, .children:first',this).stop(true,true).slideDown('fast');	},	function(){		$('.sub-menu:first, .children:first',this).stop(true,true).slideUp('fast');	});	function head_margin() {		//$('.head-logo').css('margin-top',$('.head-top').outerHeight());	}	$(window).bind('scroll', function () {					    if ($(window).scrollTop() > 0) {		        $('.head-top').css('position','fixed');		    } else  {		        $('.head-top').css('position','relative');		    }		});	function window_size() {		var win = $(window).width();		return win;	}	//head_margin();	$('.home_slider').imagesLoaded( function() {		var win = window_size();		var w = win;				if (win<=960 && win > 767) {			w = win / 2;		}		else if (win<=767) {			w = win;		}		else if (win>767) {			w = win / 4;		}	  $('.home_slider').flexslider({	    animation: "slide",	    animationLoop: true, 	    itemWidth: w,	    maxItems: 4,	    minItems: 1,	    controlNav: false,	    move: 1,	    after: function(){	    	if (win == 768) {	    		$('.home_slider').height(300);	    	};	    	var slider1 = $('.home_slider').data('flexslider');			slider1.resize();	    }	  });	});		$(window).resize(function(){		//head_margin();		window_size();	});	//INDEX/ARCHIVE/SEARCH Infinite Scroll	var container = $('.home_posts');		function grid_images(){			$('.grid_post_img').each(function(){				var h = $(this).find('img').height();				var w = $(this).parent('.grid_post').width();				$(this).css({'width':w, 'height':h})			});		}		container.imagesLoaded( function() {			$('.home_posts').masonry({			  itemSelector: '.grid_post',			  columnWidth: '.home_posts .grid_post',			  gutter: 30			});			grid_images();		});		var curPage = 1;		var pagesNum = $('#max-pages').text();		if(pagesNum == 1){			$('.load_more_text a').css('display','none');			}		  $('.home_posts').infinitescroll({		    navSelector  : "div.load_more_text",            		    nextSelector : "div.load_more_text a:first",    		    itemSelector : ".home_posts .grid_post",		    maxPage: pagesNum		  },function(arrayOfNewElems){		  	container.imagesLoaded( function() {	           container.masonry( 'appended', arrayOfNewElems ); 	           grid_images();		 	        });	        curPage++;	        $('.load_more_text').show();	        if(curPage == pagesNum) {	            $('.load_more_text a').remove();	        }		  });		  $('.home_posts').infinitescroll('unbind');		  $('.load_more_text a').on('click', function(e) {			  e.preventDefault();			  $('.home_posts').infinitescroll('retrieve');			});		  $(window).resize(function(){		  	grid_images();		  });//INDEX/ARCHIVE/SEARCH Infinite Scroll  修改后的loadmore	var container = $('._content');		function grid_images(){			$('.grid_img').each(function(){				var h = $(this).find('img').height();				var w = $(this).parent('.home_grid_post').width();				$(this).css({'width':w, 'height':h})			});		}		container.imagesLoaded( function() {			$('._content').masonry({			  itemSelector: '.home_grid_post',			  columnWidth: '._content .home_grid_post',			  gutter: 5			});			grid_images();		});		var curPage = 1;		var pagesNum = $('#max-pages').text();		if(pagesNum == 1){			$('.load_more_text a').css('display','none');			}		  $('._content').infinitescroll({		    navSelector  : "div.load_more_text",            		    nextSelector : "div.load_more_text a:first",    		    itemSelector : "._content .home_grid_post",		    maxPage: pagesNum		  },function(arrayOfNewElems){		  	container.imagesLoaded( function() {	           container.masonry( 'appended', arrayOfNewElems ); 	           grid_images();		 	        });	        curPage++;	        $('.load_more_text').show();	        if(curPage == pagesNum) {	            $('.load_more_text a').remove();	        }		  });		  $('._content').infinitescroll('unbind');		  $('.load_more_text a').on('click', function(e) {			  e.preventDefault();			  $('._content').infinitescroll('retrieve');			});		  $(window).resize(function(){		  	grid_images();		  });		/*用于single.php引入首页部分的加载更多		//single Infinite Scroll  修改后的loadmore		var container = $('.single_include_home_posts');			function grid_images(){				$('.single_grid_post_img').each(function(){					var h = $(this).find('img').height();					var w = $(this).parent('.single_grid_post').width();					$(this).css({'width':w, 'height':h})				});			}			container.imagesLoaded( function() {				$('.single_include_home_posts').masonry({				  itemSelector: '.single_grid_post',				  columnWidth: '.single_include_home_posts .single_grid_post',				  gutter: 5				});				grid_images();			});			var curPage = 1;			var pagesNum = $('#max-pages').text();			if(pagesNum == 1){				$('.load_more_text a').css('display','none');				}			  $('.index_content_posts').infinitescroll({				navSelector  : "div.load_more_text",            				nextSelector : "div.load_more_text a:first",    				itemSelector : ".single_include_home_posts .single_include_home_posts",				maxPage: pagesNum			  },function(arrayOfNewElems){				container.imagesLoaded( function() {				   container.masonry( 'appended', arrayOfNewElems ); 				   grid_images();		 				});				curPage++;				$('.load_more_text').show();				if(curPage == pagesNum) {					$('.load_more_text a').remove();				}			  });			  $('.single_include_home_posts').infinitescroll('unbind');			  $('.load_more_text a').on('click', function(e) {				  e.preventDefault();				  $('.single_include_home_posts').infinitescroll('retrieve');				});			  $(window).resize(function(){				grid_images();			  });*/		//BLOG Infinite Scroll		var curPage = 1;		var pagesNum = $('#max-pages').text();		if(pagesNum == 1){			$('.load_more_text a').css('display','none');			}			  $('.blog_posts').infinitescroll({			    navSelector  : "div.load_more_text",            			    nextSelector : "div.load_more_text a:first",    			    itemSelector : ".blog_posts .blog_post_box",				behavior: "local",			    maxPage: pagesNum		  },function(arrayOfNewElems){		  		$('.load_more_text').show();		            curPage++;		            if(curPage == pagesNum) {		                $('.load_more_text a').css('display','none');		            }  		      		 		  });  			$('.blog_posts').infinitescroll('unbind');			  $('.load_more_text a').on('click', function(e) {				  e.preventDefault();				  $('.blog_posts').infinitescroll('retrieve');				});});