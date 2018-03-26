<?php

class MJB_Quiz {
	
	public function addActionsAndFilters() {
		
        add_action('admin_menu', array($this, 'addSettingsPage'));
		add_action( 'init', array($this, 'registerQuizCPT') );
		add_action( 'init', array($this, 'registerCertificateCPT') );
		add_action( 'add_meta_boxes', array($this, 'addMJBQMetaBoxes'));
		add_action( 'admin_enqueue_scripts', array($this, 'enqueueAdminScripts') );
		add_action( 'wp_enqueue_scripts', array($this, 'enqueueFrontScripts') );
		add_action('save_post', array($this, 'saveMetaBoxData'));
		add_shortcode('mjbQuiz', array($this, 'showAsShortcode'));
    }
	public function enqueueAdminScripts(){
		wp_enqueue_script('jquery');
        wp_enqueue_style('mjbq-style', plugins_url('/css/style.css', dirname(__FILE__)));
        wp_enqueue_script('mjbq-script', plugins_url('/js/scripts.js', dirname(__FILE__)));
		wp_enqueue_script('ajax_script', plugins_url('/js/ajax.js', dirname(__FILE__)));
		wp_localize_script('ajax_script', 'myAjax', array('url'=>admin_url('admin-ajax.php'), 'nonce' => wp_create_nonce("saveMetaBoxData_nonce")));
	}
	public function enqueueFrontScripts(){
		wp_enqueue_script('jquery');
        wp_enqueue_style('mjbq-front', plugins_url('/css/front.css', dirname(__FILE__)));
		wp_enqueue_script('mjbq-script', plugins_url('/js/front.js', dirname(__FILE__)));
	}
	public function addSettingsPage(){
		add_menu_page('Quiz', 'MJB Quiz', 'manage_options', 'mjb-quiz', array($this, 'loadSettingsPageDashboard') );
		add_submenu_page( 'mjb-quiz', 'Quizzes', 'Quizzes', 'manage_options', 'edit.php?post_type=mjb_quiz', NULL );
	}
	public function loadSettingsPageDashboard(){
		include 'MJB_Quiz-admin.php';
	}
	public function loadSettingsPageSettings(){
		include 'MJB_Quiz-settings.php';
	}
	public function registerQuizCPT() {
		$labels = array(
			'name'               => 'Quizzes',
			'singular_name'      => 'Quiz',
			'menu_name'          => 'Quizzes',
			'name_admin_bar'     => 'Quiz',
			'add_new'            => _x( 'Add New', 'quiz'),
			'add_new_item'       => 'Add New Quiz',
			'new_item'           => 'New Quiz',
			'edit_item'          => 'Edit Quiz',
			'view_item'          => 'View Quiz',
			'all_items'          => 'All Quiz',
			'search_items'       => 'Search Quiz',
			'parent_item_colon'  => 'Parent Quiz:',
			'not_found'          => 'No Quiz found.',
			'not_found_in_trash' => 'No Quiz found in Trash.'
		);

		$args = array(
			'labels'             => $labels,
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => false,
			'query_var'          => true,
			'rewrite'            => array( 'slug' => 'mjb-quiz' ),
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => false,
			'menu_position'      => null,
			'supports'           => array( 'title' )
		);

		register_post_type( 'mjb_quiz', $args );
	}	
	public function registerCertificateCPT() {
		$labels = array(
			'name'               => 'Certificates',
			'singular_name'      => 'Certificate',
			'menu_name'          => 'Certificates',
			'name_admin_bar'     => 'Certificate',
			'add_new'            => _x( 'Add New', 'certificate'),
			'add_new_item'       => 'Add New Certificate',
			'new_item'           => 'New Certificate',
			'edit_item'          => 'Edit Certificate',
			'view_item'          => 'View Certificate',
			'all_items'          => 'All Certificate',
			'search_items'       => 'Search Certificate',
			'parent_item_colon'  => 'Parent Certificate:',
			'not_found'          => 'No Certificate found.',
			'not_found_in_trash' => 'No Certificate found in Trash.'
		);

		$args = array(
			'labels'             => $labels,
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => false,
			'query_var'          => true,
			'rewrite'            => array( 'slug' => 'mjb-certificate' ),
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => false,
			'menu_position'      => null,
			'supports'           => array( 'title', 'thumbnail' )
		);

		register_post_type( 'mjb_certificate', $args );
	}
	public function addMJBQMetaBoxes() {

		add_meta_box('mjb-quiz-content','Quiz Content',array($this, 'loadQuizContent'), 'mjb_quiz', 'normal', 'high');
		add_meta_box('mjb-quiz-shortcode','Quiz Shortcode',array($this, 'loadQuizShortcode'), 'mjb_quiz', 'side', 'high');
	} 
	public function loadQuizContent($post) {

			wp_nonce_field( 'mjb_quiz_nonce', 'mjb_quiz_nonce' );
			
			include dirname(__FILE__).'/MJB_Quiz_Content.php';
	}
	public function loadQuizShortcode($post) {
		echo '<input type="text" value="[mjbQuiz id='.$post->ID.']" disabled/>';
	}
	public function saveMetaBoxData($post_id){
		$data = array();
		$x = 0;
		foreach($_POST as $key => $value) {
			if (strpos($key, 'mjbItemquestion_') === 0) {
				// value starts with mjbItemquestion_
				if(strpos($key, 'mjbItemquestion_Mul') === 0){
					if(strpos($key, 'mjbItemquestion_Mul') === 0){
						array_push($data["mul"]["q"]["question"], $value);
					}
					if(strpos($key, 'mjbItemquestion_Mul-a') === 0){
						array_push($data["mul"]["q"]["answer"], $value);
					}
					if(strpos($key, 'mjbItemquestion_Mul-s') === 0){
						array_push($data["mul"]["q"]["score"], $value);
					}
					if(strpos($key, 'mjbItemquestion_Mul-c1') === 0){
						array_push($data["mul"]["q"]["choice1"], $value);
					}
					if(strpos($key, 'mjbItemquestion_Mul-c2') === 0){
						array_push($data["mul"]["q"]["choice2"], $value);
					}
					if(strpos($key, 'mjbItemquestion_Mul-c3') === 0){
						array_push($data["mul"]["q"]["choice3"], $value);
					}
					if(strpos($key, 'mjbItemquestion_Mul-c4') === 0){
						array_push($data["mul"]["q"]["choice4"], $value);
					}
				}
				if(strpos($key, 'mjbItemquestion_Sb') === 0){
					array_push($data["sb"]["q"], $value);
				}
				if(strpos($key, 'mjbItemquestion_Ide') === 0){
					if(strpos($key, 'mjbItemquestion_Ide') === 0){
						array_push($data["id"]["q"]["question"], $value);
					}
					if(strpos($key, 'mjbItemquestion_Ide-a') === 0){
						array_push($data["id"]["q"]["answer"], $value);
					}
					if(strpos($key, 'mjbItemquestion_Ide-s') === 0){
						array_push($data["id"]["q"]["score"], $value);
					}
				}
				if(strpos($key, 'mjbItemquestion_Es') === 0){
					if(strpos($key, 'mjbItemquestion_Es') === 0){
						array_push($data["es"]["q"]["question"], $value);
					} 
					if(strpos($key, 'mjbItemquestion_Es-a') === 0){
						array_push($data["es"]["q"]["answer"], $value);
					}
					if(strpos($key, 'mjbItemquestion_Es-s') === 0){
						array_push($data["es"]["q"]["score"], $value);
					}
				}
				$x++;
			}
			
		}
		
		
		$key = base64_encode(json_encode($data));
		
		if(metadata_exists( 'post', $post_id, 'mjb_quiz_content_'.$post_id )){
			update_post_meta( $post_id,'mjb_quiz_content_'.$post_id, $key);
		}else{
			add_post_meta($post_id, 'mjb_quiz_content_'.$post_id, $key);
		}
		
	}
	public function showAsShortcode($atts){
		$atts = extract( shortcode_atts( array(
			'id' => '',
		), $atts ) );
		if ( ! $id ) return;
		$id   = $id; 
		$data = get_post_meta( $id, 'mjb_quiz_content_'.$id, true );
		$data = json_decode(base64_decode($data), true);

		if ( $data ) {
			return $data;
		}else{
			return $id;
		}
	}

}
