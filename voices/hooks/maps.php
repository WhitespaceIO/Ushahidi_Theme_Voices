<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Maps Helper
 *
 * PHP version 5
 * LICENSE: This source file is subject to LGPL license
 * that is available through the world-wide-web at the following URI:
 * http://www.gnu.org/copyleft/lesser.html
 * @author	   Ushahidi Team <team@ushahidi.com>
 * @package	   Ushahidi - http://source.ushahididev.com
 * @copyright  Ushahidi - http://www.ushahidi.com
 * @license	   http://www.gnu.org/copyleft/lesser.html GNU Lesser General Public License (LGPL)
 */

class maps {

    public function __construct() {
        Event::add('system.pre_controller', array($this, 'add'));
    }

    public function add() {

    }

}
new maps;


