<?php 

class STTwitter extends WP_Widget {

	public function __construct() {
		// widget actual processes
        parent::__construct(
	 		'sttwitter', // Base ID
			__('ST Twitter','smooththemes'), // Name
			array( 'description' => '') // Args
		);
	}

 	public function form( $instance ) {
		// outputs the options form on admin
        
        if ( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
		}
		else {
			$title = '';
		}
        
        $number = intval($instance[ 'number' ]);
        
        $username = $instance['username'];
        
        if($number<=0){
            $number = 3; // default  = 3;
        }
        
		?>
		<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:','smooththemes'); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
        
 	  <p>
		<label for="<?php echo $this->get_field_id( 'username' ); ?>"><?php _e( 'Username:','smooththemes'); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'username' ); ?>" name="<?php echo $this->get_field_name( 'username' ); ?>" type="text" value="<?php echo esc_attr( $username ); ?>" />
		</p>
        
    	<p>
		<label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php echo __('How many items to show ? ' ,'smooththemes') ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="text" value="<?php echo esc_attr( $number ); ?>" />
		</p>
        
		<?php 
	}

	public function update( $new_instance, $old_instance ) {
		// processes widget options to be saved
        $instance = array();
		$instance['title'] = strip_tags( $new_instance['title'] );
 	    $instance['username'] = strip_tags( $new_instance['username'] );
        $instance[ 'number' ] = intval($new_instance[ 'number' ]);
		return $instance;
	}

	public function widget( $args, $instance ) {
		// outputs the content of the widget
            global $wpdb,$post;
            $instance = wp_parse_args($instance, array(
                    'title'=>'',
                    'number'=>'',
                    'username'=>'',
                    'avatar_size'=>'',
                    'template'=>'{text}',
            ));
            
            extract( $args );
            
    		$title = apply_filters( 'widget_title', $instance['title'] );
            $number = intval($instance['number'] );
            if($number<=0){
                $number = 3; // default  = 3;
            }
            
            $twitter_data = array(
                'avatar_size'=>intval($instance['avatar_size']),
                'count'=>intval($instance['number']), 
                'username'=>$instance['username'],
                'template'=>$instance['template']
            );
            
            $id = 't'.uniqid();
    		echo $before_widget;
    		if ( ! empty( $title ) )
    			echo $before_title . $title . $after_title;
                ?>
                <div class="twitter-update">
                        <ul id="<?php echo $id; ?>">
                            
                        </ul>
                        <script type="text/javascript">
                             var  twitter_<?php echo $id ?> = <?php echo json_encode($twitter_data); ?> ;
                        </script>
                    </div>
                <?php
 
        	echo $after_widget;
	}

}

register_widget( 'STTwitter' );