<?php

get_header();
pageBanner(array(
  'title' => 'Search Results',
  'subtitle' => 'You searched for ' . esc_html(get_search_query(false))
)); ?>

    <div class="container container--narrow page-section">
    <form class="search-form" method="get" action="<?php echo esc_url(site_url('/'));?>">
            <label for="s" class="headline headline--medium">Perform a New Search:</label> 
            <div class="search-form-row">
                <input id="s" type="search" name="s" class="s" placeholder="What are you looking for?" value="<?php echo get_search_query();?>">
                <input class="search-submit" type="submit" value="Search">
            </div>
        </form>
        <br/>
      <?php
      if(have_posts()) {
        while(have_posts()) {
            the_post();
            get_template_part('template-parts/content', get_post_type());
            ?>
            
      <?php  }} else {
        echo "No results for this term";
      }

      echo paginate_links();
      ?>
        

    </div>

<?php
get_footer();
?>