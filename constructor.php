<?php
# функции
################################################################################
require("./constructor/functions.inc.php");

# вывод
################################################################################
header("Content-Type: text/html; charset=utf-8");

$apache_modules_needed = array_diff(array(
  'mod_headers',
  'mod_expires',
  'mod_rewrite',
), apache_get_modules());

if(count($apache_modules_needed)) {
  echo "Требуется установить недостающие модули Apache: ".implode(", ", $apache_modules_needed);
}

$page = isset($_GET["page"]) ? trim(str_replace('..', '', htmlspecialchars($_GET["page"], ENT_QUOTES)), '/') : "index";
if (file_exists(__DIR__."/pages/".$page."/index.php")) {
  $page = $page."/index";
} else if (!file_exists(__DIR__."/pages/".$page.".php")) {
  $page = "404";
}

LESS_build("/less/", "/css/", "main");
JS_build("/js/main.min.js", array("/js/core.js", "/js/main.js"));

include("header.php");
include("pages/".$page.".php");
include("footer.php");
?>
