<?php

class MJB_Quiz {
	
	public function addActionsAndFilters() {
		
        add_action('admin_menu', array($this, 'addSettingsPage'));
		add_action( 'init', array($this, 'registerQuizCPT') );
		add_action( 'init', array($this, 'registerCertificateCPT') );
		add_action( 'add_meta_boxes', array($this, 'addMJBQMetaBoxes'));
		add_action( 'admin_enqueue_scripts', array($this, 'enqueueAdminScripts') );
    }
	public function enqueueAdminScripts(){
		wp_enqueue_script('jquery');
        wp_enqueue_style('mjbq-style', plugins_url('/css/style.css', dirname(__FILE__)));
       // wp_enqueue_style('mjbq-boostrap', plugins_url('/css/bootstrap.min.css', dirname(__FILE__)));
       // wp_enqueue_style('mjbq-boostrapscript', plugins_url('/js/bootstrap.min.js', dirname(__FILE__)));
        wp_enqueue_script('mjbq-script', plugins_url('/js/scripts.js', dirname(__FILE__)));
	}
	public function addSettingsPage(){
		add_menu_page('Quiz', 'MJB Quiz', 'manage_options', 'mjb-quiz', array($this, 'loadSettingsPageDashboard') );
		add_submenu_page( 'mjb-quiz', 'Quizzes', 'Quizzes', 'manage_options', 'edit.php?post_type=mjb_quiz', NULL );
		add_submenu_page( 'mjb-quiz', 'Certificates', 'Certificates', 'manage_options', 'edit.php?post_type=mjb_certificate', NULL );
		add_submenu_page('mjb-quiz', 'Settings', 'Settings', 'manage_options', 'mjb-quiz-settings', array($this, 'loadSettingsPageSettings') );
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

	} 
	
	public function loadQuizContent($post) {

			wp_nonce_field( 'mjb_quiz_nonce', 'mjb_quiz_nonce' );

			$value = get_post_meta( $post->ID, 'mjb_quiz_content_'.$post->ID, true );
			/* $value["mjbquestion"][$x]["question"] 
			$value["mjbquestion"][$x]["type"]
			$value["mjbquestion"][$x]["choice"][0]["content"]
			$value["mjbquestion"][$x]["choice"][0]["score"] 
			$value["mjbquestion"][$x]["choice"][1]["content"]
			$value["mjbquestion"][$x]["choice"][1]["score"]
			$value["mjbquestion"][$x]["choice"][2]["content"]
			$value["mjbquestion"][$x]["choice"][2]["score"]
			$value["mjbquestion"][$x]["choice"][3]["content"]
			$value["mjbquestion"][$x]["choice"][3]["score"]
			$value["mjbquestion"][$x]["choice"][4]["content"]
			$value["mjbquestion"][$x]["choice"][4]["score"]
			$value["mjbquestion"][$x]["identification"][0]["answer"]
			$value["mjbquestion"][$x]["identification"][0]["score"]
			$value["mjbquestion"][$x]["essay"][0]["keywords"]
			$value["mjbquestion"][$x]["essay"][0]["score"]*/
			echo '<div class="container">';
			for($x = 0, $y = 1; $x <= 10; $x++, $y++){
				echo '<div class="mjbQuizContent row">';
				echo '<div class="col-8"><label for="mjbQuizQuestion">Question '. $y .'</label>';
				echo '<input name="mjbQuizQuestion" type="text" value=""/></div>';
				echo '<div class="col-4"><label for="mjbQuizQuestionType">Question Type</label>';
				echo '<select class="mjbQuizQuestionType" name="mjbQuizQuestionType">';
				echo '<option value="multiplechoice">Multiple Choice</option>';
				echo '<option value="identification">Identification</option>';
				echo '<option value="essay">Essay</option>';
				echo '</select></div>';
				echo '<div class="multiplechoice">';
				echo '<div id="multiplechoice1">';
				echo '<label for="mjbQuizQuestionChoice1Content">Choice Value</label><input name="mjbQuizQuestionChoice1Content" type="text" value=""/><label for="mjbQuizQuestionChoice1Score">Choice Score</label><input name="mjbQuizQuestionChoice1Score" type="text" value=""/>';
				echo '</div>';
				echo '<div id="multiplechoice2">';
				echo '<label for="mjbQuizQuestionChoice2Content">Choice Value</label><input name="mjbQuizQuestionChoice2Content" type="text" value=""/><label for="mjbQuizQuestionChoice2Score">Choice Score</label><input name="mjbQuizQuestionChoice2Score" type="text" value=""/>';
				echo '</div>';
				echo '<div id="multiplechoice3">';
				echo '<label for="mjbQuizQuestionChoice3Content">Choice Value</label><input name="mjbQuizQuestionChoice3Content" type="text" value=""/><label for="mjbQuizQuestionChoice3Score">Choice Score</label><input name="mjbQuizQuestionChoice3Score" type="text" value=""/>';
				echo '</div>';
				echo '<div id="multiplechoice4">';
				echo '<label for="mjbQuizQuestionChoice4Content">Choice Value</label><input name="mjbQuizQuestionChoice4Content" type="text" value=""/><label for="mjbQuizQuestionChoice4Score">Choice Score</label><input name="mjbQuizQuestionChoice4Score" type="text" value=""/>';
				echo '</div>';
				echo '<div id="multiplechoice5">';
				echo '<label for="mjbQuizQuestionChoice5Content">Choice Value</label><input name="mjbQuizQuestionChoice5Content" type="text" value=""/><label for="mjbQuizQuestionChoice5Score">Choice Score</label><input name="mjbQuizQuestionChoice5Score" type="text" value=""/>';
				echo '</div>';
				echo '</div>';
				echo '<div class="identification">';
				echo '<label for="mjbQuizQuestionIdentificationAnswer">Identification Answer</label><input name="mjbQuizQuestionIdentificationAnswer" type="text" value=""/>';
				echo '<label for="mjbQuizQuestionIdentificationScore">Identification Score</label><input name="mjbQuizQuestionIdentificationScore" type="text" value=""/>';
				echo '</div>';
				echo '<div class="essay">';
				echo '<label for="mjbQuizQuestionEssayKeywords">Essay Keywords</label><input name="mjbQuizQuestionEssayKeywords" type="text" value=""/>';
				echo '<label for="mjbQuizQuestionEssayScore">Essay Score</label><input name="mjbQuizQuestionEssayScore" type="text" value=""/>';
				echo '</div>';
				echo '</div>';
			}
			echo '</div>';
			
	}
}
