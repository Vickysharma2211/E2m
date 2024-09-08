<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package E2m
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
    <!-- Font Family -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'e2m' ); ?></a>

<!-- Header Section is start -->
<header class="vs-header transparent-header">
            <div class="vs-container">
                <div class="vs-row">
                    <div class="logo-col">
                        <div class="main-logo">
                        <?php
                            $logo = get_field('logo', 'option'); 
                                if ($logo) {
                                    echo '<a href="' . home_url() . '">
                                            <img src="' . esc_url($logo['url']) . '" alt="Logo">
                                        </a>';
                                }
                            ?>                          
                        </div>
                    </div>
                    <div class="nav-col">
                        <div class="vs-navbar">
                        <button class="menu-toggle"><span></span><span></span><span></span></button>
                        <nav class="navigation">
                        <?php
			wp_nav_menu(
				array(
					'theme_location' => 'menu-1',
					'menu_id'        => 'primary-menu',
				)
			);
			?>
                        </nav>
                        </div>                      
                    </div>
                </div>
            </div>
        </header>

    <!-- Header Section is End -->
