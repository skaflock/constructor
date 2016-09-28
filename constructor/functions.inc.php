<?php

# функция для добавления к ссылке на файл параметра с датой изменения файла
# (для решения возможных проблем с кэшированием)
function url_add_version($fileURL){
  date_default_timezone_set('Europe/Moscow');
  $filePath = getenv("DOCUMENT_ROOT").$fileURL;
  if (file_exists($filePath)) {
    return $fileURL."?v=".date("YmdHis", filemtime($filePath));
  }
}

# LESS-сборщик
# https://github.com/oyejorge/less.php
function LESS_build($less_dir, $css_dir, $main_file){
  $DOCUMENT_ROOT = getenv("DOCUMENT_ROOT");
  $css_mtime = filemtime($DOCUMENT_ROOT.$css_dir.$main_file.".min.css");
  $less_files = array_filter(
    scandir($DOCUMENT_ROOT.$less_dir),
    function($file) use ($DOCUMENT_ROOT, $less_dir, $css_mtime){
      if (preg_match('/less$/i', $file)) {
        if (filemtime($DOCUMENT_ROOT.$less_dir.$file) > $css_mtime) {
          return true;
        }
      }
      return false;
    }
  );
  if (count($less_files)) {
    require_once($DOCUMENT_ROOT."/constructor/less_php/Less.php");
    $parser = new Less_Parser(array(
      "compress"  => true,
      "relativeUrls" => false,
      "sourceMap" => true,
      "sourceMapRootpath" => "/",
      "sourceMapBasepath" => $DOCUMENT_ROOT,
      "sourceMapWriteTo"  => $DOCUMENT_ROOT.$css_dir.$main_file.".min.css.map",
      "sourceMapURL"      => $main_file.".min.css.map"
    ));
    $parser->parseFile($DOCUMENT_ROOT.$less_dir.$main_file.".less");
    $css = $parser->getCss();
    file_put_contents($DOCUMENT_ROOT.$css_dir.$main_file.".min.css", $css);
  }
  return;
}

# JS-минификатор
# https://github.com/tchwork/jsqueeze
function JS_build($min_file, $file){
  $DOCUMENT_ROOT = getenv("DOCUMENT_ROOT");
  require_once($DOCUMENT_ROOT."/constructor/JSqueeze.php");
  $minifier = new Patchwork\JSqueeze();

  $js_min_file = $DOCUMENT_ROOT.$min_file;
  $js_min_mtime = file_exists($js_min_file) ? filemtime($js_min_file) : 0;

  if (is_array($file)) {
    $changed_files = array_filter(
      $file,
      function($f) use ($DOCUMENT_ROOT, $js_min_mtime){
        $js_file = $DOCUMENT_ROOT.$f;
        $js_mtime = file_exists($js_file) ? filemtime($js_file) : 0;
        return $js_mtime > $js_min_mtime;
      }
    );
    if (count($changed_files) || !$js_min_mtime) {
      $minified_js = '';
      foreach ($file as $f) {
        $js_file = $DOCUMENT_ROOT.$f;
        $minified_js .= file_exists($js_file) ? $minifier->squeeze(file_get_contents($js_file), true)."\n\n" : "";
      }
      return file_put_contents($js_min_file, $minified_js);
    } else {
      return 0;
    }
  } else {
    $js_file = $DOCUMENT_ROOT.$file;
    $js_mtime = file_exists($js_file) ? filemtime($js_file) : 0;
    if($js_mtime > $js_min_mtime) {
      $minified_js = $minifier->squeeze(file_get_contents($js_file), true);
      return file_put_contents($js_min_file, $minified_js);
    } else {
      return 0;
    }
  }
}

?>
