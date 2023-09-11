<!-- CONSTANTES REGEX -->
<?php

define('REGEX_CP', '/^(?:0[1-9]|[1-8]\d|9[0-8])\d{3}$/');
define('REGEX_NAME', "/^[a-zA-Z-' ]*$/");
define('REGEX_URL', "/((https?:\/\/)?((www|\w\w)\.)?linkedin\.com\/)((([\w]{2,3})?)|([^\/]+\/(([\w|\d\-&#?=])+\/?){1,}))$/");
define('REGEX_MID_PWD', "/^(?=.*[A-Z])(?=.*\d).{8,}$/");
define('REGEX_STRONG_PWD', "/^(?=.*[A-Z])(?=.*\d)(?=.*\W).{8,}$/");
define('REGEX_BIRTHDAY', '/^(0[1-9]|1[012])[-\/\.](0[1-9]|[12][0-9]|3[01])[-\/\.](19|20)\d\d$/');
