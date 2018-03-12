<?php

class MJB_Quiz {
	
	public function addActionsAndFilters() {
		
        add_action('admin_menu', array($this, 'addSettingsPage'));
		
        wp_enqueue_script('jquery');
        wp_enqueue_style('my-style', plugins_url('/css/styles.css', __FILE__));
        wp_enqueue_script('my-script', plugins_url('/js/scripts.js', __FILE__));

    }
	public function addSettingsPage(){
		add_menu_page('Quiz', 'MJB Quiz', 'manage_options', 'mjb-quiz', array($this, 'loadSettingsPageDashboard') );
		add_submenu_page('mjb-quiz', 'Quizzes', 'Quizzes', 'manage_options', 'mjb-quiz-quizzes', array($this, 'loadSettingsPageQuizzes'));
		add_submenu_page('mjb-quiz', 'Certificates', 'Certificates', 'manage_options', 'mjb-quiz-certificates',array($this, 'loadSettingsPageCertificates'));
		add_submenu_page('mjb-quiz', 'Settings', 'Settings', 'manage_options', 'mjb-quiz-settings', array($this, 'loadSettingsPageSettings') );
	}
	public function loadSettingsPageDashboard(){
		include 'MJB_Quiz-admin.php';
	}
	public function loadSettingsPageQuizzes(){
		include 'MJB_Quiz-quizzes.php';
	}
	public function loadSettingsPageCertificates(){
		include 'MJB_Quiz-certificates.php';
	}
	public function loadSettingsPageSettings(){
		include 'MJB_Quiz-settings.php';
	}
}