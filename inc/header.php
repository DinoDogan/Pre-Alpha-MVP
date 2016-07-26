<?php
if (isset($title))
    $title .= " | Magnificent";
else
    $title = "Magnificent - Convert PDFs to Blog Posts";

if (!isset($meta_keywords))
    $meta_keywords = "";

if (!isset($meta_description))
    $meta_description = "Magnificent converts your PDFs into a blog post with a simple click of a button. Try it out today.";
?><!DOCTYPE html>
<html class="no-js" lang="">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">

        <title><?php echo $title; ?></title>

        <!--
                   _____                        .__  _____.__                     __
                  /     \ _____     ____   ____ |__|/ ____\__| ____  ____   _____/  |_
                 /  \ /  \\__  \   / ___\ /    \|  \   __\|  |/ ___\/ __ \ /    \   __\
                /    Y    \/ __ \_/ /_/  >   |  \  ||  |  |  \  \__\  ___/|   |  \  |
                \____|__  (____  /\___  /|___|  /__||__|  |__|\___  >___  >___|  /__|
                       \/     \//_____/      \/                  \/    \/     \/
        -->

        <meta name="keywords"
              content="<?php echo $meta_keywords; ?>">
        <meta name="description"
              content="<?php echo $meta_description; ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="stylesheet" href="/css/vendor/bootstrap-3.3.6.min.css">
        <link rel="stylesheet" href="/css/normalize.css">
        <link rel="stylesheet" href="/css/main.css">

        <script type="text/javascript" src="/js/vendor/jquery-1.12.0.min.js"></script>
        <script type="text/javascript" src="/js/vendor/jquery.easing-1.3.min.js"></script>
        <script type="text/javascript" src="/js/vendor/bootstrap-3.3.6.min.js"></script>
        <script type="text/javascript" src="/js/main.js?v=1.0"></script>

        <!-- Facebook Open Graph -->

        <meta property="og:site_name" content="Magnificent">
        <meta property="og:url"
              content="http://<?php echo $_SERVER["HTTP_HOST"] . parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH); ?>">
        <meta property="og:title" content="<?php echo $title; ?>">
        <meta property="og:description" content="<?php echo $meta_description; ?>">
        <meta property="og:image" content="http://app.magnificent.com/ext/share.png">
        <meta property="og:type" content="business">

        <!-- Twitter -->

        <meta name="twitter:title" content="<?php echo $title; ?>">
        <meta property="twitter:description" content="<?php echo $meta_description; ?>">
        <meta name="twitter:card" content="summary_large_image">
        <meta property="twitter:image" content="http://app.magnificent.com/ext/share.png">
        <meta name="twitter:site" content="@MagnificentMktg">
        <meta name="twitter:domain" content="http://<?php echo $_SERVER["HTTP_HOST"]; ?>">
    </head>
    <!-- Check to see if the page should be using a theme (home-style). If yes, apply. If not, ignore. -->
    <body<?php echo(isset($home_style) ? ' class="home-style"' : ''); ?>>

        <!--[if lt IE 8]>
        <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a
            href="http://browsehappy.com/">upgrade
            your browser</a> to improve your experience.</p>
        <![endif]-->

        <div id="header">
            <div class="content">
                <nav class="navbar navbar-default text">
                    <div class="navbar-header" id="header-brand">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                                data-target="#header-nav" aria-expanded="false">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>

                        <a class="navbar-brand" href="/">
                            <div id="logo"></div>
                        </a>
                    </div>

                    <div class="collapse navbar-collapse" id="header-nav">
                        <ul class="nav navbar-nav navbar-right" id="header-links">
                            <?php
                                // strip URL down so we don't have to worry about serving
                                // project from different directories.
                                $script_name = pathinfo($_SERVER["SCRIPT_NAME"], PATHINFO_FILENAME);
                            ?>
                            <li>
                                <a href="/about.php"<?php echo($script_name == "about" ? ' class="bold"' : ''); ?>>About</a>
                            </li>
                            <li><a href="/faq.php"<?php echo($script_name == "faq" ? ' class="bold"' : ''); ?>>FAQ</a>
                            </li>
                            <li>
                                <a href="/contact.php"<?php echo($script_name == "contact" ? ' class="bold"' : ''); ?>>Contact</a>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
        </div>