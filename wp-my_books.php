<?php

/**
 * Plugin Name: MyBooks
 * Plugin URI: https://bookspress.com
 * Description: This is the best books management plugin.
 * Author: Danilo Cardoso Beluco
 * Author URI: https://bookspress.com
 * Version: 1.0
 */


if (!defined("ABSPATH")) {
    exit;
}

if (!defined("MY_BOOK_PLUGIN_DIR_PATH")) {
    define("MY_BOOK_PLUGIN_DIR_PATH", plugin_dir_path(__FILE__));
}

if (!defined("MY_BOOK_PLUGIN_URL")) {
    define("MY_BOOK_PLUGIN_URL", plugins_url() . "/my-books");
}




/* -- Assets e Libraries -- */





function my_book_include_assets()
{

    //styles
    wp_enqueue_style("bootstrap", "https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css");
    wp_enqueue_style("datatable", "https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css");
    wp_enqueue_style("style", MY_BOOK_PLUGIN_URL . "/assets/css/style.css");

    //scripts
    wp_enqueue_script("bootstrapjs", "https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js");
    wp_enqueue_script("validate", "https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.16.0/jquery.validate.min.js");
    wp_enqueue_script("jquery", "https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js");
    wp_enqueue_script("datatable", "http://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js");
    wp_enqueue_script("notify", MY_BOOK_PLUGIN_URL . "/assets/js/jquery.notifyBar.js");
    wp_enqueue_script("script.js", MY_BOOK_PLUGIN_URL . "/assets/js/script.js");

    // passa um valor php para javascript, no caso a url do ajax
    wp_localize_script("script.js", "mybookajaxurl", admin_url("admin-ajax.php"));
}

add_action("init", "my_book_include_assets");






/* -- WP Menus e Submenus -- */





function my_book_plugin_menus()
{
    add_menu_page(
        "My Book",
        "My Book",
        "manage_options",
        "book-list",
        "my_book_list",
        "dashicons-book-alt",
        30 // Posição
    );

    add_submenu_page(
        "book-list",
        "Books List",
        "Books List",
        "manage_options",
        "book-list",
        "my_book_list"
    );

    add_submenu_page(
        "book-list",
        "Add New",
        "Add New",
        "manage_options",
        "add-new",
        "my_book_add"
    );

    add_submenu_page(
        "book-list",
        "Book Edit",
        "Book Edit",
        "manage_options",
        "edit",
        "my_book_edit"
    );
}

add_action("admin_menu", "my_book_plugin_menus");

function my_book_list()
{
    include_once MY_BOOK_PLUGIN_DIR_PATH . "/views/book-list.php";
}

function my_book_add()
{
    include_once MY_BOOK_PLUGIN_DIR_PATH . "/views/book-add.php";
}

function my_book_edit()
{
    include_once MY_BOOK_PLUGIN_DIR_PATH . "/views/book-edit.php";
}





/* -- Database -- */





/* Retorna o nome da tabela certinho com o prefixo */
function my_book_table()
{

    global $wpdb;
    return $wpdb->prefix . "my_books"; //wp_my_books

}

function my_book_generates_table_script()
{

    global $wpdb;
    require_once ABSPATH . "wp-admin/includes/upgrade.php";

    $sql = "CREATE TABLE " . my_book_table() . " (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `name` varchar(255) DEFAULT NULL,
    `author` varchar(255) DEFAULT NULL,
    `about` text,
    `book_image` text,
    `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
      ) ENGINE=InnoDB DEFAULT CHARSET=latin1";

    dbDelta($sql);
}

register_activation_hook(__FILE__, "my_book_generates_table_script");

function drop_table_plugin_books()
{

    global $wpdb;
    $wpdb->query("DROP TABLE IF EXISTS " . my_book_table());
}

// register_deactivation_hook(__FILE__, "drop_table_plugin_books");
register_uninstall_hook(__FILE__, "drop_table_plugin_books");






/* -- Ajax ao cadastrar -- */




/* Se houver uma req ajax com action mybooklibrary */

add_action("wp_ajax_mybooklibrary", "my_book_ajax_handler");

function my_book_ajax_handler()
{
    global $wpdb;
    if ($_REQUEST['param'] == "save_book") {

        // Pega os dados da req, e salva no banco de dados
        $wpdb->insert(my_book_table(), [
            "name" => $_REQUEST['name'],
            "author" => $_REQUEST['author'],
            "about" => $_REQUEST['about'],
            "book_image" => $_REQUEST['image_name']
        ]);
        echo json_encode(array("status" => 1, "message" => "Livro adicionado com sucesso!"));
    } else if ($_REQUEST['param'] == "edit_book") {

        $wpdb->update(my_book_table(), [
            "name" => $_REQUEST['name'],
            "author" => $_REQUEST['author'],
            "about" => $_REQUEST['about'],
            "book_image" => $_REQUEST['image_name']
        ], ["id" => $_REQUEST['book_id']]);
        echo json_encode(array("status" => 1, "message" => "Livro editado com sucesso!"));
    } else if ($_REQUEST['param'] == "delete_book") {

        $wpdb->delete(my_book_table(), [
            "id" => $_REQUEST['id']
        ]);

        echo json_encode(array("status" => 1, "message" => "Livro editado com sucesso!"));
    }

    wp_die();
}
