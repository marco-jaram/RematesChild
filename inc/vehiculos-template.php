<?php
/**
 * Template Name: Vehiculos
 * 
 * Este template muestra todas las entradas de vehículos en forma de cards responsive y enlazadas.
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

get_header(); ?>

<div <?php generate_do_attr('content'); ?>>
    <main <?php generate_do_attr('main'); ?>>
        <?php
        /**
         * generate_before_main_content hook.
         *
         * @since 0.1
         */
        do_action('generate_before_main_content');

        // Argumentos para la consulta de vehículos
        $args = array(
            'post_type' => 'vehiculo',
            'posts_per_page' => -1, // Muestra todos los vehículos
        );
        // La consulta
        $query = new WP_Query($args);

        // El loop
        if ($query->have_posts()) :
            echo '<div class="vehiculos-container">';
            while ($query->have_posts()) : $query->the_post();
                // Obtener los campos personalizados
                $origen = get_post_meta(get_the_ID(), '_vehiculo_origen', true);
                $institucion_subastadora = get_post_meta(get_the_ID(), '_vehiculo_institucion_subastadora', true);
                $numero_lote = get_post_meta(get_the_ID(), '_vehiculo_numero_lote', true);
                $descripcion_corta = get_post_meta(get_the_ID(), '_vehiculo_descripcion_corta', true);
                $modelo = get_post_meta(get_the_ID(), '_vehiculo_modelo', true);
                $ano = get_post_meta(get_the_ID(), '_vehiculo_ano', true);
                $color = get_post_meta(get_the_ID(), '_vehiculo_color', true);
                $cilindros = get_post_meta(get_the_ID(), '_vehiculo_cilindros', true);
                $estado = get_post_meta(get_the_ID(), '_vehiculo_estado', true);
                $caracteristicas = get_post_meta(get_the_ID(), '_vehiculo_caracteristicas', true);
                $precio = get_post_meta(get_the_ID(), '_vehiculo_precio', true);
                ?>
                <a href="<?php the_permalink(); ?>" class="vehiculo-card-link">
                    <div class="vehiculo-card">
                        <div class="vehiculo-imagen">
                            <?php 
                            if (has_post_thumbnail()) {
                                the_post_thumbnail('medium_large');
                            } else {
                                echo '<img src="' . esc_url(get_stylesheet_directory_uri() . '/img/no-image.jpg') . '" alt="No hay imagen disponible">';
                            }
                            ?>
                        </div>
                        <div class="vehiculo-info">
                            <h2><?php the_title(); ?></h2>
                            <?php if ($institucion_subastadora) : ?>
                                <p class="institucion-subastadora"><?php echo esc_html($institucion_subastadora); ?></p>
                            <?php endif; ?>
                            
                            <?php if ($origen || $numero_lote) : ?>
                                <div class="origen-lote">
                                    <?php if ($origen) : ?>
                                        <span class="origen"><?php echo esc_html($origen); ?></span>
                                    <?php endif; ?>
                                    <?php if ($numero_lote) : ?>
                                        <span class="lote">Lote: <?php echo esc_html($numero_lote); ?></span>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>

                            <?php if ($precio) : ?>
                                <p class="precio">$ <?php echo number_format((float)$precio, 2); ?> MXN</p>
                            <?php endif; ?>

                            <div class="detalles-principales">
                                <?php if ($modelo || $ano) : ?>
                                    <p class="modelo-ano">
                                        <?php echo esc_html($modelo); ?> <?php echo $ano ? '| ' . esc_html($ano) : ''; ?>
                                    </p>
                                <?php endif; ?>
                                
                                <?php if ($color || $cilindros) : ?>
                                    <p class="color-cilindros">
                                        <?php echo $color ? esc_html($color) : ''; ?>
                                        <?php echo $cilindros ? '| ' . esc_html($cilindros) . ' cilindros' : ''; ?>
                                    </p>
                                <?php endif; ?>
                            </div>

                            <?php if ($estado) : ?>
                                <p class="estado">Estado: 
                                    <?php 
                                    switch ($estado) {
                                        case 'regular':
                                            echo 'Regular';
                                            break;
                                        case 'mal_estado':
                                            echo 'Mal Estado';
                                            break;
                                        case 'buen_estado':
                                            echo 'Buen Estado';
                                            break;
                                    }
                                    ?>
                                </p>
                            <?php endif; ?>

                            <?php if ($descripcion_corta) : ?>
                                <p class="descripcion-corta"><?php echo esc_html($descripcion_corta); ?></p>
                            <?php endif; ?>

                            <?php if (is_array($caracteristicas) && !empty($caracteristicas)) : ?>
                                <div class="caracteristicas">
                                    <ul>
                                        <?php foreach ($caracteristicas as $caracteristica) : ?>
                                            <li><?php echo esc_html($caracteristica); ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </a>
            <?php
            endwhile;
            echo '</div>';
            wp_reset_postdata();
        else :
            echo '<p>No se encontraron vehículos.</p>';
        endif;

        /**
         * generate_after_main_content hook.
         *
         * @since 0.1
         */
        do_action('generate_after_main_content');
        ?>
    </main>
</div>

<?php
/**
 * generate_after_primary_content_area hook.
 *
 * @since 2.0
 */
do_action('generate_after_primary_content_area');

generate_construct_sidebars();

get_footer();