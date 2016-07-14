<!doctype html>
<html class="no-js" lang="">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <title><?php echo(isset($title) ? "$title | Magnificent" : "Magnificent - Convert PDFs to Blog Posts"); ?></title>

    <meta name="description"
          content="Magnificent converts your PDFs into a blog post with a simple click of a button. Try it out today.">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"
          integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7"
          crossorigin="anonymous">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/main.css">
    <script src="js/vendor/modernizr-2.8.3.min.js"></script>
</head>
<body<?php echo(isset($home_style) ? ' class="home-style"' : ''); ?>>
<!--[if lt IE 8]>
<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade
    your browser</a> to improve your experience.</p>
<![endif]-->
<div id="header">
    <div class="content">
        <div id="header-left">
            <a href="index.php">
                <div id="logo"></div>
            </a>
        </div>
        <div id="header-right">
            <div id="header-links">
                <?php
                // strip stuff down so we don't have to worry about serving
                // project from different directories.
                $script_name = pathinfo($_SERVER["SCRIPT_NAME"], PATHINFO_FILENAME);
                ?>
                <a href="about.php"<?php echo($script_name == "about" ? ' class="bold"' : ''); ?>>About</a>
                <a href="faq.php"<?php echo($script_name == "faq" ? ' class="bold"' : ''); ?>>FAQ</a>
                <a href="contact.php"<?php echo($script_name == "contact" ? ' class="bold"' : ''); ?>>Contact</a>
            </div>
        </div>
    </div>
</div>