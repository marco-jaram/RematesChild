<?php
/**
 * Template Name: Muebles
 * 
 * Este template muestra todas las entradas de muebles en forma de cards responsive y enlazadas.
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

        // Argumentos para la consulta de muebles
        $args = array(
            'post_type' => 'mueble',
            'posts_per_page' => -1, // Muestra todos los muebles
        );
        // La consulta
        $query = new WP_Query($args);

        // El loop
        if ($query->have_posts()) :
            echo '<div class="muebles-container">';
            while ($query->have_posts()) : $query->the_post();
                // Obtener los campos personalizados
                $institucion = get_post_meta(get_the_ID(), '_mueble_institucion', true);
                $fecha_subasta = get_post_meta(get_the_ID(), '_mueble_fecha_subasta', true);
                $tipo_mueble = get_post_meta(get_the_ID(), '_mueble_tipo', true);
                $descripcion_corta = get_post_meta(get_the_ID(), '_mueble_descripcion_corta', true);
                $numero_lote = get_post_meta(get_the_ID(), '_mueble_numero_lote', true);
                $cantidad = get_post_meta(get_the_ID(), '_mueble_cantidad', true);
                $marca = get_post_meta(get_the_ID(), '_mueble_marca', true);
                $serie = get_post_meta(get_the_ID(), '_mueble_serie', true);
                $valor_avaluo = get_post_meta(get_the_ID(), '_mueble_valor_avaluo', true);
                $monto_total = get_post_meta(get_the_ID(), '_mueble_monto_total', true);

                if ($fecha_subasta) {
                    $date = DateTime::createFromFormat('Y-m-d', $fecha_subasta);
                    if ($date) {
                        $fecha_subasta = $date->format('d-m-Y');
                    }
                }
                ?>
                <a href="<?php the_permalink(); ?>" class="mueble-card-link">
                    <div class="mueble-card">
                        <span class="badge-subasta">En Subasta</span>
                        <div class="mueble-imagen">
                            <?php 
                            if (has_post_thumbnail()) {
                                the_post_thumbnail('medium_large');
                            } else {
                                echo '<div class="placeholder-image">350 x 200</div>';
                            }
                            ?>
                        </div>
                        <div class="mueble-info">
                            <div class="institucion-fecha">
                                <h2><?php echo esc_html($institucion); ?></h2>
                                <p class="fecha">Fecha de Subasta: <?php echo esc_html($fecha_subasta); ?></p>
                            </div>
                            <p class="tipo-mueble"><?php echo esc_html($tipo_mueble); ?></p>
                            <p class="descripcion"><?php echo esc_html($descripcion_corta); ?></p>
                            <div class="lote-info">
                                <p class="numero-lote">Lote #<?php echo esc_html($numero_lote); ?></p>
                                <p class="cantidad"><?php echo esc_html($cantidad); ?> unidades</p>
                            </div>
                            <div class="specs">
                                <p>Marca: <?php echo esc_html($marca); ?></p>
                                <p>Serie: <?php echo esc_html($serie); ?></p>
                            </div>
                            <div class="precios">
                                <p class="avaluo">Valor Avalúo: $<?php echo number_format(floatval($valor_avaluo), 2); ?> MXN</p>
                                <p class="monto-total">Monto Total: $<?php echo number_format(floatval($monto_total), 2); ?> MXN</p>
                            </div>
                        </div>
                    </div>
                </a>
            <?php
            endwhile;
            echo '</div>';
            wp_reset_postdata();
        else :
            echo '<p>No se encontraron muebles.</p>';
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