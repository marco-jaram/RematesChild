<?php
/**
 * Template Name: Archivo de Casas
 * Template Post Type: page
 *
 * @package GeneratePress
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

get_header(); ?>

	<div <?php generate_do_attr( 'content' ); ?>>
		<main <?php generate_do_attr( 'main' ); ?>>
			<?php
			/**
			 * generate_before_main_content hook.
			 *
			 * @since 0.1
			 */
			do_action( 'generate_before_main_content' );

			?>
			<header class="page-header">
				<h1 class="page-title"><?php echo get_the_title(); ?></h1>
			</header>

			<?php
			$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
			$args = array(
				'post_type' => 'casas',
				'posts_per_page' => 20,
				'paged' => $paged
			);
			$casas_query = new WP_Query($args);

			if ($casas_query->have_posts()) :
				echo '<div class="casas-grid">';
				while ($casas_query->have_posts()) : $casas_query->the_post();
					?>
					<article id="post-<?php the_ID(); ?>" <?php post_class('casa-item'); ?>>
						<header class="entry-header">
							<?php the_title('<h2 class="entry-title"><a href="' . esc_url(get_permalink()) . '" rel="bookmark">', '</a></h2>'); ?>
						</header>

						<?php if (has_post_thumbnail()) : ?>
							<div class="casa-thumbnail">
								<a href="<?php the_permalink(); ?>">
									<?php the_post_thumbnail('medium'); ?>
								</a>
							</div>
						<?php endif; ?>

						<div class="casa-detalles">
							<p>Recámaras: <?php echo get_post_meta(get_the_ID(), 'recamaras', true); ?></p>
							<p>Baños: <?php echo get_post_meta(get_the_ID(), 'banios', true); ?></p>
							<p>Medios Baños: <?php echo get_post_meta(get_the_ID(), 'medios_banios', true); ?></p>
						</div>

						<div class="entry-summary">
							<?php the_excerpt(); ?>
						</div>
					</article>
					<?php
				endwhile;
				echo '</div>'; // Cierra .casas-grid

				// Paginación
				echo '<div class="pagination">';
				echo paginate_links(array(
					'total' => $casas_query->max_num_pages,
					'current' => $paged,
					'prev_text' => __('&laquo; Anterior'),
					'next_text' => __('Siguiente &raquo;'),
				));
				echo '</div>';

			else :
				echo '<p>No se encontraron casas.</p>';
			endif;

			wp_reset_postdata();

			/**
			 * generate_after_main_content hook.
			 *
			 * @since 0.1
			 */
			do_action( 'generate_after_main_content' );
			?>
		</main>
	</div>

	<?php
	/**
	 * generate_after_primary_content_area hook.
	 *
	 * @since 2.0
	 */
	do_action( 'generate_after_primary_content_area' );

	generate_construct_sidebars();

	get_footer();
?>