<?php
/**
 * The template for displaying all single posts.
 *
 * @package rsah
 */

get_header(); ?>

	<div id="single-primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<div> <?php if (function_exists('dimox_breadcrumbs')) dimox_breadcrumbs(); ?> </div>
		<div id="main-left-container">
		<?php while ( have_posts() ) : the_post(); ?>

			<?php get_template_part( 'content', 'single' ); ?>

		<?php endwhile; // end of the loop. ?>
		<div class="bdsharebuttonbox bdsharebuttonbox-single">
		    <a href="#" class="bds_more" data-cmd="more"></a>
		    <a href="#" class="bds_qzone" data-cmd="qzone" title="分享到QQ空间"></a>
		    <a href="#" class="bds_tsina" data-cmd="tsina" title="分享到新浪微博"></a>
		    <a href="#" class="bds_tqq" data-cmd="tqq" title="分享到腾讯微博"></a>
		    <a href="#" class="bds_renren" data-cmd="renren" title="分享到人人网"></a>
		    <a href="#" class="bds_weixin" data-cmd="weixin" title="分享到微信"></a>
		</div>
		</div>
		<!--
		<div id="main-right-container">
			<div class="right-item">
				<img src="<?php echo get_stylesheet_directory_uri()?>/imgs/03.jpg">
			</div>
		</div>
	-->
		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_footer(); ?>
