<?php 
/*
    Plugin Name: Secman by EstudioRocha&Asoc.
    Description: Añade Post Types al sitio Secman
    Version: 1.0.0
    Text Domain: Secman
*/

if(!defined('ABSPATH')) die();


function financiaciones_post_type() {

	$labels = array(
		'name'                  => _x( 'Financiación', 'Post Type General Name', 'financiacion' ),
		'singular_name'         => _x( 'financiación', 'Post Type Singular Name', 'financiación' ),
		'menu_name'             => __( 'Financiación', 'financiación' ),
		'name_admin_bar'        => __( 'Financiación', 'financiación' ),
		'archives'              => __( 'Archivo', 'financiación' ),
		'attributes'            => __( 'Atributos', 'financiación' ),
		'parent_item_colon'     => __( 'item Padre', 'financiación' ),
		'all_items'             => __( 'Ver financiación', 'financiación' ),
		'add_new_item'          => __( 'Agregar a financiación', 'financiación' ),
		'add_new'               => __( 'Agregar a financiación', 'financiación' ),
		'new_item'              => __( 'Nueva financiación', 'financiación' ),
		'edit_item'             => __( 'Editar financiación', 'financiación' ),
		'update_item'           => __( 'Actualizar financiación', 'financiación' ),
		'view_item'             => __( 'Ver financiación', 'financiación' ),
		'view_items'            => __( 'Ver financiación', 'financiación' ),
		'search_items'          => __( 'Buscar item', 'financiación' ),
		'not_found'             => __( 'No Encontrado', 'financiación' ),
		'not_found_in_trash'    => __( 'No Encontrado en Papelera', 'financiación' ),
		'featured_image'        => __( 'Imagen Destacada', 'financiación' ),
		'set_featured_image'    => __( 'Guardar Imagen destacada', 'financiación' ),
		'remove_featured_image' => __( 'Eliminar Imagen destacada', 'financiación' ),
		'use_featured_image'    => __( 'Utilizar como Imagen Destacada', 'financiación' ),
		'insert_into_item'      => __( 'Insertar en financiación', 'financiación' ),
		'uploaded_to_this_item' => __( 'Agregado en item', 'financiación' ),
		'items_list'            => __( 'Lista de items', 'financiación' ),
		'items_list_navigation' => __( 'Navegación de items', 'financiación' ),
		'filter_items_list'     => __( 'Filtrar items', 'financiación' ),
	);
	$args = array(
		'label'                 => __( 'financiación', 'financiación' ),
		'description'           => __( 'financiación para el Sitio Web', 'financiación' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'thumbnail'),
		'hierarchical'          => true, // true = posts , false = paginas
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
        'menu_position'         => 6,
        'menu_icon'             => 'dashicons-businessperson',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'page',
	);
	register_post_type( 'financiaciones', $args );

}
add_action( 'init', 'financiaciones_post_type', 0 );

// Habilitar Elementor en el editor de entradas personalizadas
function financiaciones_elementor_support()
{
    add_post_type_support('financiaciones', 'elementor');
}
add_action('init', 'financiaciones_elementor_support');

function concesionarias_post_type() {

	$labels = array(
		'name'                  => _x( 'Concesionaria', 'Post Type General Name', 'concesionaria' ),
		'singular_name'         => _x( 'concesionaria', 'Post Type Singular Name', 'concesionaria' ),
		'menu_name'             => __( 'Concesionarias', 'concesionaria' ),
		'name_admin_bar'        => __( 'Concesionarias', 'concesionaria' ),
		'archives'              => __( 'Archivo', 'concesionaria' ),
		'attributes'            => __( 'Atributos', 'concesionaria' ),
		'parent_item_colon'     => __( 'item Padre', 'concesionaria' ),
		'all_items'             => __( 'Ver concesionaria', 'concesionaria' ),
		'add_new_item'          => __( 'Agregar a concesionarias', 'concesionaria' ),
		'add_new'               => __( 'Agregar a concesionarias', 'concesionaria' ),
		'new_item'              => __( 'Nueva concesionaria', 'concesionaria' ),
		'edit_item'             => __( 'Editar concesionaria', 'concesionaria' ),
		'update_item'           => __( 'Actualizar concesionarias', 'concesionaria' ),
		'view_item'             => __( 'Ver concesionaria', 'concesionaria' ),
		'view_items'            => __( 'Ver concesionarias', 'concesionaria' ),
		'search_items'          => __( 'Buscar item', 'concesionaria' ),
		'not_found'             => __( 'No Encontrado', 'concesionaria' ),
		'not_found_in_trash'    => __( 'No Encontrado en Papelera', 'concesionaria' ),
		'featured_image'        => __( 'Imagen Destacada', 'concesionaria' ),
		'set_featured_image'    => __( 'Guardar Imagen destacada', 'concesionaria' ),
		'remove_featured_image' => __( 'Eliminar Imagen destacada', 'concesionaria' ),
		'use_featured_image'    => __( 'Utilizar como Imagen Destacada', 'concesionaria' ),
		'insert_into_item'      => __( 'Insertar en concesionaria', 'concesionaria' ),
		'uploaded_to_this_item' => __( 'Agregado en item', 'concesionaria' ),
		'items_list'            => __( 'Lista de items', 'concesionaria' ),
		'items_list_navigation' => __( 'Navegación de items', 'concesionaria' ),
		'filter_items_list'     => __( 'Filtrar items', 'concesionaria' ),
	);
	$args = array(
		'label'                 => __( 'concesionaria', 'concesionaria' ),
		'description'           => __( 'concesionaria para el Sitio Web', 'concesionaria' ),
		'labels'                => $labels,
		'supports'              => array( 'title' ),
		'hierarchical'          => true, // true = posts , false = paginas
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
        'menu_position'         => 7,
        'menu_icon'             => 'dashicons-admin-multisite',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'page',
	);
	register_post_type( 'concesionarias', $args );

}
add_action( 'init', 'concesionarias_post_type', 0 );

// Habilitar Elementor en el editor de entradas personalizadas
function concesionarias_elementor_support()
{
    add_post_type_support('concesionarias', 'elementor');
}
add_action('init', 'concesionarias_elementor_support');
function productos_post_type() {

	$labels = array(
		'name'                  => _x( 'Producto', 'Post Type General Name', 'producto' ),
		'singular_name'         => _x( 'producto', 'Post Type Singular Name', 'producto' ),
		'menu_name'             => __( 'Productos', 'producto' ),
		'name_admin_bar'        => __( 'Productos', 'producto' ),
		'archives'              => __( 'Archivo', 'producto' ),
		'attributes'            => __( 'Atributos', 'producto' ),
		'parent_item_colon'     => __( 'item Padre', 'producto' ),
		'all_items'             => __( 'Ver producto', 'producto' ),
		'add_new_item'          => __( 'Agregar a productos', 'producto' ),
		'add_new'               => __( 'Agregar a productos', 'producto' ),
		'new_item'              => __( 'Nueva producto', 'producto' ),
		'edit_item'             => __( 'Editar producto', 'producto' ),
		'update_item'           => __( 'Actualizar productos', 'producto' ),
		'view_item'             => __( 'Ver producto', 'producto' ),
		'view_items'            => __( 'Ver productos', 'producto' ),
		'search_items'          => __( 'Buscar item', 'producto' ),
		'not_found'             => __( 'No Encontrado', 'producto' ),
		'not_found_in_trash'    => __( 'No Encontrado en Papelera', 'producto' ),
		'featured_image'        => __( 'Imagen Destacada', 'producto' ),
		'set_featured_image'    => __( 'Guardar Imagen destacada', 'producto' ),
		'remove_featured_image' => __( 'Eliminar Imagen destacada', 'producto' ),
		'use_featured_image'    => __( 'Utilizar como Imagen Destacada', 'producto' ),
		'insert_into_item'      => __( 'Insertar en producto', 'producto' ),
		'uploaded_to_this_item' => __( 'Agregado en item', 'producto' ),
		'items_list'            => __( 'Lista de items', 'producto' ),
		'items_list_navigation' => __( 'Navegación de items', 'producto' ),
		'filter_items_list'     => __( 'Filtrar items', 'producto' ),
	);
	$args = array(
		'label'                 => __( 'producto', 'producto' ),
		'description'           => __( 'producto para el Sitio Web', 'producto' ),
		'labels'                => $labels,
		'supports'              => array( 'title','thumbnail', 'categories'),
		'hierarchical'          => true, // true = posts , false = paginas
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
        'menu_position'         => 8,
        'menu_icon'             => 'dashicons-store',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'page',
	);
	register_post_type( 'productos', $args );

}
add_action( 'init', 'productos_post_type', 0 );

// Habilitar Elementor en el editor de entradas personalizadas
function productos_elementor_support()
{
    add_post_type_support('productos', 'elementor');
}
add_action('init', 'productos_elementor_support');
