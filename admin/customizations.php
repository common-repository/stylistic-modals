<?php

add_action('admin_head', 'drsm_add_custom_content_to_header');
add_action('admin_footer', 'drsm_add_custom_content_to_footer');

if (!function_exists('drsm_add_custom_content_to_footer')) {
	function drsm_add_custom_content_to_footer() {
		?>
    <div id="stylistic_modal-preview-<?php echo get_the_ID() ?>" class="stylistic-modal" style="display: none;">
      <p>
        Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum.
      </p>
    </div>
		<?php
	}
}

if (!function_exists('drsm_add_custom_content_to_header')) {
	function drsm_add_custom_content_to_header() {
		?>
    <script>
        jQuery(function($){
            $("body.post-type-stylisticmodal #modalsettings h2").append(' <a id="showPreview" onClick="drsm_openStylisticModalsPreview()" style="margin-left: 15px;vertical-align:1px;font-size: 13px;">Preview</a>');

            $('select#border-radius-style').change(function(e) {
                $('select#border-radius-style option').each(function() {
                    //console.log($(this)[0].value);
                    if ( $(this)[0].value == e.target.value ) {
                        $(this).attr('selected', true)
                    } else {
                        $(this).removeAttr('selected');
                    }
                })
            });
        });

        function drsm_openStylisticModalsPreview() {

					<?php
					// User Options
					$headline = get_post_meta(get_the_id(), 'headline', true);
					$subtitle = get_post_meta(get_the_id(), 'subtitle', true);
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
					?>

            jQuery(document).ready(function($) {
                $('stylistic_modal-preview-<?php echo get_the_ID() ?>').append(jQuery('.editor-block-list__layout').text());

                var borderRadiusSelect = $('select#border-radius-style option[selected]')[0].value;
                var borderRadius = 100;
                switch (borderRadiusSelect) {
                    case 'No border radius':
                        borderRadius = 0;
                        break;
                    case 'Rounded':
                        borderRadius = 5;
                        break;
                    case 'Very rounded':
                        borderRadius = 20;
                        break;
                }

                $("#stylistic_modal-preview-<?php echo get_the_ID() ?>").iziModal('destroy');
                $("#stylistic_modal-preview-<?php echo get_the_ID() ?>").iziModal( {
                    title: $('input#headline')[0].value,
                    subtitle: $('input#subtitle')[0].value,
                    headerColor: $('input#header-background-color')[0].value,
                    background: $('input#content-background-color')[0].value,
                    theme: '',  // light
                    icon: null,
                    iconText: null,
                    iconColor: '',
                    rtl: false,
                    width: $('input#modal-width')[0].value + 'px',
                    top: null,
                    bottom: null,
                    borderBottom: true,
                    padding: 0,
                    radius: borderRadius,
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
                    fullscreen: false,
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
                    onClosed: function(){},
                    afterRender: function(){}
                });

                $('#showPreview').on('click', function(e) {
                    e.preventDefault();
                    $("#stylistic_modal-preview-<?php echo get_the_ID() ?>").iziModal('open');
                });

                $('.stylistic-modal .iziModal-header *').css({
                    color: $('input#header-text-color')[0].value
                });
                $('.iziModal-content *').css({
                    color: $('input#content-text-color')[0].value
                });
            });

        }
    </script>

    <style>
      .iziModal .iziModal-header-title {
        font-size: 25px;
      }
      .iziModal-content * {
        font-size: 17px!important;
        color: #444;
        font-weight: 300;
        line-height: 1.9em;
      }
    </style>
		<?php
	}

}
