<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

// Create Widget
class LoopTaxWidget extends WP_Widget{

      // constructor
      function LoopTaxWidget() {
      parent::__construct(

            // base ID of the widget
            'Loop_Tax_widget',

            // name of the widget
            __('Taxonomy Loop', 'LoopTaxWidget' ),

            // widget options/description
            array (
                  'description' => __( 'A widget to loop a custom Taxonomy with options', 'LoopTaxWidget' ),
                  'panels_icon' =>  'dashicons dashicons-tag'
            )
            );
      }

      function form($instance){
            $instance = wp_parse_args( (array) $instance, array( 'title' => '' ) );
            $title = $instance['title'];

      // Check if variables exist or not
      if ( isset( $instance[ 'chosentax' ] ) ) {
            $chosentax = $instance[ 'chosentax' ];
      }else {
            $chosentax = 0;
      }

      if ( isset( $instance[ 'orderby' ] ) ) {
            $orderby = $instance[ 'orderby' ];
      }else {
            $orderby = 0;
      }

      if ( isset( $instance[ 'order' ] ) ) {
            $order = $instance[ 'order' ];
      }else {
            $order = 0;
      }

      if ( isset( $instance[ 'showtitle' ] ) ) {
            $showtitle = $instance[ 'showtitle' ] ? 'true' : 'false';
      }else{
            $showtitle = 0;
      }

      if ( isset( $instance[ 'linked' ] ) ) {
            $linked = $instance[ 'linked' ] ? 'true' : 'false';
      }else{
            $linked = 0;
      }

      if ( isset( $instance[ 'titlepos' ] ) ) {
            $titlepos = $instance[ 'titlepos' ] ? 'true' : 'false';
      }else{
            $titlepos = 0;
      }

      if ( isset( $instance[ 'showimg' ] ) ) {
            $showimg = $instance[ 'showimg' ] ? 'true' : 'false';
      }else{
            $showimg = 0;
      }

      if ( isset( $instance[ 'showurl' ] ) ) {
            $showurl = $instance[ 'showurl' ] ? 'true' : 'false';
      }else{
            $showurl = 0;
      }

      if ( isset( $instance[ 'desc' ] ) ) {
            $desc = $instance[ 'desc' ] ? 'true' : 'false';
      }else{
            $desc = 0;
      }

      if ( isset( $instance[ 'more' ] ) ) {
            $more = $instance[ 'more' ] ? 'true' : 'false';
      }else{
            $more = 0;
      }

      if ( isset( $instance[ 'more_text' ] ) ) {
            $more_text = $instance['more_text'];
      }else{
            $more_text = '';
      }

      if ( isset( $instance[ 'maxterms' ] ) ) {
            $maxterms = $instance['maxterms'];
      }else{
            $maxterms = 999;
      }

        $args = array(
            'public'   => true, 
        ); 
        $output = 'names'; // or objects
        $operator = 'and'; // 'and' or 'or'
        $taxonomies = get_taxonomies( $args, $output, $operator );
?>

      <!-- Title -->
      <p>
            <label for="<?php echo $this->get_field_id('title'); ?>">
            Title: 
                  <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
            </label> 
      </p>

      <!-- Select taxonomy -->
      <label for="<?php echo $this->get_field_name( 'chosentax' ); ?>"><?php _e( 'Taxonomy' ); ?></label> 
      <br>
      <select id="<?php echo $this->get_field_id( 'chosentax' ); ?>" name="<?php echo $this->get_field_name( 'chosentax' ); ?>">
            <?php
            foreach( $taxonomies as $taxonomy) { ?>
                  <option value='<?php echo $taxonomy; ?>' <?php echo ($chosentax==$taxonomy)?'selected':''; ?>>
                        <?php echo $taxonomy; ?>
                  </option>
            <?php
            }
            $selected = $chosentax ? 'selected' : '';
            ?>
      </select>
      <hr>
      <?php 

      if ( ! isset( $instance['showtitle'] ) )
            $instance['showtitle'] = 0;    

      if ( ! isset( $instance['titlepos'] ) )
            $instance['titlepos'] = 0;

      if ( ! isset( $instance['linked'] ) )
            $instance['linked'] = 0;

      if ( ! isset( $instance['showimg'] ) )
            $instance['showimg'] = 0;

      if ( ! isset( $instance['showurl'] ) )
            $instance['showurl'] = 0;

      if ( ! isset( $instance['desc'] ) )
            $instance['desc'] = 0;

      if ( ! isset( $instance['more'] ) )
            $instance['more'] = 0;

      if ( ! isset( $instance['maxterms'] ) )
            $instance['maxterms'] = 999;
      ?>

      <!-- Title -->
      <input class="checkbox" type="checkbox" <?php checked( $instance[ 'showtitle' ], 'on' ); ?> id="<?php echo $this->get_field_id( 'showtitle' ); ?>" name="<?php echo $this->get_field_name( 'showtitle' ); ?>" /> 
      <label for="<?php echo $this->get_field_id( 'showtitle' ); ?>">Show Title </label>

      <hr />
      <!-- Link -->
      <input class="checkbox" type="checkbox" <?php checked( $instance[ 'linked' ], 'on' ); ?> id="<?php echo $this->get_field_id( 'linked' ); ?>" name="<?php echo $this->get_field_name( 'linked' ); ?>" /> 
      <label for="<?php echo $this->get_field_id( 'linked' ); ?>"><?php echo _e( 'Link on title' );?> </label>

      <hr />
      <!-- url -->
      <input class="checkbox" type="checkbox" <?php checked( $instance[ 'showurl' ], 'on' ); ?> id="<?php echo $this->get_field_id( 'showurl' ); ?>" name="<?php echo $this->get_field_name( 'showurl' ); ?>" /> 
      <label for="<?php echo $this->get_field_id( 'showurl' ); ?>">Use custom url </label>

      <hr />
      <!-- Image -->
      <input class="checkbox" type="checkbox" <?php checked( $instance[ 'showimg' ], 'on' ); ?> id="<?php echo $this->get_field_id( 'showimg' ); ?>" name="<?php echo $this->get_field_name( 'showimg' ); ?>" /> 
      <label for="<?php echo $this->get_field_id( 'showimg' ); ?>"><?php echo _e('Show image');?> </label>

      <hr />
      <!-- Title position -->
      <input class="checkbox" type="checkbox" <?php checked( $instance[ 'titlepos' ], 'on' ); ?> id="<?php echo $this->get_field_id( 'titlepos' ); ?>" name="<?php echo $this->get_field_name( 'titlepos' ); ?>" /> 
      <label for="<?php echo $this->get_field_id( 'titlepos' ); ?>">Title under image </label>

      <hr />
      <!-- Description -->
      <input class="checkbox" type="checkbox" <?php checked( $instance[ 'desc' ], 'on' ); ?> id="<?php echo $this->get_field_id( 'desc' ); ?>" name="<?php echo $this->get_field_name( 'desc' ); ?>" /> 
      <label for="<?php echo $this->get_field_id( 'desc' ); ?>">Description </label>

      <hr />
      <!-- Read more -->
      <input class="checkbox" type="checkbox" <?php checked( $instance[ 'more' ], 'on' ); ?> id="<?php echo $this->get_field_id( 'more' ); ?>" name="<?php echo $this->get_field_name( 'more' ); ?>" /> 
      <label for="<?php echo $this->get_field_id( 'more' ); ?>">More Link </label>

      <!-- read more text -->
      <p>
            <label for="<?php echo $this->get_field_id('more_text'); ?>">
                  <?php echo _e('More text ');?> 
                  <input class="widefat" id="<?php echo $this->get_field_id('more_text'); ?>" name="<?php echo $this->get_field_name('more_text'); ?>" type="text" value="<?php echo esc_attr($more_text); ?>" />
            </label>
      </p>
      
      <hr />
      <!-- orderby -->
      <label for="<?php echo $this->get_field_name( 'orderby' ); ?>"><?php _e( 'Order by' ); ?></label> 
      <br>
      <select id="<?php echo $this->get_field_id('orderby'); ?>" name="<?php echo $this->get_field_name( 'orderby' ); ?>">
            <option value='name' <?php echo ($orderby=='name')?'selected':''; ?>>
                  Name
            </option>
            <option value='slug' <?php echo ($orderby=='slug')?'selected':''; ?>>
                  Slug
            </option>
            <option value='term_group' <?php echo ($orderby=='term_group')?'selected':''; ?>>
                  Term group
            </option>
            <option value='term_id' <?php echo ($orderby=='term_id')?'selected':''; ?>>
                  Term ID
            </option>
            <option value='id' <?php echo ($orderby=='id')?'selected':''; ?>>
                  ID
            </option>
            <option value='description' <?php echo ($orderby=='description')?'selected':''; ?>>
                  Description
            </option>
      </select>

      <br><hr>
      <!-- Order -->
      <label for="<?php echo $this->get_field_name( 'order' ); ?>"><?php _e( 'Order' ); ?></label> 
      <br>
      <select id="<?php echo $this->get_field_id('order'); ?>" name="<?php echo $this->get_field_name( 'order' ); ?>">
            <option value='ASC' <?php echo ($order=='ASC')?'selected':''; ?>>
                  Asc
            </option>
            <option value='DESC' <?php echo ($order=='DESC')?'selected':''; ?>>
                  Desc
            </option>
      </select>

      <br><hr>
      <!-- max terms count -->
      <p>
            <label for="<?php echo $this->get_field_id('maxterms'); ?>">
                  number of terms <br>
                  <input id="<?php echo $this->get_field_id('maxterms'); ?>" name="<?php echo $this->get_field_name('maxterms'); ?>" type="number" value="<?php echo esc_attr($maxterms); ?>" />
            </label>
      </p>
      <hr />

    <?php

      } // End of form 
 
    // Update function
    function update($new_instance, $old_instance){

        $instance = $old_instance;
        $instance[ 'title' ] = $new_instance['title'];
        $instance[ 'chosentax' ] = ( ! empty( $new_instance['chosentax'] ) ) ? strip_tags( $new_instance['chosentax'] ) : '';
        $instance[ 'orderby' ] = ( ! empty( $new_instance['orderby'] ) ) ? strip_tags( $new_instance['orderby'] ) : '';
        $instance[ 'order' ] = ( ! empty( $new_instance['order'] ) ) ? strip_tags( $new_instance['order'] ) : '';

        if(isset($instance['showtitle'])){
            $instance[ 'showtitle' ] = strip_tags($new_instance[ 'showtitle' ]);
        }
        else{
            $instance['showtitle'] = false;
        }

        if(isset($instance['titlepos'])){
            $instance[ 'titlepos' ] = strip_tags($new_instance[ 'titlepos' ]);
        }
        else{
            $instance['titlepos'] = false;
        }

        if(isset($instance['linked'])){
            $instance[ 'linked' ] = strip_tags($new_instance[ 'linked' ]);
        }
        else{
            $instance['linked'] = false;
        }

        if(isset($instance['showimg'])){
            $instance[ 'showimg' ] = strip_tags($new_instance[ 'showimg' ]);
        }
        else{
            $instance['showimg'] = false;
        }

        if(isset($instance['showurl'])){
            $instance[ 'showurl' ] = strip_tags($new_instance[ 'showurl' ]);
        }
        else{
            $instance['showurl'] = false;
        }

        if(isset($instance['desc'])){
            $instance[ 'desc' ] = strip_tags($new_instance[ 'desc' ]);
        }
        else{
            $instance['desc'] = false;
        }

        if(isset($instance['more'])){
            $instance[ 'more' ] = strip_tags($new_instance[ 'more' ]);
        }
        else{
            $instance['more'] = false;
        }

        $instance[ 'more_text' ] = strip_tags($new_instance['more_text']);

        $instance[ 'maxterms' ] = strip_tags($new_instance['maxterms']);

        return $instance;
    }
 
    function widget($args, $instance){

        extract($args, EXTR_SKIP);
        echo $before_widget;
        $title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);
        $chosentax = empty($instance['chosentax']) ? ' ' : apply_filters('chosentax', $instance['chosentax']);
        $orderby = empty($instance['orderby']) ? ' ' : apply_filters('orderby', $instance['orderby']);
        $order = empty($instance['order']) ? ' ' : apply_filters('order', $instance['order']);
        $linked = empty($instance['linked']) ? ' ' : apply_filters('linked', $instance['linked']);
        $showtitle = empty($instance['showtitle']) ? ' ' : apply_filters('showtitle', $instance['showtitle']);
        $titlepos = empty($instance['titlepos']) ? ' ' : apply_filters('titlepos', $instance['titlepos']);
        $showimg = empty($instance['showimg']) ? ' ' : apply_filters('showimg', $instance['showimg']);
        $showurl = empty($instance['showurl']) ? ' ' : apply_filters('showurl', $instance['showurl']);
        $desc = empty($instance['desc']) ? ' ' : apply_filters('desc', $instance['desc']);
        $more_text = empty($instance['more_text']) ? ' ' : apply_filters('more_text', $instance['more_text']);
        $maxterms = empty($instance['maxterms']) ? ' ' : apply_filters('maxterms', $instance['maxterms']);

if (!empty($title))
echo $before_title . $title . $after_title;
 
// Create terms
if ( isset( $instance['chosentax'] ) )
$terms = get_terms( $instance['chosentax'],'orderby='.$orderby.'&order='.$order.'&hide_empty=0');

if(empty($instance['maxterms']) || $instance['maxterms'] == ''){
    $instance['maxterms'] = 999;
}
$curtax = $instance['chosentax'];
$countterms = 0;

if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){
      echo '<ul id="Tax-List" class="TaxList '.$curtax.' ">';
      foreach ( $terms as $term ) {

            if ( isset( $instance['maxterms'] ) )
                  if( $countterms == $instance[ 'maxterms' ]) break;

            if ( isset( $curtax ) ) 
                  echo '<article class="' .$term->name. '" id="term-' .$term->term_id. '">';

            // Title position above image
            if ( isset( $instance['titlepos'] ) )
                  if ( $instance['titlepos'] == false){

                        // Link on
                        if ( isset( $instance['linked'] ) )
                        if( $instance[ 'linked' ] == true){

                              // Title on
                              if ( isset( $instance['showtitle'] ) )
                              if ( $instance[ 'showtitle' ] == true){

                                    // show url on
                                    if ( isset( $instance['showurl'] ) )
                                    if( $instance[ 'showurl' ] == true){

                                          echo title_custom_link_true($term);

                                    }else{

                                          echo title_link_true($term);

                                    }
                              }

                        // Link off   
                        }else{

                              // Title on
                              if ( isset( $instance['showtitle'] ) )
                              if ( $instance[ 'showtitle' ] == true){

                              echo title_true($term);

                              }
                        }
                  }

            // Image on
            if ( isset( $instance['showimg'] ) )
                  if( $instance[ 'showimg' ] == true){

                        echo image_true($term);

                  }

            // Title position under image
            if ( isset( $instance['titlepos'] ) )
                  if ( $instance[ 'titlepos' ] == true){

                        // Link on
                        if ( isset( $instance['linked'] ) )
                              if( $instance[ 'linked' ] == true){

                                    // show url on
                                    if ( isset( $instance['showurl'] ) )
                                    if( $instance[ 'showurl' ] == true){

                                    echo title_custom_link_true($term);

                                    }else{

                                    if ( isset( $instance['showtitle'] ) )
                                          if ( $instance[ 'showtitle' ] == true){

                                                echo title_link_true($term);

                                          }
                                    }

                              // Link off   
                              }else{

                                    // Title on
                                    if ( isset( $instance['showtitle'] ) )
                                    if ( $instance[ 'showtitle' ] == true){

                                    echo title_true($term);

                                    }
                              }            
                  }   

            // Description on
            if ( isset( $instance['desc'] ) )
                  if( $instance[ 'desc'] == true){

                        echo desc_true($term);

                  }

            // More on
            if ( isset( $instance['more'] ) )
                  if( $instance[ 'more' ] ){

                        $more = $more_text;

                        // show url on
                        if ( isset( $instance['showurl'] ) )
                              if( $instance[ 'showurl' ] == true){

                                    echo more_custom_true($term, $more);

                              }else{

                                    echo more_true($term,$more);
                              }
                  }

            echo '</article>';

            $countterms++;  

      }

      echo '</ul>';

} // End of terms loop 

if(!empty($output)){
    return $output;
}

echo $after_widget;
} // End of widget
}
add_action( 'widgets_init', create_function('', 'return register_widget("LoopTaxWidget");') );?>