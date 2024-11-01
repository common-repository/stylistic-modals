<?php
// Settings Page: Stylistic Modals
class DRSM_Settings_Page {

	public function __construct() {
		add_action( 'admin_menu', array( $this, 'wph_create_settings' ) );
		add_action( 'admin_init', array( $this, 'wph_setup_sections' ) );
		add_action( 'admin_init', array( $this, 'wph_setup_fields' ) );
	}

	public function wph_create_settings() {
		$page_title = 'Stylistic Modal - Settings';
		$menu_title = 'Settings';
		$capability = 'manage_options';
		$slug = 'stylisticmodals';
		$callback = array($this, 'wph_settings_content');
		$icon = 'dashicons-index-card';
		$position = 59;
		add_submenu_page('edit.php?post_type=stylisticmodal', $page_title, $menu_title, $capability, $slug, $callback, $icon, $position);
	}

	public function wph_settings_content() { ?>
    <div class="wrap">
      <h1>Stylistic Modal - Options</h1>
			<?php settings_errors(); ?>
      <form method="POST" action="options.php">
				<?php
				settings_fields( 'stylisticmodals' );
				do_settings_sections( 'stylisticmodals' );
				submit_button();
				?>
      </form>
    </div> <?php
	}

	public function wph_setup_sections() {
		add_settings_section( 'stylisticmodals_section', 'Coming soon...', array(), 'stylisticmodals' );
	}

	public function wph_setup_fields() {
		$fields = array(
		);
		foreach( $fields as $field ){
			add_settings_field( $field['id'], $field['label'], array( $this, 'wph_field_callback' ), 'stylisticmodals', $field['section'], $field );
			register_setting( 'stylisticmodals', $field['id'] );
		}
	}

	public function wph_field_callback( $field ) {
		$value = get_option( $field['id'] );
		$placeholder = '';
		if ( isset($field['placeholder']) ) {
			$placeholder = $field['placeholder'];
		}
		switch ( $field['type'] ) {
			default:
				printf( '<input name="%1$s" id="%1$s" type="%2$s" placeholder="%3$s" value="%4$s" />',
					$field['id'],
					$field['type'],
					$placeholder,
					$value
				);
		}
		if( isset($field['desc']) ) {
			if( $desc = $field['desc'] ) {
				printf( '<p class="description">%s </p>', $desc );
			}
		}
	}
}
new DRSM_Settings_Page();
