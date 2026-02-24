<?php
/*
Plugin Name: Institutional Editor Access - Smart Slider & UI Hardening
Plugin URI: https://github.com/joaoguiaguiar/wp-smartslider-editor-access
Description: Restringe o papel de Editor para acesso exclusivo ao Smart Slider, Menus e Widgets, bloqueando o restante do painel por segurança.
Version: 1.2.0
Author: João Aguiar
Author URI: https://github.com/joaoguiaguiar
Text Domain: inst-editor-access
License: GPL v2 or later
*/

if (!defined('ABSPATH')) exit;

class INST_Editor_Access_Hardening {

    // Páginas permitidas para o nível de editor
    private $paginas_permitidas = [
        'index.php',                   // Dashboard
        'edit.php',                    // Posts
        'edit.php?post_type=page',     // Pages
        'themes.php',                  // Appearance Base
        'admin.php?page=smartslider',  // Smart Slider 3
        'upload.php',                  // Media Library
        'media-new.php'                // Upload New Media
    ];

    // Submenus permitidos dentro de Appearance
    private $submenus_permitidos = [
        'nav-menus.php',   // Menus
        'widgets.php'      // Widgets
    ];

    public function __construct() {
        add_action('init', [$this, 'definir_permissoes']);
        add_filter('user_has_cap', [$this, 'forcar_permissoes'], 10, 4);
        add_action('admin_menu', [$this, 'ajustar_menus'], 999);
        add_filter('option_page_capability_smartslider3', [$this, 'permissao_smartslider']);
        add_action('load-customize.php', [$this, 'bloquear_personalizador']);

        // Auditoria e Segurança
        add_action('admin_init', [$this, 'validar_acesso']);
        add_action('wp_login', [$this, 'registrar_login_editor']);
        add_action('admin_bar_menu', [$this, 'limpar_barra_admin'], 999);
    }

    // Configura as capacidades no banco de dados para o role Editor
    public function definir_permissoes() {
        $editor = get_role('editor');
        if (!$editor) return;

        $permissoes = [
            'smartslider',
            'smartslider_edit',
            'smartslider_config',
            'smartslider_delete',
            'smartslider_edit_sliders',
            'smartslider_delete_sliders',
            'edit_posts',
            'edit_pages',
            'publish_pages',
            'edit_theme_options',
            'upload_files'
        ];

        foreach ($permissoes as $p) {
            if (!$editor->has_cap($p)) {
                $editor->add_cap($p);
            }
        }
    }

    // Garante que as capacidades persistam em tempo de execução
    public function forcar_permissoes($todas, $solicitadas, $args, $usuario) {
        if (!in_array('editor', (array) $usuario->roles)) {
            return $todas;
        }

        return array_merge($todas, [
            'smartslider' => true,
            'smartslider_edit' => true,
            'smartslider_config' => true,
            'smartslider_delete' => true,
            'smartslider_edit_sliders' => true,
            'smartslider_delete_sliders' => true,
            'edit_posts' => true,
            'edit_pages' => true,
            'publish_pages' => true,
            'edit_theme_options' => true,
            'upload_files' => true,
            'read' => true
        ]);
    }

    // Esconde itens do menu lateral para limpar a interface do Editor
    public function ajustar_menus() {
        $usuario = wp_get_current_user();
        if (!in_array('editor', (array) $usuario->roles)) return;

        global $submenu;

        foreach ($GLOBALS['menu'] as $item) {
            if (!in_array($item[2], $this->paginas_permitidas)) {
                remove_menu_page($item[2]);
            }
        }

        if (isset($submenu['themes.php'])) {
            foreach ($submenu['themes.php'] as $subitem) {
                if (!in_array($subitem[2], $this->submenus_permitidos)) {
                    remove_submenu_page('themes.php', $subitem[2]);
                }
            }
        }
    }

    public function permissao_smartslider() {
        return 'smartslider_config';
    }

    public function bloquear_personalizador() {
        if (current_user_can('editor') && !current_user_can('manage_options')) {
            $this->registrar_bloqueio('Customizer');
            wp_die('Acesso restrito: O Personalizador de temas é exclusivo para administradores.');
        }
    }

    // Impede acesso via URL direta a páginas sensíveis
    public function validar_acesso() {
        $usuario = wp_get_current_user();
        if (!in_array('editor', (array) $usuario->roles)) return;

        global $pagenow;

        $bloqueadas = [
            'update-core.php',
            'update.php',
            'plugin-install.php',
            'plugin-editor.php',
            'theme-editor.php',
            'users.php',
            'user-new.php',
            'options-general.php'
            // upload.php e media-new.php são permitidas para o Editor
        ];

        if (in_array($pagenow, $bloqueadas)) {
            $this->registrar_bloqueio($pagenow);
            wp_die(
                'Acesso negado. Esta tentativa foi registrada para auditoria.',
                'Acesso Restrito',
                ['response' => 403, 'back_link' => true]
            );
        }
    }

    // Auditoria de segurança via error_log
    private function registrar_bloqueio($pagina) {
        $usuario = wp_get_current_user();
        $quando = date('Y-m-d H:i:s');
        $ip = $_SERVER['REMOTE_ADDR'] ?? 'Unknown';
        error_log("Security Log: User {$usuario->user_login} attempted to access {$pagina} on {$quando} (IP: {$ip})");
    }

    public function registrar_login_editor($login) {
        $usuario = get_user_by('login', $login);
        if ($usuario && in_array('editor', (array) $usuario->roles)) {
            $quando = date('Y-m-d H:i:s');
            $ip = $_SERVER['REMOTE_ADDR'] ?? 'Unknown';
            error_log("Access Log: Editor {$login} logged in on {$quando} (IP: {$ip})");
        }
    }

    public function limpar_barra_admin($barra) {
        $usuario = wp_get_current_user();
        if (!in_array('editor', (array) $usuario->roles)) return;

        $barra->remove_node('updates');
        $barra->remove_node('comments');
        $barra->remove_node('customize');
        $barra->remove_node('themes');
    }

    public function checar_status() {
        $editor = get_role('editor');
        if (!$editor) return false;

        $necessarias = ['smartslider', 'smartslider_edit', 'smartslider_config'];
        foreach ($necessarias as $p) {
            if (!$editor->has_cap($p)) return false;
        }
        return true;
    }
}

new INST_Editor_Access_Hardening();

// Ganchos de Ativação e Desativação para limpeza de capacidades
register_activation_hook(__FILE__, function () {
    $editor = get_role('editor');
    if ($editor) {
        $permissoes = ['smartslider', 'smartslider_edit', 'smartslider_config', 'smartslider_delete', 'edit_theme_options'];
        foreach ($permissoes as $p) { $editor->add_cap($p); }
    }
});

register_deactivation_hook(__FILE__, function () {
    $editor = get_role('editor');
    if ($editor) {
        $permissoes = ['smartslider', 'smartslider_edit', 'smartslider_config', 'smartslider_delete', 'edit_theme_options'];
        foreach ($permissoes as $p) { $editor->remove_cap($p); }
    }
});

// UI de Monitoramento para Administradores
add_action('admin_menu', function() {
    if (current_user_can('manage_options')) {
        add_management_page(
            'Institutional Access Status',
            'Access Status',
            'manage_options',
            'inst-access-status',
            function() {
                $plugin = new INST_Editor_Access_Hardening();
                $status = $plugin->checar_status() ? 'Healthy' : 'Misconfigured';
                echo "<div class='wrap'><h1>Plugin Status: Editor Access Hardening</h1>";
                echo "<p>Status: <strong>{$status}</strong></p>";
                echo "</div>";
            }
        );
    }
});