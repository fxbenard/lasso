<?php

class aesopEditorAssets {

	function __construct(){

		add_action('wp_enqueue_scripts', array($this,'scripts'));
	}

	function scripts(){

		// only run on posts and pages if user is logged in
		if ( is_singular() && is_user_logged_in() ) {

			wp_enqueue_style('aesop-editor-style', AESOP_EDITOR_URL.'/public/assets/css/aesop-editor.css', AESOP_EDITOR_VERSION, true);

			wp_enqueue_script('jquery-ui-draggable');
			wp_enqueue_script('jquery-ui-droppable');
			wp_enqueue_script('jquery-ui-sortable');

			wp_enqueue_script('aesop-editor', AESOP_EDITOR_URL.'/public/assets/js/aesop-editor.js', array('jquery'), AESOP_EDITOR_VERSION, true);
			wp_localize_script('aesop-editor', 'aesop_editor',array(
				'ajaxurl' 			=> admin_url( 'admin-ajax.php' ),
				'editor' 			=> 'aesop-editor--content', // ID of editable content (without #)
				'post_status'		=> get_post_status( get_the_ID() ),
				'author'			=> is_user_logged_in() ? get_current_user_ID() : false,
				'upload'			=> AESOP_EDITOR_URL.'/includes/aesop-editor-upload.php',
				'nonce'				=> wp_create_nonce('aesop_editor'),
				'handle'			=> aesop_editor_handle(),
				'toolbar'			=> aesop_editor_toolbar(),
				'component_modal'	=> aesop_editor_component_modal(),
				'components'		=> aesop_editor_components()
			));
		}

	}

}
new aesopEditorAssets;