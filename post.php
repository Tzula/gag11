<?php
/*
    


*/

//-------------------配置参数开始，根据需要修改-------------------------
$post_author_default    = 1;
$post_status    = "publish";
$time_interval  = 1;
$post_next      = "now";
$post_ping      = false;
$translate_slug = false;
$secretWord     = false;

//-------------------配置参数结束，以下请勿修改-------------------------
if (isset($_GET['action']))
{
  $hm_action=$_GET['action'];
} else
{
  die ("操作被禁止>");
}

$post=$_POST;
include "./wp-config.php";
if ( get_magic_quotes_gpc() )
{
  $post = array_map('stripslashes_deep', $_POST );
}

if ($post_ping) require_once("./wp-includes/comment.php");

if ( !class_exists("Snoopy") )	require_once ("./wp-includes/class-snoopy.php");
function hm_debug_info($msg)
{
  global $logDebugInfo;
  if ($logDebugInfo) echo $msg."<br/>\n";
}

function hm_tranlate($text)
{
  $htmlret = $text;
  return $htmlret;
}

function hm_print_catogary_list()
{
  $cats = get_categories("hierarchical=0&hide_empty=0");
  foreach ((array) $cats as $cat) {
    echo '<<<'.$cat->cat_ID.'--'.$cat->cat_name.'>>>';
  }
}

function hm_get_post_time($post_next="normal")
{
  global $time_interval;
  global $wpdb;

  $time_difference = absint(get_option('gmt_offset')) * 3600;
  $tm_now = time()+$time_difference;

  if ($post_next=='now') {
    $tm=time()+$time_difference;
  } else { //if ($post_next=='next')
    $tm = time()+$time_difference;
    $posts = $wpdb->get_results( "SELECT post_date FROM $wpdb->posts ORDER BY post_date DESC limit 0,1" );
    foreach ( $posts as $post ) {
      $tm=strtotime($post->post_date);
    }
  }
  return $tm+$time_interval;
}

function hm_publish_pending_post()
{
  global $wpdb;
  $tm_now = time()+absint(get_option('gmt_offset')) * 3600;
  $now_date=date("Y-m-d H:i:s",$tm_now);
  $wpdb->get_results( "UPDATE $wpdb->posts set `post_status`='publish' WHERE `post_status`='pending' and `post_date`<'$now_date'" );
}

function hm_add_category($post_category)
{
  if (!function_exists('wp_insert_category')) @include "./wp-admin/includes/taxonomy.php";
  global $wpdb;
  $post_category_new=array();
  $post_category_list= array_unique(explode(",",$post_category));
  foreach ($post_category_list as $category) {
    $cat_ID =intval($category);
    if ($cat_ID==0) {
      $category = $wpdb->escape($category);
      $cat_ID = wp_insert_category(array('cat_name' => $category));
      $cat_ID = get_category_by_slug($category);
      array_push($post_category_new,$cat_ID ->term_id);
    } else {
      array_push($post_category_new,$cat_ID);
    }
  }
  return $post_category_new;
}

function hm_strip_slashes($str)
{
  if (!get_magic_quotes_gpc()) {
    return stripslashes($str);
  } else {
    return $str;
  }
}

function hm_strip_slashes_new($string, $force = 0)
{
  !defined('MAGIC_QUOTES_GPC') && define('MAGIC_QUOTES_GPC', get_magic_quotes_gpc());
  if (!MAGIC_QUOTES_GPC || $force) {
    if (is_array($string)) {
      foreach($string as $key => $val) {
        $string[$key] = daddslashes($val, $force);
      }
    } else {
      $string = addslashes($string);
    }
  }
  return $string;
}

function hm_do_save_post($post_detail)
{
  global $post_author,$post_ping,$post_status,$translate_slug,$autoAddCategory,$post_next;
  extract($post_detail);

  $post_title=trim(hm_strip_slashes($post_title));
  $post_name=$post_title;
  if ($translate_slug) $post_name=hm_tranlate($post_name);
  $post_name=sanitize_title( $post_name);
  if ( strlen($post_name) < 2 ) $post_name="";

  $post_content=hm_strip_slashes($post_content);

  $tags_input=str_replace("|||",",",$tags_input);

  if (isset($post_date) &&$post_date) {
    $post_date_gmt=$post_date;
  } else {
    $tm=hm_get_post_time($post_next);
    $time_difference = absint(get_option('gmt_offset')) * 3600;
    $post_date=date("Y-m-d H:i:s",$tm);
    $post_date_gmt = gmdate('Y-m-d H:i:s', $tm-$time_difference);
    if ($post_status=='next') $post_status='publish';
  }

  $post_category=hm_add_category($post_category);

  $post_data = compact('post_author', 'post_date', 'post_date_gmt', 'post_content', 'post_title', 'post_category', 'post_status', 'post_excerpt', 'post_name','tags_input');
  $post_data = add_magic_quotes($post_data);
  $postID = wp_insert_post($post_data);

  if (!empty($post_meta_list)) {
    $post_meta_array= array_unique(explode("|||",$post_meta_list));
    foreach($post_meta_array as $ppm) {
      $pp2=explode("$$",$ppm);
      if (!empty($pp2[0])&&!empty($pp2[1])) add_post_meta($postID,$pp2[0],$pp2[1],true);
    }
  }

  if ($post_ping)  generic_ping();
}

if ($hm_action== "list")
{
  hm_print_catogary_list();
}
elseif($hm_action== "update")
{
  hm_publish_pending_post();
}
elseif($hm_action == "save" /*&&isset($_GET['secret'])&&$_GET['secret'] == $secretWord*/)
{
  if (isset($secretWord)&&($secretWord!=false)) {
    if (!isset($_GET['secret']) || $_GET['secret'] != $secretWord) {
      die('接口密码错误，请修改配置文件或者修改发布参数，保持两者统一。');
    }
  }

  //$post=$_POST;
  extract($post);
  if ($post_title=='[标题]'||$post_title=='') die('标题为空');
  if ($post_content=='[内容]'||$post_content=='') die('内容为空');
  if ($post_category=='[分类id]'||$post_category=='') die('分类id为空');
  if ($tag=='[SY_tag]') {
    $tag='';
  }
  if (!isset($post_date) ||strlen($post_date)<8) $post_date=false;
  if (!isset($post_author)) $post_author=$post_author_default;
  if (!isset($post_meta_list)) $post_meta_list="";

  hm_do_save_post(array('post_title'=>$post_title,
                        'post_content'=>$post_content,
                        'post_category'=>$post_category,
                        'tags_input'=>$tag,
                        'post_date'=>$post_date,
                        'post_author'=>$post_author,
                        'post_meta_list'=>$post_meta_list));
  echo '发布成功';
}
else
{
  echo '非法操作['.$hm_action.']';
}
?>