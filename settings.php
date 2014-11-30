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
 * Moodle Plugin
 *
 * Settings
 *
 * @package    block
 * @subpackage tour_guide
 * @copyright  2014 Thomas Threadgold, LearningWorks Ltd
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;

if ($hassiteconfig) {
    global $CFG, $USER, $DB;

    $settings = new admin_settingpage('block_tour_guide', get_string('pluginname', 'block_tour_guide'));
    $ADMIN->add('localplugins', $settings);

    // ADD ENABLE CHECKBOX.
    $settings->add(
        new admin_setting_configcolourpicker(
            'block_tour_guide/highlight_colour',
            get_string('highlight_colour', 'block_tour_guide'),
            get_string('highlight_colour_desc', 'block_tour_guide'),
            '#FE6565',
            array(
                'selector'=>'html',
                'style'=>'backgroundColor'
            )
        )
    );

}