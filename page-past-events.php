<?php

get_header();
$today = new DateTime();
?>

    <div class="page-banner">
      <div class="page-banner__bg-image" style="background-image: url(<?php echo get_theme_file_uri('images/ocean.jpg');?>)"></div>
      <div class="page-banner__content container container--narrow">
        <h1 class="page-banner__title">Past Events
        </h1>
        <div class="page-banner__intro">
          <p>A recap of our past events.</p>
        </div>
      </div>
    </div>

    <div class="container container--narrow page-section">
      <?php
      $postsPast = new WP_Query(array(
        'paged' => get_query_var('paged', 1),
        'post_type' => 'event',
        'oderby' => 'meta_value_num',
        'meta_key' => 'event_date',
        'order' => 'ASC',
        'meta_query' => array(
            array(
                'key' => 'event_date',
                'compare' => '<',
                'value' => date('Ymd'),
                'type' => 'numeric'
            )
        )
      ));

        while($postsPast->have_posts()) {
            $postsPast->the_post(); 
            $eventDate = new DateTime(get_field('event_date'));
            ?>
            <div class="event-summary">
            <a class="event-summary__date t-center <?php if($today>$eventDate) {echo "aftereventcol";}?>" href="<?php echo get_permalink();?>">
              <span class="event-summary__month"><?php echo $eventDate->format('M'); ?></span>
              <span class="event-summary__day"><?php echo $eventDate->format('d'); ?></span>
            </a>
            <div class="event-summary__content">
              <h5 class="event-summary__title headline headline--tiny"><a href="<?php echo get_permalink();?>"><?php the_title();?></a></h5>
              <p><?php if(has_excerpt()) {echo get_the_excerpt();} else {echo wp_trim_words(get_the_content(), 12);} ?> <a href="<?php echo get_permalink();?>" class="nu gray">Learn more</a></p>
            </div>
            </div>
      <?php  }

      echo paginate_links(array(
        'total' => $postsPast->max_num_pages
      ));

      

      wp_reset_postdata();
      ?>


    </div>

<?php
get_footer();
?>