<?php
	
class MJB_Quiz_SQL {
	
	public function __construct(){
		global $wpdb;
		$table_name = $wpdb->prefix . 'mjbqquizzes';
		$table_name2 = $wpdb->prefix . 'mjbqcert';
		
		if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name && $wpdb->get_var("SHOW TABLES LIKE '$table_name2'") != $table_name2) {
			$this->addTable();
		}
	}
	
	public function addTable(){
		
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		
		global $wpdb;
		$table_name = $wpdb->prefix . 'mjbqquizzes';
		$table_name2 = $wpdb->prefix . 'mjbqcert';
		
		$charset_collate = $wpdb->get_charset_collate();
		$sql = "CREATE TABLE $table_name (
		id mediumint(9) NOT NULL AUTO_INCREMENT,
		quiz_name varchar(255) NOT NULL,
		quiz_author varchar(255) NOT NULL,
		quiz_content varchar(255) NOT NULL,
		quiz_url varchar(55) NOT NULL,
		PRIMARY KEY  (id)
		) $charset_collate;";
		$sql2 = "CREATE TABLE $table_name2 (
		id mediumint(9) NOT NULL AUTO_INCREMENT,
		cert_name varchar(255) NOT NULL,
		cert_author varchar(255) NOT NULL,
		cert_content varchar(255) NOT NULL,
		cert_url varchar(55) NOT NULL,
		PRIMARY KEY  (id)
		) $charset_collate;";
		
		
		dbDelta( $sql );
		dbDelta( $sql2 );
	}
	
}