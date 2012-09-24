<?php
/**
 * PHP version 5
 * LICENSE: This source file is subject to LGPL license
 * that is available through the world-wide-web at the following URI:
 * http://www.gnu.org/copyleft/lesser.html
 * @author     Ushahidi Team <team@ushahidi.com>
 * @package    Ushahidi - http://source.ushahididev.com
 * @module     API Controller
 * @copyright  Ushahidi - http://www.ushahidi.com
 * @license    http://www.gnu.org/copyleft/lesser.html GNU Lesser General Public License (LGPL)
 */
?>
<?php @require_once(APPPATH.'views/map_common_js.php'); ?>
var latitude = <?php echo Kohana::config('settings.default_lat'); ?>;
var longitude = <?php echo Kohana::config('settings.default_lon'); ?>;
var defaultZoom = <?php echo Kohana::config('settings.default_zoom'); ?>;
var map = null;