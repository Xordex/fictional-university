<?php 

    get_header();

    while(have_posts()) {
        the_post();
        pageBanner();
         ?>

    <div class="container container--narrow page-section">

    <?php 
    $parentID = wp_get_post_parent_id(get_the_ID());
    if($parentID) {
?>
    
      <div class="metabox metabox--position-up metabox--with-home-link">
        <p>
          <a class="metabox__blog-home-link" href="<?php echo get_permalink($parentID);?>"><i class="fa fa-home" aria-hidden="true"></i> Back to <?php echo get_the_title($parentID); ?></a> 
          <span class="metabox__main"><?php the_title(); ?></span>
        </p>
      </div>
<?php }?>
        <?php
          if($parentID) {
            $findChildrenOf = $parentID;
          } else {
            $findChildrenOf = get_the_ID();
          } 

          $testArray = get_pages(array(
            'child_of' => get_the_ID()
          ));
          if($parentID or $testArray) {
        ?>

      <div class="page-links">
        <h2 class="page-links__title"><a href="<?php echo get_permalink($findChildrenOf); ?>"><?php echo get_the_title($findChildrenOf); ?></a></h2>
        <ul class="min-list">
          
        <?php
          wp_list_pages(array(
            'title_li' => NULL,
            'child_of' => $findChildrenOf,
            'sort_column' => 'menu_order'
          ));
          ?>
        </ul>
      </div>

      <?php } ?>

      <div class="generic-content">
        <form class="search-form" method="get" action="<?php echo esc_url(site_url('/'));?>">
            <label for="s" class="headline headline--medium">Perform a New Search:</label> 
            <div class="search-form-row">
                <input id="s" type="search" name="s" class="s" placeholder="What are you looking for?">
                <input class="search-submit" type="submit" value="Search">
            </div>
        </form>
        <?php the_content(); ?>
      </div>
    </div>

<?php
    }
    get_footer();
?>
