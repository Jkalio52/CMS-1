<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="author" content="">
    <link rel="icon" href="favicon.ico">
    <title><?= isset($page_title) ? $page_title : '' ?></title>
    <meta name="description" content="<?= isset($page_description) ? $page_description : '' ?>">
    <?= cssResources() ?>
</head>
<body>
<header>
    <div class="container">
        <nav class="navbar navbar-expand-md navbar-light">
            <a href="<?= (isset($_APP_CONFIG['_DOMAIN_ROOT']) ? $_APP_CONFIG['_DOMAIN_ROOT'] : '') ?>"
               class="navbar-brand logo">
                <?= isset($_APP_CONFIG['_NAME_FRONT']) ? $_APP_CONFIG['_NAME_FRONT'] : '' ?>
            </a>

            <button class="navbar-toggler collapsed" id="mobile-menu-burger" type="button" data-toggle="collapse"
                    data-target="#main-menu"
                    aria-controls="main-menu" aria-expanded="false" aria-label="">
                <span></span>
                <span></span>
                <span></span>
                <span></span>
            </button>

            <div class="collapse navbar-collapse" id="main-menu">
                <ul class="navbar-nav ml-auto justify-content-center align-items-center">
                    <li class="nav-item">
                        <a class="nav-link nav-hover<?= currentPage('about') ? ' current' : '' ?>" href="#">About Us</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link nav-hover<?= currentPage('blog') ? ' current' : '' ?>" href="#">Blog</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link nav-hover<?= currentPage('gallery') ? ' current' : '' ?>"
                           href="#">Gallery</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link nav-hover<?= currentPage('contact') ? ' current' : '' ?>"
                           href="#">Contact</a>
                    </li>
                    <li class="nav-item outline">
                        <a class="nav-link btn" href="#">Contact</a>
                    </li>
                    <li class="nav-item"><?= selfRender('Blog', 'public/search-form.php') ?></li>
                </ul>
            </div>
        </nav>
    </div>
</header>