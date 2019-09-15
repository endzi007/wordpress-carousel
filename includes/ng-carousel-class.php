<?php
/**
 * Adds Divi Carousel widget.
 */
 class NG_Carousel_Widget extends WP_Widget {
  
    /**
     * Register widget with WordPress.
     */
    function __construct() {
      parent::__construct(
        'divicarousel_widget', // Base ID
        esc_html__( 'Post carousel', 'divi_carousel_domain' ), // Name
        array( 'description' => esc_html__( 'Widget to display Post category in carousel', 'dc_domain' ), ) // Args
      );
    }
  
    /**
     * Front-end display of widget.
     *
     * @see WP_Widget::widget()
     *
     * @param array $args     Widget arguments.
     * @param array $instance Saved values from database.
     */
    public function widget( $args, $instance ) {
      echo $args['before_widget']; // Whatever you want to display before widget (<div>, etc)

      if ( ! empty( $instance['title'] ) ) {
        echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
      }
        echo '<div class="main-carousel" style="width: 300px">';

        $cat_id = get_cat_ID($instance['post_category']);
        $posts = get_posts(array("category"=>$cat_id, "numberposts"=>10));
        //print_r($posts);
        
          foreach ($posts as $key => $post) {
            $thumbnailUrl= get_the_post_thumbnail_url($post->ID);
            $post_excerpt = $post->post_excerpt;

            echo "<div class='carousel-cell' style= 'background: no-repeat center/cover url($thumbnailUrl) '>";
            echo "<p style='display:block; width: 100%; background-color: white; color: black;'>$post_excerpt</p>";
            echo "</div>";
          }
          echo '</div>';
          // Reset Query
          wp_reset_query();
      
      echo $args['after_widget']; // Whatever you want to display after widget (</div>, etc)
    }
  
    /**
     * Back-end widget form.
     *
     * @see WP_Widget::form()
     *
     * @param array $instance Previously saved values from database.
     */
    public function form( $instance ) {
      $title = ! empty( $instance['title'] ) ? $instance['title'] : esc_html__( 'Divi Carousel', 'dc_domain' ); 
      $categories = get_categories();
      $post_category = ! empty( $instance['post_category'] ) ? $instance['post_category'] : esc_html__( 'techguyweb', 'dc_domain' ); 

      ?>
       
      <!-- TITLE -->
      <p>
        <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>">
          <?php esc_attr_e( 'Title:', 'dc_domain' ); ?>
        </label> 

        <input 
          class="widefat" 
          id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" 
          name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" 
          type="text" 
          value="<?php echo esc_attr( $title ); ?>">
      </p>

      <!-- Select category -->
      <p>
        <label for="<?php echo esc_attr( $this->get_field_id( 'post_category' ) ); ?>">
          <?php esc_attr_e( 'Select category:', 'dc_domain' ); ?>
        </label> 

        <select 
          class="widefat" 
          id="<?php echo esc_attr( $this->get_field_id( 'post_category' ) ); ?>" 
          name="<?php echo esc_attr( $this->get_field_name( 'post_category' ) ); ?>">
          <?php 
          foreach($categories as $category) {
            $selected = '';
            if($instance['post_category']===$category->name){
              $selected = 'selected';
            }
            echo "<option value={$category->name} class='col-md-4' $selected> $category->name </option>";
          }
          ?>
        </select>
      </p>


      <?php 
    }
  
    /**
     * Sanitize widget form values as they are saved.
     *
     * @see WP_Widget::update()
     *
     * @param array $new_instance Values just sent to be saved.
     * @param array $old_instance Previously saved values from database.
     *
     * @return array Updated safe values to be saved.
     */
    public function update( $new_instance, $old_instance ) {
      $instance = array();

      $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';

      $instance['post_category'] = ( ! empty( $new_instance['post_category'] ) ) ? strip_tags( $new_instance['post_category'] ) : '';
  
      return $instance;
    }
  
  } // class Foo_Widget