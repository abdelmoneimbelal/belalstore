<?php 

	function lang($phrase) {

		static $lang = array(

			//dashbord pages

			//navbar links

			'HOME_ADMIN' 	=> 'BELAL',
			'CAT' 			=> 'Categories',
			'ITEMS' 		=> 'Items',
			'MEMBERS' 		=> 'Members',
			'COMMENT' 		=> 'Comments',
			'STST' 			=> 'Statistics',
			'LOGS' 			=> 'Logs',
			'' => '',
			'' => '',
			'' => '',
			'' => '',
			'' => '',
			'' => '',

		);
       	
       	return $lang[$phrase];

	}
	