<?php
defined('BASEPATH') or exit('No direct script access allowed');

$config['number'] = array(
	'scripts' => array(
		'assets/autoNumeric.js'
	)
);

$config['datatables'] = array(
	'scripts' => array(
		'assets/js/plugin/datatables/jquery.dataTables.min.js',
		'assets/js/plugin/datatables/dataTables.colVis.min.js',
		'assets/js/plugin/datatables/dataTables.tableTools.min.js',
		'assets/js/plugin/datatables/dataTables.bootstrap.min.js',
		'assets/js/plugin/datatable-responsive/datatables.responsive.min.js',
	)
);

$config['daterangepicker'] = array(
	'scripts' => array(
		'assets/vendor/daterangepicker-master/moment.min.js',
		'assets/vendor/daterangepicker-master/daterangepicker.js',
	),
	'styles' => array(
		'assets/vendor/daterangepicker-master/daterangepicker.css',
	)
);

// Hapus tab index di modal
$config['select2'] = array(
	'scripts' => array(
		'assets/js/plugin/select2/select2.min.js',
	)
);

$config['multiselect'] = array(
	'scripts' => array(
		'assets/js/plugin/multiselect/js/bootstrap-multiselect.js',
	)
);
