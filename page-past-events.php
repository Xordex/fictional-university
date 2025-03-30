<?php

get_header();
$today = new DateTime();
pageBanner(array(
  'title' => 'Past Events',
  'subtitle' => 'A recap of our past events.'
));
?>

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
            
            get_template_part('template-parts/content-event');
       }

      echo paginate_links(array(
        'total' => $postsPast->max_num_pages
      ));

      

      wp_reset_postdata();
      ?>


    </div>

<?php
get_footer();
?>