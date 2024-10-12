<?php
/*
 * Template Name: Template Vehículos
 * Template Post Type: page
 */

get_header();
?>

<div id="primary" class="content-area">
    <main id="main" class="site-main">
        <?php
        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
        $args = array(
            'post_type' => 'vehiculo',
            'posts_per_page' => 10,
            'paged' => $paged
        );
        $query = new WP_Query($args);

        if ($query->have_posts()) :
            echo '<div class="vehiculos-grid">';
            while ($query->have_posts()) : $query->the_post();
                ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    <header class="entry-header">
                        <?php the_title(sprintf('<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url(get_permalink())), '</a></h2>'); ?>
                    </header>

                    <?php if (has_post_thumbnail()) : ?>
                        <div class="entry-thumbnail">
                            <?php the_post_thumbnail('medium'); ?>
                        </div>
                    <?php endif; ?>

                    <div class="entry-content">
                        <?php
                        $marca = get_post_meta(get_the_ID(), '_marca', true);
                        $modelo = get_post_meta(get_the_ID(), '_modelo', true);
                        $año = get_post_meta(get_the_ID(), '_año', true);
                        ?>
                        <p><strong><?php _e('Marca:', 'generatepress-child'); ?></strong> <?php echo esc_html($marca); ?></p>
                        <p><strong><?php _e('Modelo:', 'generatepress-child'); ?></strong> <?php echo esc_html($modelo); ?></p>
                        <p><strong><?php _e('Año:', 'generatepress-child'); ?></strong> <?php echo esc_html($año); ?></p>
                        <?php the_excerpt(); ?>
                    </div>

                    <footer class="entry-footer">
                        <a href="<?php the_permalink(); ?>" class="read-more"><?php _e('Ver Detalles', 'generatepress-child'); ?></a>
                    </footer>
                </article>
                <?php
            endwhile;
            echo '</div>';

            // Pagination
            the_posts_pagination(array(
                'mid_size' => 2,
                'prev_text' => __('Anterior', 'generatepress-child'),
                'next_text' => __('Siguiente', 'generatepress-child'),
            ));

            wp_reset_postdata();
        else :
            echo '<p>' . __('No se encontraron vehículos.', 'generatepress-child') . '</p>';
        endif;
        ?>
    </main>
</div>

<?php
get_sidebar();
get_footer();