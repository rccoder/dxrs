<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package dxrs
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="renderer" content="webkit">
<meta http-equiv="Cache-Control" content="no-siteapp" />
<title><?php wp_title( '|', true, 'right' ); ?></title>
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<script type="text/javascript" src="<?php echo get_stylesheet_directory_uri()?>/js/simple-share.min.js"></script>
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="hfeed site">
<div id="content-wrap">
	<a class="skip-link screen-reader-text" href="#content"><?php _e( 'Skip to content', 'rsah' ); ?></a>

	<header id="masthead" class="site-header" role="banner">
		<div class="site-branding content-width">
			<div class="site-title">

				<!-- <?php bloginfo( 'name' ); ?> -->
					<center>
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
						<img id="site-logo" src="<?php echo get_stylesheet_directory_uri()?>/imgs/logo.jpg">
					</a>
					</center>
					<div class="search-top">
						<span>共青团哈尔滨工业大学委员会</span>
						<form role="search" method="get" class="search-form" action="http://dxrs.hit.edu.cn/">
						<label>
							<span class="screen-reader-text"></span>
							<input type="search" class="search-field" value="" name="s" title="搜索：" />
						</label>
							<input type="submit" class="search-submit" value=""/>
						</form>
					</div>
			</div>
			<!-- <h2 class="site-description"><?php bloginfo( 'description' ); ?></h2> -->
		</div>

		<nav id="site-navigation" class="main-navigation" role="navigation">

			<div id="main-nav" class="main-navbar">
				<?php wp_nav_menu( array( 'theme_location' => 'primary', 'container_class' => 'content-width', 'container_id' => 'main-nav' ) ); ?>
			</div>
		</nav><!-- #site-navigation -->
	</header><!-- #masthead -->

	<div id="content" class="site-content">
