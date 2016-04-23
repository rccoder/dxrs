<?php
/**
 * The template for displaying search results pages.
 *
 * @package rsah
 */

get_header(); ?>

	<section id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php if ( have_posts() ) : ?>
			<article class="page-content">
			<header class="page-header">
				<h1 class="page-title">
				<?php printf( __( 'Search Results for: %s', 'rsah' ), '<span>' . get_search_query() . '</span>' ); ?>
				</h1>
			</header><!-- .page-header -->
			<ul class="article-list">
			<?php /* Start the Loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>
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

		</main><!-- #main -->
	</section><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
