<?php

add_action('wp_enqueue_scripts','drsm_stylistic_modals_load_files');
add_action('admin_enqueue_scripts','drsm_stylistic_modals_load_admin_files');

if (!function_exists('drsm_stylistic_modals_load_files')) {
	function drsm_stylistic_modals_load_files() {
		wp_enqueue_style( 'stylistic_modals_izimodal_css', plugin_dir_url(dirname(__FILE__)) . 'vendor/css/iziModal.min.css');
		wp_enqueue_style( 'stylistic_modals_main_css', plugin_dir_url(dirname(__FILE__)) . 'assets/css/stylistic-modal.css');
		wp_enqueue_script( 'stylistic_modals_izimodal_js', plugin_dir_url(dirname(__FILE__)) . 'vendor/js/iziModal.min.js', array('jquery'));
		wp_enqueue_script( 'stylistic_modals_js_cookies_js', plugin_dir_url(dirname(__FILE__)) . 'vendor/js/js.cookie.min.js', array('jquery'));
	}
}
if (!function_exists('drsm_stylistic_modals_load_admin_files')) {
	function drsm_stylistic_modals_load_admin_files() {
		wp_enqueue_style( 'stylistic_modals_izimodal_css', plugin_dir_url(dirname(__FILE__)) . 'vendor/css/iziModal.min.css');
		wp_enqueue_style( 'stylistic_modals_admin_css', plugin_dir_url(dirname(__FILE__)) . 'assets/css/stylistic-modal-admin.css');
		wp_enqueue_style( 'stylistic_modals_main_css', plugin_dir_url(dirname(__FILE__)) . 'assets/css/stylistic-modal.css');
		wp_enqueue_script( 'stylistic_modals_izimodal_admin_js', plugin_dir_url(dirname(__FILE__)) . 'vendor/js/iziModal.min.js', array('jquery'));
		wp_enqueue_script( 'stylistic_modals_admin_js', plugin_dir_url(dirname(__FILE__)) . 'assets/js/stylistic-modals-admin.js', '3');
	}
}
