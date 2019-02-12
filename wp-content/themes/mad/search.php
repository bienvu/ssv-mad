<?php get_header(); ?>
	<main role="main" class="main-content page-search">
		<!-- section -->
		<div class="page-title">
			<h1><?php echo sprintf( __( '%s Search Results for ', 'sentiustheme' ), $wp_query->found_posts ); echo get_search_query(); ?></h1>
		</div>
		<section class="container">
			<div class="search-wrap">
				<?php get_template_part('templates/search-default'); ?>
			</div>
			<?php get_template_part('templates/loop'); ?>
			<?php get_template_part('templates/pagination'); ?>
		</section>
		<!-- /section -->
	</main>
<?php get_footer(); ?>
