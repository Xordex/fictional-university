<?php 

    get_header();

    while(have_posts()) {
        the_post();
        $eventDate = new DateTime(get_field('event_date'));
        ?>
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
          <a class="metabox__blog-home-link" href="<?php echo get_post_type_archive_link('program'); ?>"><i class="fa fa-home" aria-hidden="true"></i> Programs</a> 
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
        
        
        <?php 
            $relatedProfs = new WP_Query(array(
             'posts_per_page' => -1,
              'post_type' => 'professor',
              'orderby' => 'title',
              'order' => 'ASC',
              'meta_query' => array(
                array(
                  'key' => 'related_programs',
                  'compare' => 'LIKE',
                  'value' => '"'. get_the_ID() . '"'
                )
              )
            ));
            
            if($relatedProfs->have_posts()) {

            echo '<hr class="section-break">';
            echo '<h2 class="headline headline--medium">Professors of '. get_the_title(). '</h2>';
            echo '<ul class="professor-cards">';

            while($relatedProfs-> have_posts()) {
              $relatedProfs-> the_post();

          ?>
    
            <li class="professor-card__list-item">
                 <a href="<?php the_permalink(); ?>" class="professor-card">
                    <img class="professor-card__image" src="<?php the_post_thumbnail_url('professorLandscape');?>" alt="">
                    <span class="professor-card__name"><?php the_title(); ?></span>
                 </a>
            </li>
            <?php
                }
                echo '</ul>';
            }
            
            wp_reset_postdata();
            ?>

        <?php 
            $relatedPosts = new WP_Query(array(
             'posts_per_page' => 2,
              'post_type' => 'event',
              'meta_key' => 'event_date',
              'orderby' => 'meta_value_num',
              'order' => 'ASC',
              'meta_query' => array(
                array(
                  'key' => 'related_programs',
                  'compare' => 'LIKE',
                  'value' => '"'. get_the_ID() . '"'
                )
              )
            ));
            
            if($relatedPosts->have_posts()) {

            echo '<hr class="section-break">';
            echo '<h2 class="headline headline--medium">Upcoming '. get_the_title(). ' Events</h2>';
            

            while($relatedPosts-> have_posts()) {
              $relatedPosts-> the_post();
            
          ?>

          <div class="event-summary">
            <a class="event-summary__date t-center" href="<?php echo get_permalink();?>">
              <span class="event-summary__month"><?php
              $eventDate =  new DateTime(get_field('event_date'));
              echo $eventDate->format('M');              
              ?></span>
              <span class="event-summary__day"><?php echo $eventDate->format('d') ?></span>
            </a>
            <div class="event-summary__content">
              <h5 class="event-summary__title headline headline--tiny"><a href="<?php echo get_permalink();?>"><?php the_title();?></a></h5>
              <p><?php if(has_excerpt()) {echo get_the_excerpt();} else {echo wp_trim_words(get_the_content(), 12);} ?> <a href="<?php echo get_permalink();?>" class="nu gray">Learn more</a></p>
            </div>
            </div>
            <?php
                }
            }
            ?>


    </div>
    <?php }

        get_footer();
?>