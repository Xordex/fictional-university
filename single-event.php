<?php 

    get_header();

    while(have_posts()) {
        the_post();
        $eventDate = new DateTime(get_field('event_date'));
        pageBanner();
        ?>

    <div class="container container--narrow page-section">
    <div class="metabox metabox--position-up metabox--with-home-link">
        <p>
          <a class="metabox__blog-home-link" href="<?php echo get_post_type_archive_link('event'); ?>"><i class="fa fa-home" aria-hidden="true"></i> Events</a> 
          <span class="metabox__main"><?php echo the_title(); ?></span>
        </p>
        
      </div>
      <a class="event-summary__date t-center" style="left: inherit;right:5%; top: -25%;">
              <span class="event-summary__month"><?php echo $eventDate->format('M'); ?></span>
              <span class="event-summary__day"><?php echo $eventDate->format('d'); ?></span>
            </a>

        <div class="generic-content">
            <?php the_content(); ?>
        </div>
        <?php $rel = get_field('related_programs');
        if($rel) { ?>
        <hr class='section-break'>
        <h2 class="headline headline--medium">Related Programs</h2>
        <ul class="link-list min-list">
        <?php
        foreach($rel as $elo) { ?>
          <li><a href="<?php the_permalink($elo);?>"><?php echo get_the_title($elo); ?></a></li>
          <?php
        }
      }
           ?>
        </ul>

    </div>
    <?php }

        get_footer();
?>