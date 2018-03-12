<?php
function MJB_Quiz_init($file) {

    require_once(dirname(__FILE__).'/inc/MJB_Quiz.php');
    require_once(dirname(__FILE__).'/inc/MJB_Quiz-sql.php');
    $aPlugin = new MJB_Quiz();
	$bPlugin = new MJB_Quiz_SQL();
	
    // Add callbacks to hooks
    $aPlugin->addActionsAndFilters();
}