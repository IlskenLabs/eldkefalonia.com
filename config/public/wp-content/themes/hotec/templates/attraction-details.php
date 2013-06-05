<h3 class="spd-heading"><?php _e('Attraction Details','smooththemes'); ?></h3>
<ul class="project-detail-list">
    <?php if($st_page_options['attraction_distance']):
       // if(preg_match('/^[]'))
       
         $p_date =  $st_page_options['attraction_distance'];
        
     ?>
    <li><strong><?php _e('Distance','smooththemes'); ?></strong><?php  echo esc_html($p_date); ?></li>
    <?php endif; ?>
     <?php if($st_page_options['attraction_rating']): ?>
    <li><strong><?php _e('Client','smooththemes'); ?></strong><?php  echo esc_html($st_page_options['attraction_rating']); ?></li>
    <?php endif; ?>
    
     <?php if($st_page_options['attraction_price']): ?>
    <li><strong><?php _e('Price','smooththemes'); ?></strong><?php  echo esc_html($st_page_options['attraction_price']); ?></li>
    <?php endif; ?>
   
   <?php echo get_the_term_list( $post->ID, 'attraction_tag', '<li><strong>'.__('Tags','smooththemes').'</strong>', ', ', '</li>' ); ?> 
</ul>
<?php if($st_page_options['attraction_website']):
    $url = parse_url($st_page_options['attraction_website']);
    if($url['host']!=''){
        $link = $url['host'];
    }else{
        $link =esc_html($st_page_options['attraction_website']);
    }
 ?>
<a class="btn small" href="<?php echo esc_attr($st_page_options['attraction_website']); ?>"><?php echo __('Visit','smooththemes').' '.$link; ?></a>
<?php endif; ?>