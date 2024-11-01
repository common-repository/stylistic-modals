<?php

add_action('wp_footer', 'drsm_stylistic_modals_output_content');
if (!function_exists('drsm_stylistic_modals_output_content')) {
	function drsm_stylistic_modals_output_content() {
		?>

		<?php
		// Custom WP query stylisticmodals
		$args_stylisticmodals = array(
			'post_type' => array('stylisticmodal'),
			'nopaging' => false,
			'order' => 'DESC',
			'posts_per_page' => 9999,
		);

		$stylisticmodals = new WP_Query( $args_stylisticmodals );

		if ( $stylisticmodals->have_posts() ) {
			while ( $stylisticmodals->have_posts() ) {
				$stylisticmodals->the_post();

				// User Options
				$mode = get_post_meta(get_the_id(), 'mode', true);
				$timeout = esc_html( __( get_post_meta(get_the_id(), 'timeout-time', true), 'stylisticmodals' ) );
				$headline = esc_html( __( get_post_meta(get_the_id(), 'headline', true), 'stylisticmodals' ) );
				$subtitle = esc_html( __( get_post_meta(get_the_id(), 'subtitle', true), 'stylisticmodals' ) );
				$headerBgColor = get_post_meta(get_the_id(), 'header-background-color', true);
				$headerTextColor = get_post_meta(get_the_id(), 'header-text-color', true);
				$contentBackgroundColor = get_post_meta(get_the_id(), 'content-background-color', true);
				$contentTextColor = get_post_meta(get_the_id(), 'content-text-color', true);
				$modalWidth = get_post_meta(get_the_id(), 'modal-width', true);
				$allowFullscreen = get_post_meta(get_the_id(), 'allow-fullscreen', true);
				$borderRadiusStyle = get_post_meta(get_the_id(), 'border-radius-style', true);
				$borderRadius = 5;
				switch ($borderRadiusStyle) {
					case 'No border radius':
						$borderRadius = 0.0000001;
						break;
					case 'Rounded':
						$borderRadius = 5;
						break;
					case 'Very rounded':
						$borderRadius = 20;
						break;
				}
				$clickedElement = get_post_meta(get_the_id(), 'click-element', true);
				$setCookie = get_post_meta(get_the_id(), 'set-cookie', true);
				$cookieExpires = esc_html( __(  get_post_meta(get_the_id(), 'cookie-expire-time', true), 'stylisticmodals' ) );

				?>

        <script>
            jQuery(document).ready(function($) {
                $("#stylistic_modal-<?php echo get_the_ID() ?>").iziModal( {
                    title: '<?php echo !empty($headline) ? $headline : "" ?>',
                    subtitle: '<?php echo !empty($subtitle) ? $subtitle : "" ?>',
                    headerColor: '<?php echo $headerBgColor ? $headerBgColor : "" ?>',
                    background: '<?php echo $contentBackgroundColor ? $contentBackgroundColor : "" ?>',
                    theme: '',  // light
                    icon: null,
                    iconText: null,
                    iconColor: '',
                    rtl: false,
                    width: <?php echo !empty($modalWidth) ? $modalWidth : 600 ?>,
                    top: null,
                    bottom: null,
                    borderBottom: true,
                    padding: 0,
                    radius: <?php echo !empty($borderRadius) ? $borderRadius : 5 ?>,
                    zindex: 9999,
                    iframe: false,
                    iframeHeight: 400,
                    iframeURL: null,
                    focusInput: true,
                    group: '',
                    loop: false,
                    arrowKeys: true,
                    navigateCaption: true,
                    navigateArrows: true, // Boolean, 'closeToModal', 'closeScreenEdge'
                    history: false,
                    restoreDefaultContent: false,
                    autoOpen: 0, // Boolean, Number
                    bodyOverflow: false,
                    fullscreen: <?php echo $allowFullscreen == 1 ? 'true' : 'false' ?>,
                    openFullscreen: false,
                    closeOnEscape: true,
                    closeButton: true,
                    appendTo: 'body', // or false
                    appendToOverlay: 'body', // or false
                    overlay: true,
                    overlayClose: true,
                    overlayColor: 'rgba(0, 0, 0, 0.4)',
                    timeout: false,
                    timeoutProgressbar: false,
                    pauseOnHover: false,
                    timeoutProgressbarColor: 'rgba(255,255,255,0.5)',
                    transitionIn: 'comingIn',
                    transitionOut: 'comingOut',
                    transitionInOverlay: 'fadeIn',
                    transitionOutOverlay: 'fadeOut',
                    onFullscreen: function(){},
                    onResize: function(){},
                    onOpening: function(){},
                    onOpened: function(){},
                    onClosing: function(){},
                    onClosed: function(){
											<?php
											if ($setCookie == 1) {
											?>
                        Cookies.set('stylistic-modal-' + <?php echo get_the_ID() ?>, true, {
                            expires: <?php echo !empty($cookieExpires) ? $cookieExpires : 7 ?>
                        });
											<?php
											}
											?>
                    },
                    afterRender: function(){}
                });

							<?php

							switch($mode) {
							case "Open after the page did load":
							?>
                if (Cookies.get('stylistic-modal-<?php echo get_the_ID() ?>') == undefined) {
                    setTimeout(function() {
                        $("#stylistic_modal-<?php echo get_the_ID() ?>").iziModal('open');
                    }, <?php echo $timeout > 0 ? ($timeout * 1000) : 0 ?>);
                }
							<?php
							break;
							case "Open after an element was clicked":
							?>
                $('<?php echo !empty($clickedElement) ? $clickedElement : "" ?>').on('click', function(e) {
                    e.preventDefault();
                    $("#stylistic_modal-<?php echo get_the_ID() ?>").iziModal('open');
                });
							<?php
							break;
							}

							?>
            });

        </script>
        <style>
          .iziModal .iziModal-header-title {
            font-size: 25px;
          }
          <?php
						if (!empty($headerTextColor)) {
							?>
          .stylistic-modal .iziModal-header * {
            color: <?php echo $headerTextColor ?>!important;
          }
          <?php
				}
				if (!empty($contentTextColor)) {
					?>
          .iziModal-content * {
            color: <?php echo $contentTextColor ?>
          }
          <?php
				}
			?>
        </style>
        <div id="stylistic_modal-<?php echo get_the_ID() ?>" class="stylistic-modal" style="display: none;">
          <p><?php the_content(); ?></p>
        </div>
				<?php
			}
		} else {

		}

		wp_reset_postdata();

		?>

		<?php
	}
}
