<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package dxrs
 */

get_header(); ?>

	<div id="content-top-container">
		<div id="slide-show-container">
			<div id="slide-show">
				
				<?php if ( function_exists( 'meteor_slideshow' ) ) { meteor_slideshow(); } ?>

			</div>
		</div>
	</div>
	<div id="primary" class="content-area content-width">
		<main id="main" class="site-main" role="main">
			<div id="main-left-container">
				<div class="left-container-left">
					<div class="main-block">
						<?php $cat_slug = '新闻' ?>
						<?php $cat = get_category_by_slug($cat_slug); ?>
						<div class="title">
							<h3><?php echo $cat->name?></h3>
						</div>
						<div class="content">
							<ul>
							<?php $ps = get_posts(array('category'=>$cat->term_id, 'posts_per_page'=>10) ); ?>
							<?php foreach ($ps as $p) : ?>
								<?php $tags = get_the_tags($p->ID);?>
								<li>
									<p class="link-title link-index-title">
										<a href="<?=get_permalink($p->ID);?>" title="<?=$p->post_title?>" target="_blank"> <img src="<?php echo get_stylesheet_directory_uri()?>/imgs/biaohao.jpg"><?=$p->post_title?></a>
										<span class="link-date">【<?=substr($p->post_date, 5, 5);?>】</span>
									</p>

								</li>
							<?php endforeach; ?>
							</ul>
						</div>
					</div>
				</div>
				<div class="left-container-right">
					<div class="main-block">
						<?php $cat_slug = '通告' ?>
						<?php $cat = get_category_by_slug($cat_slug); ?>
						<div class="title">
							<h3><?php echo $cat->name?></h3>
						</div>
						<div class="content">
							<ul>
							<?php $ps = get_posts(array('category'=>$cat->term_id, 'posts_per_page'=>10) ); ?>
							<?php foreach ($ps as $p) : ?>
								<?php $tags = get_the_tags($p->ID);?>
								<li>
									<p class="link-title link-index-title">
										<a href="<?=get_permalink($p->ID);?>" title="<?=$p->post_title?>" target="_blank"><img src="<?php echo get_stylesheet_directory_uri()?>/imgs/biaohao.jpg"><?=$p->post_title?></a>
										<span class="link-date">【<?=substr($p->post_date, 5, 5);?>】</span>
									</p>

								</li>
							<?php endforeach; ?>
							</ul>
						</div>
					</div>
				</div>
				<div style="clear:both;"></div>

				<div class="banner">
					 <?php if ( function_exists( 'useful_banner_manager_banners' ) ) { useful_banner_manager_banners( '1,2,3,4,5,6', 3 ); } ?>
				</div>
			</div>

			<div id="main-right-container">
				<!--
				<div class="right-item">
					<img src="<?php echo get_stylesheet_directory_uri()?>/imgs/03.jpg">
				</div>
				-->
				<div class="right-item">
					<iframe width="300" height="320" class="share_self" frameborder="0" scrolling="no" src="http://widget.weibo.com/weiboshow/index.php?language=&amp;width=0&amp;height=320&amp;fansRow=1&amp;ptype=1&amp;speed=0&amp;skin=1&amp;isTitle=1&amp;noborder=1&amp;isWeibo=1&amp;isFans=0&amp;uid=2354193904&amp;verifier=fc16074b&amp;dpc=1"></iframe>
				</div>
				<div class="right-item">
					<div class="bdsharebuttonbox">
    <a href="#" class="bds_more" data-cmd="more"></a>
    <a href="#" class="bds_qzone" data-cmd="qzone" title="分享到QQ空间"></a>
    <a href="#" class="bds_tsina" data-cmd="tsina" title="分享到新浪微博"></a>
    <a href="#" class="bds_tqq" data-cmd="tqq" title="分享到腾讯微博"></a>
    <a href="#" class="bds_renren" data-cmd="renren" title="分享到人人网"></a>
    <a href="#" class="bds_weixin" data-cmd="weixin" title="分享到微信"></a>
</div>
				</div>
			</div>

			<div style="clear:both;"></div>
		</main><!-- #main -->
	</div><!-- #primary -->


<?php get_sidebar();?>
<?php get_footer(); ?>
