<?php

//TaxFunctions.php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

// Function to call the other functions
add_action('admin_init', 'tax_init');
function tax_init() {
    $taxonomies = get_taxonomies(); 
    foreach ( $taxonomies as $taxonomy ) {
     
      // Image
      add_action( $taxonomy. '_add_form_fields', 'add_image_field', 10, 2 );
      add_action( 'created_' .$taxonomy, 'save_image_meta', 10, 2 );
      add_action( $taxonomy. '_edit_form_fields', 'edit_image_field', 10, 2 );
      add_action( 'edited_' .$taxonomy, 'update_image_meta', 10, 2 );
      add_filter('manage_edit-' .$taxonomy. '_columns', 'add_image_field_column' );
      add_filter('manage_' .$taxonomy. '_custom_column', 'add_image_field_column_content', 10, 3 );

      // URL
      add_action( $taxonomy. '_add_form_fields', 'add_url_field', 10,4);
      add_action( 'created_' .$taxonomy, 'save_url_meta', 10, 4 );
      add_action( $taxonomy. '_edit_form_fields', 'edit_url_field', 10, 4 );
      add_action( 'edited_' .$taxonomy, 'update_url_meta', 10, 4 );
      add_filter('manage_edit-' .$taxonomy. '_columns', 'add_url_field_column' );
      add_filter('manage_' .$taxonomy. '_custom_column', 'add_url_field_column_content', 10, 4 );

    }
}

// Function to add the option to upload images
function add_image_field($taxonomy) {
    upload_image();
}

// Function to add the option to upload images
function add_url_field($taxonomy) {
    add_url();
}

// Function to add the option to upload images in edit-tags.php
function edit_image_field( $term, $taxonomy ){
    upload_image_edit();
}

// Function to add the option for custom urls in edit-tags.php
function edit_url_field( $term, $taxonomy ){

    $term_id = (int) $_REQUEST['tag_ID'];
    // Get url bound to the Taxonomy
    $url = get_term_meta( $term_id, 'tax_url', true );

     ?>
      <div>
            <tr class="form-field term-group-wrap">
            <th scope="row"><label for="tax_url">URL</label></th>
            <td>  
                  <input type="text" name="tax_url" value='<?php echo $url; ?>' id="tax_url" autocomplete="off" class="regular-text" style="width:95%; float:left;">
            </td>
      </div> 
<?php }

// Function to save the url
function save_url_meta( $term_id, $tt_id ){
    if( isset( $_POST['image_url'] ) ){

        $url_data = $_POST['tax_url'];
        add_term_meta( $term_id, 'tax_url', $url_data, true );
    }
}

// Function to update the image field
function update_url_meta( $term_id, $tt_id ){

    if( isset( $_POST['tax_url'] ) && '' !== $_POST['tax_url'] || empty($_POST['tax_url']) ){

        $url_data = $_POST['tax_url'];
        update_term_meta( $term_id, 'tax_url', $url_data);
    }
}

// Function to save the image
function save_image_meta( $term_id, $tt_id ){
    if( isset( $_POST['image_url'] ) ){

        $image_data = $_POST['image_url'];
        add_term_meta( $term_id, 'image_url', $image_data, true );
    }
}

// Function to update the image field
function update_image_meta( $term_id, $tt_id ){

    if( isset( $_POST['image_url'] ) && '' !== $_POST['image_url'] || empty($_POST['image_url']) ){

        $image_data = $_POST['image_url'];
        update_term_meta( $term_id, 'image_url', $image_data);
    }
}

// Load media library
function load_wp_media_files() {
    wp_enqueue_media();
}

// Function to add url to Taxonomy
function add_url(){

    ?>
    
    <label for="tax_url">Url</label>
    <input type="text" name="tax_url" id="tax_url" autocomplete="off" class="regular-text" style="width:95%; float:left;">
    <br>
    <br>
    <?php
}

// Function to upload images on the Taxonomy list screen.
function upload_image(){
    // UPLOAD ENGINE
    add_action( 'admin_enqueue_scripts', 'load_wp_media_files' );
    // jQuery
    wp_enqueue_script('jquery');
    // This will enqueue the Media Uploader script
    wp_enqueue_media();
    ?>
    <div>
        <label for="image_url">Image</label>
        <input type="button" name="upload-btn" id="upload-btn" class="button-secondary" value="Upload Image" style="float:left; margin-right:10px;">
        <input type="text" name="image_url" id="image_url" autocomplete="off" class="regular-text" style="width:calc(95% - 116px); float:left;">
        <div id="image-placeholder" style="width:100%; display:inline-block; margin:10px 0 0 0;">
        </div>
    </div>
    <br />
    <script type="text/javascript">
    jQuery(document).ready(function($){
        $('#upload-btn').click(function(e) {
            e.preventDefault();
            var image = wp.media({ 
                title: 'Upload Image',
                // mutiple: true if you want to upload multiple files at once
                multiple: false
            }).open()
            .on('select', function(e){
                // This will return the selected image from the Media Uploader, the result is an object
                var uploaded_image = image.state().get('selection').first();
                // We convert uploaded_image to a JSON object to make accessing it easier
                var image_url = uploaded_image.toJSON().url;
                // Let's assign the url value to the input field
                $('#image_url').val(image_url);

                if( $('#image_url_img').length ) {
                     $('#image_url_img').attr('src',image_url);
                }
                else{
                    $('#image-placeholder').append('<img id="image_url_img" style="float:left;" width=300 height=200 src="">');
                    $('#image_url_img').attr('src',image_url);
                }  
            });
        });
        $('#submit').click(function(e) {
            if( $('#image_url_img').length ) {
                $('#image_url_img').remove();
            }
        });
    });
    </script>

<?php

}

// Function to upload images on edit-tags.php
function upload_image_edit(){

    // UPLOAD ENGINE
    add_action( 'admin_enqueue_scripts', 'load_wp_media_files' );
    // jQuery
    wp_enqueue_script('jquery');
    // This will enqueue the Media Uploader script
    wp_enqueue_media();
    // Get id from current Taxonomy
    $term_id = (int) $_REQUEST['tag_ID'];
    // Get Image url bound to the Taxonomy
    $image = get_term_meta( $term_id, 'image_url', true );
?>

<tr class="form-field term-group-wrap">
    <th scope="row"><label for="image_url">Image</label></th>
    <td>  
        <input type="button" name="upload-btn" id="upload-btn" class="button-secondary" value="Upload Image">
        <input type="button" name="remove-btn" id="remove-btn" class="button-secondary" value="Remove Image">
        <input type="text" style="margin-top:10px;" name="image_url" id="image_url" autocomplete="off" class="regular-text" value='<?php echo $image; ?> '>
        <div style="float:left; margin:10px 0;" id='image-placeholder'>
            <?php if( !empty( $image ) ){ ?>
                <img id="image_url_img" style="float:left;" width=300 height=200 src='<?php echo $image; ?>'>
            <?php } ?>
        </div>
    </td>
</div>
<br />
<script type="text/javascript">
jQuery(document).ready(function($){
    $('#upload-btn').click(function(e) {
        e.preventDefault();
        var image = wp.media({ 
            title: 'Upload Image',
            multiple: false
        }).open()
        .on('select', function(e){
            // This will return the selected image from the Media Uploader, the result is an object
            var uploaded_image = image.state().get('selection').first();
            // We convert uploaded_image to a JSON object to make accessing it easier
            // Output to the console uploaded_image
            console.log(uploaded_image);
            var image_url = uploaded_image.toJSON().url;
            // assign the url value to the input field
            jQuery('#image_url').val(image_url);
            if( $('#image_url_img').length ) {
                 $('#image_url_img').attr('src',image_url);
            }
            else{
                $('#image-placeholder').append('<img id="image_url_img" style="float:left;" width=300 height=200 src="">');
                $('#image_url_img').attr('src',image_url);
            }             
        });
    });
    // Remove image on edit-tags.php
    $('#remove-btn').click(function(e) {
        $('#image_url').val('');
        $('#image_url_img').remove();
        $("input[name='image_url']").val("");
    });
});
</script>

<?php
}

// Function to add Image column to the taxonomy list
function add_image_field_column( $columns ){
    $columns['image'] = __( 'Image');
    return $columns;
}

// Function to add Image column to the taxonomy list
function add_url_field_column( $columns ){
    $columns['url'] = __( 'URL');
    return $columns;
}

// Function to fill the Image column with the images
function add_image_field_column_content( $content, $column_name, $term_id ){
    
    if( $column_name !== 'image' ){
        return $content;
    }

    $term_id = absint( $term_id );
    $image = get_term_meta( $term_id, 'image_url', true );

    if( !empty( $image ) ){
        $content .= '<img width=125px height=75px src="' .$image. '">';
    }

    return $content;
}

// Function to fill the Image column with the images
function add_url_field_column_content( $content, $column_name, $term_id ){
    
    if( $column_name !== 'url' ){
        return $content;
    }

    $term_id = absint( $term_id );
    $url = get_term_meta( $term_id, 'tax_url', true );

    if( !empty( $url ) ){
        $content .= '<p>'  .$url. '</p>';
    }

    return $content;

}

// Adds title with link
if(!function_exists('title_link_true')){

    function title_link_true($term){

        $term_link = get_term_link( $term );

        // Broken link Check. If broken continue to next term
        if ( is_wp_error( $term_link ) ) {
            continue;
        }

        $output = '<div class="tax-title">';

        $output .= '<a href="' . $term_link. '">' . $term->name . '</a>';

        $output .= '</div>';

        return $output;
    }
}

// Adds title with the custom link
if(!function_exists('title_custom_link_true')){

    function title_custom_link_true($term){

        $url = get_term_meta( $term->term_id, 'tax_url', true );

        $output = '<div class="tax-title tax-custom-link">';

        $output .= '<a href="' . $url. '">' . $term->name . '</a>';

        $output .= '</div>';

        return $output;
    }
}

// Adds title without link
if(!function_exists('title_true')){

    function title_true($term){

        $output = '<div class="tax-title">'; // TAX TITLE

        $output .= '<h2>' . $term->name . '</h2>';

        $output .= '</div>';

        return $output;
    }
}

// Adds image 
if(!function_exists('image_true')){

    function image_true($term){        

        $image = get_term_meta( $term->term_id, 'image_url', true );

        $output = "<div class='tax-thumbnail'>";

        $output .= '<img class="tax-img" src="' . $image . '" />';

        $output .= "</div>";

        return $output;
    }
}

// Adds description
if(!function_exists('desc_true')){

    function desc_true($term){
     
        if (!empty(term_description( $term->term_id) ) ){

            $output = "<div class='tax-desc'>";

            $output .= term_description(  $term->term_id, '');

            $output .= "</div>"; 

            return $output;
        }
    }
}

// Adds read more link
if(!function_exists('more_true')){

    function more_true($term,$more){

        $term_link = get_term_link( $term );

        // Broken link Check. If broken continue to next term
        if ( is_wp_error( $term_link ) ) {
            continue;
        }

        $output = "<div class='tax-more'>";

        $output .= '<a href="' . $term_link. '">';

        $output .= $more;

        $output .= '</a>';

        $output .= "</div>";

        return $output;
    }
}

// Adds more custom link
if(!function_exists('more_custom_true')){

    function more_custom_true($term,$more){

        $url = get_term_meta( $term->term_id, 'tax_url', true );

        $output = "<div class='tax-more custom-more-link'>";

        $output .= '<a href="' . $url. '">';

        $output .= $more;

        $output .= '</a>';

        $output .= "</div>";

        return $output;
    }
}


?>