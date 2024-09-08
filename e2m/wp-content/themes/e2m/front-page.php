<?php
/**
 * Template Name: Front Page Tempalte
 *
 * 
 *
 * @package YourThemeName
 */

get_header(); ?>

<main id="primary" class="site-main">
 
   <?php if( have_rows('home_page_layout') ): ?>
    <?php while( have_rows('home_page_layout') ): the_row(); ?>
            <?php if( get_row_layout() == 'hero_section' ): ?>                
                	     <!-- Banner Section is Start -->
                            <section class="vs-banner" style="background-image:url(<?php the_sub_field('hero_background_image'); ?>)">
                                <div class="vs-container">
                                    <div class="vs-banner-content">                                        
                                        <h6><?php the_sub_field('hero_sub_title'); ?></h6>
                                        <h1><?php the_sub_field('hero_title'); ?></h1>
                                    </div>
                                </div>
                            </section>
                            
                        <!-- Banner Section is End  -->

                        <section class="property-section">
                            <div class="vs-container">
                                <div class="vs-row">
                                    <div class="title-col">
                                        <h2>Current Listings</h2>
                                    </div>
                                </div>
                                <div class="property-vs">
                                    <div class="property-col">
                                        <?php echo do_shortcode('[property_tabs_load_more]'); ?>
                                    </div>

                                </div>
                            </div>

                        </section>

                       


                
            <?php endif; ?>
        <?php endwhile; ?>
    <?php endif; ?>

</main><!-- #main -->


<?php
get_footer();

