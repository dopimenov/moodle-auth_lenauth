<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Uninstall trigger for component 'auth_lenauth'
 *
 * @link      https://docs.moodle.org/dev/Installing_and_upgrading_plugin_database_tables#uninstall.php
 * @package   auth_lenauth
 * @copyright Igor Sazonov <sovletig@gmail.com>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

function xmldb_auth_lenauth_uninstall()
{
    global $DB;
    $DB->delete_records('config_plugins', ['plugin' => 'auth_lenauth']);
    foreach (['facebook', 'google', 'yahoo', 'twitter', 'vk', 'yandex', 'mailru'] as $social) {
        $infoField = $DB->get_record('user_info_field', ['shortname' => 'auth_lenauth_' . $social . '_social_id']);
        if (!empty($infoField) && !empty($infoField->id)) {
            $DB->delete_records('user_info_data', ['fieldid' => $infoField->id]);
        }
        $DB->delete_records('user_info_field', ['shortname' => 'auth_lenauth_' . $social . '_social_id']);
    }
}
