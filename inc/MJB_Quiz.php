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
       // wp_enqueue_style('mjbq-boostrap', plugins_url('/css/bootstrap.min.css', dirname(__FILE__)));
       // wp_enqueue_style('mjbq-boostrapscript', plugins_url('/js/bootstrap.min.js', dirname(__FILE__)));
        wp_enqueue_script('mjbq-script', plugins_url('/js/scripts.js', dirname(__FILE__)));
	}
	public function enqueueFrontScripts(){
		wp_enqueue_script('jquery');
        wp_enqueue_style('mjbq-front', plugins_url('/css/front.css', dirname(__FILE__)));
		wp_enqueue_script('mjbq-script', plugins_url('/js/front.js', dirname(__FILE__)));
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
		add_meta_box('mjb-quiz-shortcode','Quiz Shortcode',array($this, 'loadQuizShortcode'), 'mjb_quiz', 'side', 'high');
	} 
	public function loadQuizContent($post) {

			wp_nonce_field( 'mjb_quiz_nonce', 'mjb_quiz_nonce' );

			$value = get_post_meta( $post->ID, 'mjb_quiz_content_'.$post->ID, true );
			$value = json_decode(base64_decode($value), true);
			echo '<div class="container">';
			for($x = 1, $y = 1; $x <= 10; $x++, $y++){
				echo '<div class="mjbQuizContent row">';
				echo '<div class="col-8"><label for="mjbQuizQuestion">Question '. $y .'</label>';
				echo '<input name="mjbQuizQuestion'. $y .'" type="text" value="'. $value[$x]["question"] .'"/></div>';
				echo '<div class="col-4"><label for="mjbQuizQuestion'. $y .'Type">Question Type</label>';
				echo '<select class="mjbQuizQuestionType" value="'. $value[$x]["type"] .'" name="mjbQuizQuestion'. $y .'Type">';
				echo '<option value="" disabled>Select Question Type</option>';
				echo '<option value="multiplechoice">Multiple Choice</option>';
				echo '<option value="identification">Identification</option>';
				echo '<option value="essay">Essay</option>';
				echo '</select><div class="clr"></div></div><div class="clr"></div>';
				echo '<div class="multiplechoice">';
				echo '<div id="multiplechoice1">';
				echo '<div class="col-8"><label for="mjbQuizQuestion'. $x .'Choice1Content">Choice Value</label><input name="mjbQuizQuestion'. $x .'Choice1Content" type="text" value="'.$value[$x]["content"]["multiplechoice"]["choice1"]["answer"].'"/></div><div class="col-4"><label for="mjbQuizQuestion'. $x .'Choice1Score">Score</label><input name="mjbQuizQuestion'. $x .'Choice1Score" type="text" value="'.$value[$x]["content"]["multiplechoice"]["choice1"]["score"].'"/></div><div class="clr"></div>';
				echo '</div>';
				echo '<div id="multiplechoice2">';
				echo '<div class="col-8"><label for="mjbQuizQuestion'. $x .'Choice2Content">Choice Value</label><input name="mjbQuizQuestion'. $x .'Choice2Content" type="text" value="'.$value[$x]["content"]["multiplechoice"]["choice2"]["answer"].'"/></div><div class="col-4"><label for="mjbQuizQuestion'. $x .'Choice2Score">Score</label><input name="mjbQuizQuestion'. $x .'Choice2Score" type="text" value="'.$value[$x]["content"]["multiplechoice"]["choice2"]["score"].'"/></div><div class="clr"></div>';
				echo '</div>';
				echo '<div id="multiplechoice3">';
				echo '<div class="col-8"><label for="mjbQuizQuestion'. $x .'Choice3Content">Choice Value</label><input name="mjbQuizQuestion'. $x .'Choice3Content" type="text" value="'.$value[$x]["content"]["multiplechoice"]["choice3"]["answer"].'"/></div><div class="col-4"><label for="mjbQuizQuestion'. $x .'Choice3Score">Score</label><input name="mjbQuizQuestion'. $x .'Choice3Score" type="text" value="'.$value[$x]["content"]["multiplechoice"]["choice3"]["score"].'"/></div><div class="clr"></div>';
				echo '</div>';
				echo '<div id="multiplechoice4">';
				echo '<div class="col-8"><label for="mjbQuizQuestion'. $x .'Choice4Content">Choice Value</label><input name="mjbQuizQuestion'. $x .'Choice4Content" type="text" value="'.$value[$x]["content"]["multiplechoice"]["choice4"]["answer"].'"/></div><div class="col-4"><label for="mjbQuizQuestion'. $x .'Choice4Score">Score</label><input name="mjbQuizQuestion'. $x .'Choice4Score" type="text" value="'.$value[$x]["content"]["multiplechoice"]["choice4"]["score"].'"/></div><div class="clr"></div>';
				echo '</div>';
				echo '<div id="multiplechoice5">';
				echo '<div class="col-8"><label for="mjbQuizQuestion'. $x .'Choice5Content">Choice Value</label><input name="mjbQuizQuestion'. $x .'Choice5Content" type="text" value="'.$value[$x]["content"]["multiplechoice"]["choice5"]["answer"].'"/></div><div class="col-4"><label for="mjbQuizQuestion'. $x .'Choice5Score">Score</label><input name="mjbQuizQuestion'. $x .'Choice5Score" type="text" value="'.$value[$x]["content"]["multiplechoice"]["choice5"]["score"].'"/></div><div class="clr"></div>';
				echo '</div>';
				echo '</div>';
				echo '<div class="identification">';
				echo '<div class="col-8"><label for="mjbQuizQuestion'. $x .'IdentificationAnswer">Identification Answer</label><input name="mjbQuizQuestion'. $x .'IdentificationAnswer" type="text" value="'.$value[$x]["content"]["identification"]["answer"].'"/></div>';
				echo '<div class="col-4"><label for="mjbQuizQuestion'. $x .'IdentificationScore">Identification Score</label><input name="mjbQuizQuestion'. $x .'IdentificationScore" type="text" value="'. $value[$x]["content"]["identification"]["score"] .'"/></div><div class="clr"></div>';
				echo '</div>';
				echo '<div class="essay">';
				echo '<div class="col-8"><label for="mjbQuizQuestion'. $x .'EssayKeywords">Essay Keywords</label><textarea name="mjbQuizQuestion'. $x .'EssayKeywords" value="'. $value[$x]["content"]["essay"]["answer"] .'"></textarea></div>';
				echo '<div class="col-4"><label for="mjbQuizQuestion'. $x .'EssayScore">Essay Score</label><input name="mjbQuizQuestion'. $x .'EssayScore" type="text" value="'. $value[$x]["content"]["essay"]["score"] .'"/></div><div class="clr"></div>';
				echo '</div>';
				echo '<div class="clr"></div></div>';
			}
			echo '</div>';
			
	}
	public function loadQuizShortcode($post) {
		echo '<input type="text" value="[mjbQuiz id='.$post->ID.']" disabled/>';
	}
	public function saveMetaBoxData($post_id){
		
		$data = array();
		for($x = 0; $x < 10; $x++){
			$data[$x] = array(
				"id" => $_POST["mjbQuizQuestion".$x."Type"]."_q".$x,
				"question" => $_POST["mjbQuizQuestion".$x],
				"type" => $_POST["mjbQuizQuestion".$x."Type"],
				"content" => array(
					"identification" => array(
						"answer" => $_POST["mjbQuizQuestion".$x."IdentificationAnswer"],
						"score" => $_POST["mjbQuizQuestion".$x."IdentificationScore"]
					),
					"multiplechoice" => array(
						"choice1" => array(
							"answer" => $_POST["mjbQuizQuestion".$x."Choice1Content"],
							"score" => $_POST["mjbQuizQuestion".$x."Choice1Score"]
						),
						"choice2" => array(
							"answer" => $_POST["mjbQuizQuestion".$x."Choice2Content"],
							"score" => $_POST["mjbQuizQuestion".$x."Choice2Score"]
						),
						"choice3" => array(
							"answer" => $_POST["mjbQuizQuestion".$x."Choice3Content"],
							"score" => $_POST["mjbQuizQuestion".$x."Choice3Score"]
						),
						"choice4" => array(
							"answer" => $_POST["mjbQuizQuestion".$x."Choice4Content"],
							"score" => $_POST["mjbQuizQuestion".$x."Choice4Score"]
						),
						"choice5" => array(
							"answer" => $_POST["mjbQuizQuestion".$x."Choice5Content"],
							"score" => $_POST["mjbQuizQuestion".$x."Choice5Score"]
						)
			
					),
					"essay" => array(
						"answer" => $_POST["mjbQuizQuestion".$x."EssayKeywords"],
						"score" => $_POST["mjbQuizQuestion".$x."EssayScore"]
					)
				)
			); 
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
		$output = "<div id='quiz'>";
		foreach($data as $q){
			if($q["question"] != ""){
				$output .= "<div class='question'>".$q["question"]."</div>";
				if( $q["content"]["identification"]["answer"] != "" ){
					$output .= "<div class='identification'><input data-keywords='". $q["content"]["identification"]["answer"] ."' type='text' data-score='". $q["content"]["identification"]["score"] ."'id='". $q["id"] ."' value=''></div>";
				}else if( $q["content"]["multiplechoice"]["choice1"]["answer"] != ""  ){
					$output .= "<div class='choice'><input value='". $q["content"]["multiplechoice"]["choice1"]["answer"] ."' type='radio' name='choice-". $q["id"] ."' id='choice-". $q["id"] ."' data-score='". $q["content"]["multiplechoice"]["choice1"]["score"] ."'><label>". $q["content"]["multiplechoice"]["choice1"]["answer"] ."</label><div style='clear:both'></div></div>";
					if($q["content"]["multiplechoice"]["choice2"]["answer"] != "" ){
						$output .= "<div class='choice'><input value='". $q["content"]["multiplechoice"]["choice2"]["answer"] ."' type='radio' name='choice-". $q["id"] ."' id='choice-". $q["id"] ."' data-score='". $q["content"]["multiplechoice"]["choice2"]["score"] ."'><label>". $q["content"]["multiplechoice"]["choice2"]["answer"] ."</label><div style='clear:both'></div></div>";
					}
					if($q["content"]["multiplechoice"]["choice3"]["answer"] != "" ){
						$output .= "<div class='choice'><input value='". $q["content"]["multiplechoice"]["choice3"]["answer"] ."' type='radio' name='choice-". $q["id"] ."' id='choice-". $q["id"] ."' data-score='". $q["content"]["multiplechoice"]["choice3"]["score"] ."'><label>". $q["content"]["multiplechoice"]["choice3"]["answer"] ."</label><div style='clear:both'></div></div>";
					}
					if($q["content"]["multiplechoice"]["choice4"]["answer"] != "" ){
						$output .= "<div class='choice'><input value='". $q["content"]["multiplechoice"]["choice4"]["answer"] ."' name='choice-". $q["id"] ."' type='radio' id='choice-". $q["id"] ."' data-score='". $q["content"]["multiplechoice"]["choice4"]["score"] ."'><label>". $q["content"]["multiplechoice"]["choice4"]["answer"] ."</label><div style='clear:both'></div></div>";
					}
					if($q["content"]["multiplechoice"]["choice5"]["answer"] != "" ){
						$output .= "<div class='choice'><input type='radio' value='". $q["content"]["multiplechoice"]["choice5"]["answer"] ."' name='choice-". $q["id"] ."' id='choice-". $q["id"] ."' data-score='". $q["content"]["multiplechoice"]["choice5"]["score"] ."'><label>". $q["content"]["multiplechoice"]["choice5"]["answer"] ."</label><div style='clear:both'></div></div>";
					}

				}else if($q["content"]["essay"]["answer"] != ""){
					$output .= "<div class='essay'><textarea data-keywords='". $q["content"]["essay"]["answer"]  ."' data-score='". $q["content"]["essay"]["score"] ."' id='".$q["id"]."'></textarea></div>";
				}
				$output .= "<hr>";
			}
		}
		$output .= "<input type='button' id='submitQuiz' value='Submit'/>";
		$output .= "</div>";
		if ( $data ) {
			return $output;
		}else{
			return $id;
		}
	}

}
