<?php
/**
 * Template Name: Inmuebles
 * 
 * Este template muestra todas las entradas de inmuebles en forma de cards responsive y enlazadas.
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

        // Argumentos para la consulta de inmuebles
        $args = array(
            'post_type' => 'inmueble',
            'posts_per_page' => -1, // Muestra todos los inmuebles
        );
        // La consulta
        $query = new WP_Query($args);

        // El loop
        if ($query->have_posts()) :
            echo '<div class="inmuebles-container">';
            while ($query->have_posts()) : $query->the_post();
                // Obtener los campos personalizados
                $precio = get_post_meta(get_the_ID(), '_inmueble_precio', true);
                $ubicacion = get_post_meta(get_the_ID(), '_inmueble_ubicacion', true);
                $tamano = get_post_meta(get_the_ID(), '_inmueble_tamano', true);
                $num_recamaras = get_post_meta(get_the_ID(), '_inmueble_num_recamaras', true);
                $num_banos = get_post_meta(get_the_ID(), '_inmueble_num_banos', true);
                $estacionamiento = get_post_meta(get_the_ID(), '_inmueble_estacionamiento', true);
                $fecha_remate = get_post_meta(get_the_ID(), '_inmueble_fecha_remate', true);
                if ($fecha_remate) {
                    $date = DateTime::createFromFormat('Y-m-d', $fecha_remate);
                    if ($date) {
                        $fecha_remate = $date->format('d-m-Y');
                    }
                }
                ?>
                <a href="<?php the_permalink(); ?>" class="inmueble-card-link">
                    <div class="inmueble-card">
                        <div class="inmueble-imagen">
                            <?php 
                            if (has_post_thumbnail()) {
                                the_post_thumbnail('medium_large');
                            } else {
                                echo '<img src="' . esc_url(get_stylesheet_directory_uri() . '/img/no-image.jpg') . '" alt="No hay imagen disponible">';
                            }
                            ?>
                        </div>
                        <div class="inmueble-info">
                            <h2><?php the_title(); ?></h2>
                            <p class="precio">$ <?php echo esc_html($precio); ?></p>
                            <p class="ubicacion"><?php echo esc_html($ubicacion); ?></p>
                            <p class="detalles">
                                <?php echo esc_html($tamano); ?> m² tot. | 
                                <?php echo esc_html($num_recamaras); ?> rec. | 
                                <?php echo esc_html($num_banos); ?> baño | 
                                <?php echo esc_html($estacionamiento); ?> estac.
                            </p>
                            <p class="descripcion"><?php echo wp_trim_words(get_the_content(), 20); ?></p>
                            <p class="fecha-remate">Fecha de remate: <?php echo esc_html($fecha_remate); ?></p>
                        </div>
                    </div>
                </a>
            <?php
            endwhile;
            echo '</div>';
            wp_reset_postdata();
        else :
            echo '<p>No se encontraron inmuebles.</p>';
        endif;

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