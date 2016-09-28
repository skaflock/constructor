<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset='utf-8' />
  <meta http-equiv='X-UA-Compatible' content='IE=edge' />
  <meta name='keywords' content=''/>
  <meta name='description' content=''/>
  <meta name='viewport' content='width=device-width, initial-scale=1, minimal-ui'/>
  <meta property="og:type" content="website" />
  <meta property="og:url" content="<?= "http".($_SERVER[HTTPS] ? "s" : NULL)."://".$_SERVER[HTTP_HOST] ?>">
  <meta property="og:title" content="site title" />
  <meta property="og:description" content="" />
  <meta property="og:image" content="" />
  <title>site title</title>

  <!-- styles -->
  <link rel='stylesheet' href='/css/normalize.css'/>
  <link rel='stylesheet' href='<?= url_add_version('/css/main.min.css') ?>'/>
  <!-- /styles -->
</head>
<body class="<?= ($page == "index" ? "index" : "inner") ?>">
<!-- header -->
<header class="header">
  <div class="wrap"></div>
</header>
<!-- /header -->

<!-- content -->
<div class="content">
  <div class="wrap">
