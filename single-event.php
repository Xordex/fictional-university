<?php 

    get_header();

    while(have_posts()) {
        the_post(); ?>
    <div class="page-banner">
      <div class="page-banner__bg-image" style="background-image: url(<?php echo get_theme_file_uri('images/ocean.jpg');?>)"></div>
      <div class="page-banner__content container container--narrow">
        <h1 class="page-banner__title"><?php the_title(); ?></h1>
        <div class="page-banner__intro">
          <p>Dont forget to replace me later</p>
        </div>
      </div>
    </div>

    <div class="container container--narrow page-section">
    <div class="metabox metabox--position-up metabox--with-home-link">
        <p>
          <a class="metabox__blog-home-link" href="<?php echo get_post_type_archive_link('event'); ?>"><i class="fa fa-home" aria-hidden="true"></i> Events</a> 
          <span class="metabox__main"><?php echo the_title(); ?></span>
        </p>
        
      </div>
      <a class="event-summary__date t-center" style="left: inherit;right:5%; top: -25%;">
              <span class="event-summary__month"><?php the_time('M'); ?></span>
              <span class="event-summary__day"><?php the_time('d'); ?></span>
            </a>

        <div class="generic-content">
            <?php the_content(); ?>
        </div>
    </div>
    <?php }

        get_footer();
?>