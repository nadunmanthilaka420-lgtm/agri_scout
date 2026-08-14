<?php
ini_set('extension_dir', 'D:\\php-8.2.30-nts-Win32-vs16-x64\\ext');
var_export(@dl('php_pdo_oci.dll')); echo PHP_EOL;
var_export(@dl('php_oci8_19.dll')); echo PHP_EOL;
var_export(extension_loaded('pdo_oci')); echo PHP_EOL;
var_export(extension_loaded('oci8')); echo PHP_EOL;
