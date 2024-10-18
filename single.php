<?php
/**
 * The Template for displaying all single posts.
 *
 * @package GeneratePress
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

get_header();
?>

	<div <?php generate_do_attr( 'content' ); ?>>
		<main <?php generate_do_attr( 'main' ); ?>>
			<?php
			/**
			 * generate_before_main_content hook.
			 *
			 * @since 0.1
			 */
			do_action( 'generate_before_main_content' );

			if ( generate_has_default_loop() ) {
				while ( have_posts() ) :
					the_post();

					// Inicio del contenido personalizado
					?>
					<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
						<div class="inside-article">
							<?php
							/**
							 * generate_before_content hook.
							 *
							 * @since 0.1
							 *
							 * @hooked generate_featured_page_header_inside_single - 10
							 */
							do_action( 'generate_before_content' );
							?>

							<header class="entry-header">
								<?php
								/**
								 * generate_before_entry_title hook.
								 *
								 * @since 0.1
								 */
								do_action( 'generate_before_entry_title' );

								if ( generate_show_title() ) {
									the_title( '<h1 class="entry-title" itemprop="headline">', '</h1>' );
								}

								/**
								 * generate_after_entry_title hook.
								 *
								 * @since 0.1
								 *
								 * @hooked generate_post_meta - 10
								 */
								do_action( 'generate_after_entry_title' );
								?>
							</header>

							<?php
							/**
							 * generate_after_entry_header hook.
							 *
							 * @since 0.1
							 *
							 * @hooked generate_post_image - 10
							 */
							do_action( 'generate_after_entry_header' );

							// Mostrar campos personalizados si existen
							$custom_fields = get_post_custom();
							if (!empty($custom_fields)) {
								echo '<div class="custom-fields">';
								foreach ($custom_fields as $key => $value) {
									// Excluir campos internos de WordPress (que comienzan con '_')
									if (substr($key, 0, 1) !== '_') {
										echo '<p><strong>' . esc_html(ucwords(str_replace('_', ' ', $key))) . ':</strong> ' . esc_html($value[0]) . '</p>';
									}
								}
								echo '</div>';
							}

							?>

							<div class="entry-content" itemprop="text">
								<?php
								the_content();

								wp_link_pages(
									array(
										'before' => '<div class="page-links">' . __( 'Pages:', 'generatepress' ),
										'after'  => '</div>',
									)
								);
								?>
							</div>

							<?php
							/**
							 * generate_after_entry_content hook.
							 *
							 * @since 0.1
							 *
							 * @hooked generate_footer_meta - 10
							 */
							do_action( 'generate_after_entry_content' );

							/**
							 * generate_after_content hook.
							 *
							 * @since 0.1
							 */
							do_action( 'generate_after_content' );
							?>
						</div>
					</article>
					<?php
					// Fin del contenido personalizado

				endwhile;
			}

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