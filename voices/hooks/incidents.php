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

class incidents {

    public function __construct() {
        Event::add('system.pre_controller', array($this, 'add'));
    }

    public function add() {
        if (Router::$controller == 'main') {
            $incidents = ORM::factory('incident')->where('incident_active', '1')
                ->select("incident.id," .
                "incident.incident_title,".
                "incident.incident_description,".
                "incident.incident_date,".
                "incident.user_id,".
                "location.location_name,".
                "location.latitude,".
                "location.longitude,".
                //"(SELECT category_title FROM category WHERE category.id = incident_category.category_id LIMIT 1) AS category,".
                "(SELECT sum(rating) FROM rating WHERE rating.incident_id = incident.id) AS rating,".
                "(SELECT count(*) FROM comment WHERE comment.incident_id = incident.id) AS comments,".
                "incident_category.category_id")
                ->join("incident_category","incident.id","incident_category.incident_id")
                ->join("location","incident.location_id","location.id", "LEFT")
                ->orderBy("rating", "desc")
                ->find_all();
            Kohana::config_set('settings.incidents', $incidents);
        }
    }

}
new incidents;


