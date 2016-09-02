<?php
/*
Plugin Name: Custom Taxonomy Loop
Plugin URI: www.buro210.nl
Description: Loops a chosen Custom Taxonomy with link, image, description and read more in a Widget. 
Author: Wilco
Version: 1.0
Author URI: www.buro210.nl
*/

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

// Create Error if Files are missing
function FileExistsError(){ ?>
    <div class="error">
        <p>
            Sorry, but Custom Taxonomy Loop Plugin is not correctly installed
        </p>
    </div>
<?php }

// Define path
define('TAX_PATH', dirname(__FILE__) . "/");

// Check if file for functions exist
$checkfunctions = TAX_PATH . '/incl/TaxFunctions.php';
if (file_exists($checkfunctions)) {
    require(TAX_PATH . 'incl/TaxFunctions.php');
} else {
    add_action( 'admin_notices', 'FileExistsError' );
}

// Check if file for widget exist
$checkwidget = TAX_PATH . '/incl/TaxWidget.php';
if (file_exists($checkwidget)) {
	require(TAX_PATH . 'incl/TaxWidget.php');
} else {
	add_action( 'admin_notices', 'FileExistsError' );
}

?>