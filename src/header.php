<!doctype html>
<html <?php language_attributes(); ?> >
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>" />

    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <title>
        <?php wp_title(); ?>
    </title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <?php wp_head(); ?>

</head>

<body <?php body_class(); ?>>
<div class="mobileNavContainer">
    <ul class="mobileNav">
        <?php get_template_part('navLinks') ?>
    </ul>
</div>
<header>
    <script>
        window.wp_site_url = "a<?php get_site_url(null, "/"); ?>"
    </script>
    <div class="container">
        <div class="fullWidth header">
            <div class="logo">
                Martin's movies
            </div>
<!--            -->
<!--            <div class="movieSearchResults"></div>-->

            <!--  This would usually be a WordPress nav  -->
            <ul class="mainNav dropdownNav">
                <?php get_template_part('navLinks') ?>
            </ul>

            <a class="mobileNavToggle">
                <i class="fa fa-bars" aria-hidden="true"></i>
            </a>
            <div class="searchContainer">
                <input type="text" class="movieSearch" placeholder="search">
                <span class="searchControls">
                    <i class="fa fa-search" aria-hidden="true"></i>
                    <i class="fa fa-close" aria-hidden="true"></i>
                </span>
                <div class="searchResults">


                </div>
            </div>




        </div>
    </div>
</header>

