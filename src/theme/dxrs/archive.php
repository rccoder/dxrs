<?php
/**
 * The template for displaying archive pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package rsah
 */

get_header(); ?>

	<section id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<div> <?php if (function_exists('dimox_breadcrumbs')) dimox_breadcrumbs(); ?> </div>
		<div id="main-left-container">
		<?php if ( have_posts() ) : ?>
		<article class="page-content">
			<header class="page-header">
				<h1 class="page-title">
					<?php
						if ( is_category() ) :
							single_cat_title();

						elseif ( is_tag() ) :
							single_tag_title();

						endif;
					?>
				</h1>
				<?php
					// Show an optional term description.
					$term_description = term_description();
					if ( ! empty( $term_description ) ) :
						// printf( '<div class="taxonomy-description">%s</div>', $term_description );
					endif;
				?>
			</header><!-- .page-header -->
			<ul class="article-list">
			<?php /* Start the Loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>
				<?php $tags = get_the_tags(get_the_ID());?>
				<li>
					<p class="link-title">
						<a href="<?=the_permalink();?>" alt="<?=the_title()?>" target="_blank"><?=the_title()?></a>
					</p>

					<span class="link-date">(<?php echo get_post_time('Y-m-d');?>)</span>
				</li>
			<?php endwhile; ?>
			</ul>
			<?php wp_pagenavi(); ?>
			
		<?php else : ?>

			<?php get_template_part( 'content', 'none' ); ?>

		<?php endif; ?>
			</article>
		</div>
		<!--
		<div id="main-right-container">
			<div class="right-item">
				<img src="<?php echo get_stylesheet_directory_uri()?>/imgs/03.jpg">
			</div>
		</div>
	-->
		</main><!-- #main -->
	</section><!-- #primary -->

<?php get_footer(); ?>
