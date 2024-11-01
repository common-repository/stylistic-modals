<?php
// Meta Box Class: Modal Settings
class DRSM_Modalsettings_Metabox {

	private $screen = array(
		'stylisticmodal',
	);

	private $meta_fields = array(
		array(
			'label' => 'Mode',
			'id' => 'mode',
			'type' => 'select',
			'options' => array(
				'Open after the page did load',
				'Open after an element was clicked',
			),
			'default' => 'Open after the page did load'
		),
		array(
			'label' => 'After how many seconds should the dialog be displayed?',
			'id' => 'timeout-time',
			'type' => 'number',
			'default' => 5
		),
		array(
			'label' => 'The class or ID of the element that is clicked, for example -> #element',
			'id' => 'click-element',
			'type' => 'text',
			'desc' => "fwe"
		),
		array(
			'label' => 'Headline',
			'id' => 'headline',
			'type' => 'text',
			'default' => 'Your title. Be creative :)'
		),
		array(
			'label' => 'Subtitle',
			'id' => 'subtitle',
			'type' => 'text',
			'default' => 'You can give me also a subtitle!'
		),
		array(
			'label' => 'Header Background Color',
			'id' => 'header-background-color',
			'type' => 'color',
			'default' => '#2C8374'
		),
		array(
			'label' => 'Header Text Color',
			'id' => 'header-text-color',
			'type' => 'color',
			'default' => '#FFFFFF'
		),
		array(
			'label' => 'Content Background Color',
			'id' => 'content-background-color',
			'type' => 'color',
			'default' => '#ffffff'
		),
		array(
			'label' => 'Content Text Color',
			'id' => 'content-text-color',
			'type' => 'color',
			'default' => '#222222'
		),
		array(
			'label' => 'Modal Width in Pixel',
			'id' => 'modal-width',
			'type' => 'number',
			'default' => 600
		),
		array(
			'label' => 'Border Radius Style',
			'id' => 'border-radius-style',
			'type' => 'select',
			'options' => array(
				'No border radius',
				'Rounded',
				'Very rounded'
			),
			'default' => 'Rounded'
		),
		array(
			'label' => 'Allow Fullscreen View',
			'id' => 'allow-fullscreen',
			'type' => 'checkbox',
			'default' => 1
		),
		array(
			'label' => 'Set Cookie',
			'id' => 'set-cookie',
			'type' => 'checkbox',
			'default' => 1
		),
		array(
			'label' => 'Cookie Expiration Time in days',
			'id' => 'cookie-expire-time',
			'type' => 'number',
			'default' => 7
		),
	);

	public function __construct() {
		add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ) );
		add_action( 'save_post', array( $this, 'save_fields' ) );
	}

	public function add_meta_boxes() {
		foreach ( $this->screen as $single_screen ) {
			add_meta_box(
				'modalsettings',
				__( 'Modal Settings', 'stylisticmodals' ),
				array( $this, 'meta_box_callback' ),
				$single_screen,
				'advanced',
				'high'
			);
		}
	}

	public function meta_box_callback( $post ) {
		wp_nonce_field( 'modalsettings_data', 'modalsettings_nonce' );
		$this->field_generator( $post );
	}

	public function field_generator( $post ) {
		$output = '';
		foreach ( $this->meta_fields as $meta_field ) {
			$label = '<label for="' . $meta_field['id'] . '">' . $meta_field['label'] . '</label>';
			$meta_value = get_post_meta( $post->ID, $meta_field['id'], true );
			if ( empty( $meta_value ) ) {
				if ( isset( $meta_field['default'] ) ) {
					$meta_value = $meta_field['default'];
				}
			}
			switch ( $meta_field['type'] ) {
				case 'checkbox':
					$input = sprintf(
						'<input %s id=" %s" name="%s" type="checkbox" value="1">',
						$meta_value === '1' ? 'checked' : '',
						$meta_field['id'],
						$meta_field['id']
					);
					break;
				case 'select':
					$input = sprintf(
						'<select id="%s" name="%s">',
						$meta_field['id'],
						$meta_field['id']
					);
					foreach ( $meta_field['options'] as $key => $value ) {
						$meta_field_value = !is_numeric( $key ) ? $key : $value;
						$input .= sprintf(
							'<option %s value="%s">%s</option>',
							$meta_value === $meta_field_value ? 'selected' : '',
							$meta_field_value,
							$value
						);
					}
					$input .= '</select>';
					break;
				case 'pages':
					$pagesargs = array(
						'selected' => $meta_value,
						'echo' => 0,
						'name' => $meta_field['id'],
						'id' => $meta_field['id'],
						'show_option_none' => 'Select a page',
					);
					$input = wp_dropdown_pages($pagesargs);
					break;
				default:
					$input = sprintf(
						'<input %s id="%s" name="%s" type="%s" value="%s">',
						$meta_field['type'] !== 'color' ? 'style="width: auto"' : '',
						$meta_field['id'],
						$meta_field['id'],
						$meta_field['type'],
						$meta_value
					);
			}
			$output .= $this->format_rows( $label, $input );
		}
		echo '<table class="form-table"><tbody>' . $output . '</tbody></table>';
	}

	public function format_rows( $label, $input ) {
		return '<tr><th>'.$label.'</th><td>'.$input.'</td></tr>';
	}

	public function save_fields( $post_id ) {
		if ( ! isset( $_POST['modalsettings_nonce'] ) )
			return $post_id;
		$nonce = $_POST['modalsettings_nonce'];
		if ( !wp_verify_nonce( $nonce, 'modalsettings_data' ) )
			return $post_id;
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
			return $post_id;
		foreach ( $this->meta_fields as $meta_field ) {
			if ( isset( $_POST[ $meta_field['id'] ] ) ) {
				$sanitizedUserInput = "";
				$sanitizedMetaFieldID = "";
				switch ( $meta_field['type'] ) {
					case 'email':
						$sanitizedUserInput = sanitize_email( $_POST[ $meta_field['id'] ] );
						$sanitizedMetaFieldID = sanitize_email( $meta_field['id']);
						break;
					case 'text':
						$sanitizedUserInput = sanitize_text_field( $_POST[ $meta_field['id'] ] );
						$sanitizedMetaFieldID = sanitize_text_field( $meta_field['id']);
						break;
					default:
						$sanitizedUserInput = sanitize_text_field( $_POST[ $meta_field['id'] ] );
						$sanitizedMetaFieldID = sanitize_text_field( $meta_field['id']);
				}
				update_post_meta( $post_id, $sanitizedMetaFieldID, $sanitizedUserInput );
			} else if ( $meta_field['type'] === 'checkbox' ) {
				$sanitizedMetaFieldID = sanitize_text_field( $meta_field['id']);
				update_post_meta( $post_id, $sanitizedMetaFieldID, '0' );
			}
		}
	}
}

if (class_exists('DRSM_Modalsettings_Metabox')) {
	new DRSM_Modalsettings_Metabox;
};
