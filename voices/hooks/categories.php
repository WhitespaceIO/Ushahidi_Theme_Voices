<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Category List
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

class categories {

    public function __construct() {
        Event::add('system.pre_controller', array($this, 'add'));
    }

    public function add() {
        if (Router::$controller == 'main' or Router::$controller == 'reports') {
            $categories = ORM::factory('category')->where('category_visible', '1')
                ->where('parent_id', '0')
                ->where('category_trusted != 1')
                ->orderby('category_position', 'ASC')
                ->orderby('category_title', 'ASC')
                ->find_all();
            Kohana::config_set('settings.categories', $categories);
        }
    }

}
new categories;


