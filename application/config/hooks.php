<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$hook['post_system'][] = array(
        'class' => 'QueryLogHook',
        'function' => 'log_queries',
        'filename' => 'QueryLogHook.php',
        'filepath' => 'hooks');

/*
| -------------------------------------------------------------------------
| Hooks
| -------------------------------------------------------------------------
| This file lets you define "hooks" to extend CI without hacking the core
| files.  Please see the user guide for info:
|
|	https://codeigniter.com/user_guide/general/hooks.html
|
*/

?>