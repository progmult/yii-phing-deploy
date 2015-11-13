<?php
	return array(
	'components' => array(
		// use a MySQL database
		'db' => array(
			'connectionString' => 'mysql:host=;dbname=',
			'emulatePrepare' => true,
			'username' => '',
			'password' => '',
			'charset' => 'utf8',
			'schemaCachingDuration' => 3600,
			'tablePrefix' => 'ib_',
			'enableProfiling' => false,
		),
	),
);
