<?php
defined('BASEPATH') OR exit('No direct script access allowed');
show_404($page = '', $log_error = FALSE);
echo "\nERROR: ",
	$heading,
	"\n\n",
	$message,
	"\n\n";