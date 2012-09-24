<?php
/**
 * Reports listing js file.
 *
 * Handles javascript stuff related to reports list function.
 *
 * PHP version 5
 * LICENSE: This source file is subject to LGPL license
 * that is available through the world-wide-web at the following URI:
 * http://www.gnu.org/copyleft/lesser.html
 * @author     Ushahidi Team <team@ushahidi.com>
 * @package    Ushahidi - http://source.ushahididev.com
 * @module     Reports Controller
 * @copyright  Ushahidi - http://www.ushahidi.com
 * @license    http://www.gnu.org/copyleft/lesser.html GNU Lesser General Public License (LGPL)
 */
?>
<?php @require_once(APPPATH.'views/map_common_js.php'); ?>

// Tracks the current URL parameters
var urlParameters = <?php echo $url_params; ?>;

// Lat/lon and zoom for the map
var latitude = <?php echo $latitude; ?>;
var longitude = <?php echo $longitude; ?>;
var defaultZoom = <?php echo $default_zoom; ?>;

// Track the current latitude and longitude on the alert radius map
var currLat, currLon;

// Map object
var map = null;
var popup = null;
var radiusMap = null;

if (urlParameters.length == 0) {
urlParameters = {};
}