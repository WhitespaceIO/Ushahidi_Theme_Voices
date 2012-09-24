<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Logged In User
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

class user {

    public function __construct() {
        Event::add('system.pre_controller', array($this, 'add'));
    }

    public function add() {
        if (isset(Auth::instance()->get_user()->id) ) {
            $user = User_Model::get_user_by_id(Auth::instance()->get_user()->id);
            Kohana::config_set('settings.user_id', $user->id);
            Kohana::config_set('settings.user_name', $user->name);
            Kohana::config_set('settings.user_name', $user->email);
            Kohana::config_set('settings.user_username', $user->username);
        }
        else {
            Kohana::config_set('settings.user_id', NULL);
            Kohana::config_set('settings.user_name', NULL);
            Kohana::config_set('settings.user_email', NULL);
            Kohana::config_set('settings.user_username', NULL);
        }
    }

}
new user;