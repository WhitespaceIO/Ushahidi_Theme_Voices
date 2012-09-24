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

class ratings {

    public function __construct() {
        Event::add('system.pre_controller', array($this, 'add'));
    }

    public function add() {
        if (Router::$controller == 'main' or Router::$controller == 'reports') {
            $ratings = ORM::factory('rating')
                ->select("rating.id," .
                         "rating.incident_id,".
                         "rating.user_id,".
                         "rating.rating,".
                         "rating.rating_date,".
                         "incident_category.category_id")
                ->join("incident_category","rating.incident_id","incident_category.incident_id")
                ->find_all();
            Kohana::config_set('settings.ratings', $ratings);
        }
    }
}
new ratings;


