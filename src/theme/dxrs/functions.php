<?php
/**
 * dxrs functions and definitions
 *
 * @package dxrs
*
  *function devework_replace_open_sans() {
 *       wp_dequeue_style( 'twentyfourteen-lato' );
  *      wp_deregister_style('twentyfourteen-lato');
   *     wp_register_style( 'twentyfourteen-lato', '//fonts.useso.com/css?family=Lato%3A300%2C400%2C700%2C900%2C300italic%2C400italic%2C700italic' );
   *     wp_enqueue_style( 'twentyfourteen-lato');
    *    wp_deregister_style('open-sans');
    *    wp_register_style( 'open-sans', '//fonts.useso.com/css?family=Open+Sans:300italic,400italic,600italic,300,400,600' );
    *    wp_enqueue_style( 'open-sans');
*}
*add_action( 'wp_enqueue_scripts', 'devework_replace_open_sans' );
*add_action('admin_enqueue_scripts', 'devework_replace_open_sans');
*/
/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 640; /* pixels */
}

if ( ! function_exists( 'rsah_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function rsah_setup() {

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on rsah, use a find and replace
	 * to change 'rsah' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'rsah', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );
    add_theme_support( 'post-thumbnails' );
	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	//add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'rsah' ),
		'friend-links' => 'Friend Links',
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
	) );

	/*
	 * Enable support for Post Formats.
	 * See http://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'aside', 'image', 'video', 'quote', 'link'
	) );

	// Setup the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'rsah_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );
}
endif; // rsah_setup
add_action( 'after_setup_theme', 'rsah_setup' );

/**
 * Register widget area.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
function rsah_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Sidebar', 'rsah' ),
		'id'            => 'sidebar-1',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );
}
add_action( 'widgets_init', 'rsah_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function rsah_scripts() {
	wp_enqueue_style( 'rsah-style', get_stylesheet_uri() );

	wp_enqueue_script( 'rsah-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20120206', true );

	wp_enqueue_script( 'rsah-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'rsah_scripts' );


//postviews
function get_post_views ($post_id) {

    $count_key = 'views';
    $count = get_post_meta($post_id, $count_key, true);

    if ($count == '') {
        delete_post_meta($post_id, $count_key);
        add_post_meta($post_id, $count_key, '0');
        $count = '0';
    }
    return number_format_i18n($count);
}

function set_post_views () {
    global $post;

    $post_id = $post -> ID;
    $count_key = 'views';
    $count = get_post_meta($post_id, $count_key, true);

    if (is_single() || is_page()) {

        if ($count == '') {
            delete_post_meta($post_id, $count_key);
            add_post_meta($post_id, $count_key, '0');
        } else {
            update_post_meta($post_id, $count_key, $count + 1);
        }
    }

}
add_action('get_header', 'set_post_views');


function dimox_breadcrumbs() {

  $show_sth_breadcrumbs = array('news', 'notice', 'lecture', 'conference', 'information', 'work', 'communication');

  $delimiter = '&gt;';
  $name = '首页'; //text for the 'Home' link
  $currentBefore = '<span>';
  $currentAfter = '</span>';

  if ( !is_home() && !is_front_page() || is_paged() ) {

    echo '<div id="crumbs">';

    global $post;
    $home = get_bloginfo('url');
    echo '当前位置：<a href="' . $home . '">' . $name . '</a> ' . $delimiter . ' ';

    if ( is_category() ) {
      global $wp_query;
      $cat_obj = $wp_query->get_queried_object();
      $thisCat = $cat_obj->term_id;
      $thisCat = get_category($thisCat);
      $parentCat = get_category($thisCat->parent);
      if ($thisCat->parent != 0) echo(get_category_parents($parentCat, TRUE, ' ' . $delimiter . ' '));
      if(in_array($thisCat->slug, $show_sth_breadcrumbs)){
        echo '<a href="' . home_url('archives/category/notice') . '">学会动态</a>' . ' ' . $delimiter . ' ';
      }
      echo $currentBefore . '';
      single_cat_title();
      echo '' . $currentAfter;

    } elseif ( is_day() ) {
      echo '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $delimiter . ' ';
      echo '<a href="' . get_month_link(get_the_time('Y'),get_the_time('m')) . '">' . get_the_time('F') . '</a> ' . $delimiter . ' ';
      echo $currentBefore . get_the_time('d') . $currentAfter;

    } elseif ( is_month() ) {
      echo '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $delimiter . ' ';
      echo $currentBefore . get_the_time('F') . $currentAfter;

    } elseif ( is_year() ) {
      echo $currentBefore . get_the_time('Y') . $currentAfter;

    } elseif ( is_single() ) {
      $cat = get_the_category(); $cat = $cat[0];
      if(in_array($cat->slug, $show_sth_breadcrumbs)){
        echo '<a href="' . home_url('archives/category/notice') . '">学会动态</a>' . ' ' . $delimiter . ' ';
      }
      echo get_category_parents($cat, TRUE, ' ' . $delimiter . ' ');
      echo $currentBefore;
      // the_title();
      echo "正文";
      echo $currentAfter;

    } elseif ( is_page() && !$post->post_parent ) {
      echo $currentBefore;
      the_title();
      // echo "正文";
      echo $currentAfter;

    } elseif ( is_page() && $post->post_parent ) {
      $parent_id  = $post->post_parent;
      $breadcrumbs = array();
      while ($parent_id) {
        $page = get_page($parent_id);
        $breadcrumbs[] = '<a href="' . get_permalink($page->ID) . '">' . get_the_title($page->ID) . '</a>';
        $parent_id  = $page->post_parent;
      }
      $breadcrumbs = array_reverse($breadcrumbs);
      foreach ($breadcrumbs as $crumb) echo $crumb . ' ' . $delimiter . ' ';
      echo $currentBefore;
      the_title();
      echo $currentAfter;

    } elseif ( is_search() ) {
      echo $currentBefore . 'Search results for &#39;' . get_search_query() . '&#39;' . $currentAfter;

    } elseif ( is_tag() ) {
      global $wp_query;
      $tag_obj = $wp_query->get_queried_object();
      $thisTag = $tag_obj->term_id;
      $thisTag = get_tag($thisTag);
      if(in_array($thisTag->slug, $show_sth_breadcrumbs)){
        echo '<a href="' . home_url('archives/category/notice') . '">学会动态</a>' . ' ' . $delimiter . ' ';
      }
      echo $currentBefore;
      single_tag_title();
      echo $currentAfter;

    } elseif ( is_author() ) {
       global $author;
      $userdata = get_userdata($author);
      echo $currentBefore . 'Articles posted by ' . $userdata->display_name . $currentAfter;

    } elseif ( is_404() ) {
      echo $currentBefore . 'Error 404' . $currentAfter;
    }

    if ( get_query_var('paged') ) {
      if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ' (';
      echo __('Page') . ' ' . get_query_var('paged');
      if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ')';
    }

    echo '</div>';

  }
}

/**
 * 会员信息列表
 */
function _list_member_shorcode_func(){
  $con = array(
    'orderby' => 'ID',
    'order' => 'ASC',
    'role' => 'subscriber',
    );
  $members = get_users($con);
  echo '<table>';
  echo '<thead>';
  echo '<tr>';
  echo '<th>姓名</th>';
  echo '<th>工作单位</th>';
  echo '<th>电子邮箱</th>';
  echo '<th>固定电话</th>';
  echo '</tr>';
  echo '</thead>';
  foreach ($members as $p) {
    if($p->get('active') == '0')
      continue;
  // var_dump($p);
    echo '<tr>';
    echo '<td>' . $p->first_name . $p->last_name . '</td>';
    echo '<td>' . get_user_meta($p->ID, 'pie_text_22', true) . '</td>';
    echo '<td>' . antispambot($p->user_email) . '</td>';
    echo '<td>' . get_user_meta($p->ID, 'pie_phone_30', true) . '</td>';
    echo '</tr>';

  }
  echo '</table>';
}

/**
 * 会员信息列表
 */
function list_member_shorcode_func(){
  if ( ! is_user_logged_in() ){
    redirect_shorcode_func(array('to'=>'login'));
  }
  $con = array(
    'orderby' => 'ID',
    'order' => 'ASC',
    'role' => 'subscriber',
    );
  $members = get_users($con);
  echo '<div id="member-list"><ul>';
  foreach ($members as $p) {
    if($p->get('active') == '0')
      continue;

    echo '<li>';

    $img_src = $p->pie_profile_pic_44 == '' ? get_stylesheet_directory_uri().'/imgs/photo.jpg' : $p->pie_profile_pic_44 ;
    echo '<dt><img src="' . $img_src . '"></dt>';

    echo '<dl>';
    echo '<dd><a href="'.home_url('/member/info?id='.$p->ID).'" target="_blank"><span class="name">' . $p->first_name . $p->last_name . '</span></a></dd>';
    echo '<dd><span class="title">所在单位</span><span>' . get_user_meta($p->ID, 'pie_text_22', true) . '</span></dd>';
    echo '<dd><span class="title">电子邮箱</span><span>' . antispambot($p->user_email) . '</span></dd>';
    echo '</dl>';

    echo '</li>';

  }
  echo '</ul></div>';
}

add_shortcode('list_member', 'list_member_shorcode_func');

/**
 * 会员信息
 */
function show_member_info_shorcode_func(){
  if ( ! is_user_logged_in() ){
    redirect_shorcode_func(array('to'=>'login'));
  }

  $id = isset($_GET['id']) ? $_GET['id'] : -1;
  $u = get_user_by('id', $id);
  if($u === FALSE){
    echo "<strong>没有此用户信息。</strong>";
    return;
  }

  echo '<div > <div class="member-info-left">';

  $img_src = $u->pie_profile_pic_44 == '' ? get_stylesheet_directory_uri().'/imgs/photo.jpg' : $u->pie_profile_pic_44 ;
  echo '<div class="avatar"><img src="' . $img_src . '"></div>';
  echo '<div class="caption">
		<p class="name">' . $u->first_name . $u->last_name . '</p>
		<p class="title">' . $u->pie_text_22 . '</p>
	</div>';

  echo '</div> <div class="member-info-right">';
  echo '<ul>';
    echo '<li><label class="title">姓名：</label><span class="content">' . $u->first_name . $u->last_name . '</span></li>';
    echo '<li><label class="title">性别：</label><span class="content">' . $u->pie_radio_10[0] . '</span></li>';
    echo '<li><label class="title">党派：</label><span class="content">' . $u->pie_text_12 . '</span></li>';
    echo '<li><label class="title">民族：</label><span class="content">' . $u->pie_text_13 . '</span></li>';
    echo '<li><label class="title">专业：</label><span class="content">' . $u->pie_text_21 . '</span></li>';
    echo '<li><label class="title">学历：</label><span class="content">' . $u->pie_dropdown_18 . '</span></li>';
    echo '<li><label class="title">学位：</label><span class="content">' . $u->pie_dropdown_20 . '</span></li>';
    echo '<li><label class="title">职称：</label><span class="content">' . $u->pie_text_19 . '</span></li>';
    echo '<li><label class="title">工作单位：</label><span class="content">' . $u->pie_text_22 . '</span></li>';
    echo '<li><label class="title">行政职务：</label><span class="content">' . $u->pie_text_23 . '</span></li>';
    echo '<li><label class="title">固定电话：</label><span class="content">' . $u->pie_phone_30 . '</span></li>';
    echo '<li><label class="title">电子邮箱：</label><span class="content">' . antispambot($u->user_email) . '</span></li>';
    //echo '<li><label class="title">：</label><span>' . $u-> . '</span></li>';
  echo '</ul>';
  echo '</div> </div>';
}

add_shortcode('show_member_info', 'show_member_info_shorcode_func');

/**
 * 页面跳转短代码
 */

function redirect_shorcode_func($attr){
  wp_redirect( home_url($attr['to']), 301);
  exit();
  // echo "< script language='javascript' type='text/javascript'>";
  // echo "window.location.href='$url'";
  // echo "< /script>";
}

add_shortcode('redirect', 'redirect_shorcode_func');

function remove_open_sans() {
wp_deregister_style( 'open-sans' );
wp_register_style( 'open-sans', false );
wp_enqueue_style('open-sans','');
}
add_action( 'init', 'remove_open_sans' );
/*移除版本*/
function remove_wordpress_version() {
 return '';
 }
 add_filter('the_generator', 'remove_wordpress_version');
//关掉更新
 add_filter( 'automatic_updater_disabled', '__return_true' );
/**
 * Implement the Custom Header feature.
 */
//require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

/**
 * Load friend links walker class file.
 */
require get_template_directory() . '/inc/friend-links-walker.php';

