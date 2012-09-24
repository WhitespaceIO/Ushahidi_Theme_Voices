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

class comments {

    public function __construct() {
        Event::add('system.pre_controller', array($this, 'add'));
    }

    public function add() {
        if (Router::$controller == 'main' or Router::$controller == 'reports') {
                $comments = ORM::factory('comment')
                ->select("comment.id," .
                         "comment.incident_id,".
                         "comment.user_id,".
                         "comment.comment_author,".
                         "comment.comment_email,".
                         "comment.comment_description,".
                         "comment.comment_date,".
                         "incident_category.category_id")
                ->join("incident_category","comment.incident_id","incident_category.incident_id")
                ->find_all();
            Kohana::config_set('settings.comments', $comments);
        }
    }
}
new comments;


