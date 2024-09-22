<?php
function generatepress_child_enqueue_styles() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
}
add_action( 'wp_enqueue_scripts', 'generatepress_child_enqueue_styles' );



// Función para registrar el tipo de entrada personalizado 'Casas'
function crear_post_type_casas() {
    $labels = array(
        'name'               => 'Casas',
        'singular_name'      => 'Casa',
        'menu_name'          => 'Casas',
        'name_admin_bar'     => 'Casa',
        'add_new'            => 'Añadir nueva',
        'add_new_item'       => 'Añadir nueva casa',
        'new_item'           => 'Nueva casa',
        'edit_item'          => 'Editar casa',
        'view_item'          => 'Ver casa',
        'all_items'          => 'Todas las casas',
        'search_items'       => 'Buscar casas',
        'parent_item_colon'  => 'Casa padre:',
        'not_found'          => 'No se encontraron casas',
        'not_found_in_trash' => 'No se encontraron casas en la papelera'
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'casas' ),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => 5,
        'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' ),
        'menu_icon'          => 'dashicons-admin-home'
    );

    register_post_type( 'casas', $args );
}
add_action( 'init', 'crear_post_type_casas' );

// Función para agregar campos personalizados
function agregar_campos_casas() {
    add_meta_box(
        'campos_casas',
        'Detalles de la Casa',
        'mostrar_campos_casas',
        'casas',
        'normal',
        'default'
    );
}
add_action( 'add_meta_boxes', 'agregar_campos_casas' );

// Función para mostrar los campos personalizados
function mostrar_campos_casas( $post ) {
    wp_nonce_field( basename( __FILE__ ), 'casas_nonce' );
    $recamaras = get_post_meta( $post->ID, 'recamaras', true );
    $banios = get_post_meta( $post->ID, 'banios', true );
    $medios_banios = get_post_meta( $post->ID, 'medios_banios', true );
    ?>
    <p>
        <label for="recamaras">Número de Recámaras:</label>
        <select name="recamaras" id="recamaras">
            <?php for ($i = 1; $i <= 10; $i++) : ?>
                <option value="<?php echo $i; ?>" <?php selected( $recamaras, $i ); ?>><?php echo $i; ?></option>
            <?php endfor; ?>
        </select>
    </p>
    <p>
        <label for="banios">Número de Baños Completos:</label>
        <input type="number" name="banios" id="banios" value="<?php echo esc_attr( $banios ); ?>" min="0">
    </p>
    <p>
        <label for="medios_banios">Número de Medios Baños:</label>
        <input type="number" name="medios_banios" id="medios_banios" value="<?php echo esc_attr( $medios_banios ); ?>" min="0">
    </p>
    <?php
}

// Función para guardar los campos personalizados
function guardar_campos_casas( $post_id ) {
    if ( !isset( $_POST['casas_nonce'] ) || !wp_verify_nonce( $_POST['casas_nonce'], basename( __FILE__ ) ) ) {
        return $post_id;
    }

    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return $post_id;
    }

    if ( 'casas' == $_POST['post_type'] ) {
        if ( !current_user_can( 'edit_page', $post_id ) ) {
            return $post_id;
        }
    } else {
        if ( !current_user_can( 'edit_post', $post_id ) ) {
            return $post_id;
        }
    }

    $campos = ['recamaras', 'banios', 'medios_banios'];

    foreach ( $campos as $campo ) {
        if ( isset( $_POST[$campo] ) ) {
            update_post_meta( $post_id, $campo, sanitize_text_field( $_POST[$campo] ) );
        }
    }
}
add_action( 'save_post', 'guardar_campos_casas' );