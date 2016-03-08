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
 * Block instance settings
 *
 * @package    block_tour_guide
 * @copyright  2014 Thomas Threadgold - LearningWorks Ltd
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class block_tour_guide_edit_form extends block_edit_form {
 
    protected function specific_definition($mform) {
        global $DB, $COURSE;

        $coursecontext = context_course::instance($COURSE->id);
        $blockrecord = $DB->get_record('block_instances', array('blockname' => 'tour_guide',
            'parentcontextid' => $coursecontext->id), '*', MUST_EXIST);
        $blockinstance = block_instance('tour_guide', $blockrecord);

        //$PAGE->requires->yui_module('moodle-core-formautosubmit', 'M.core.init_formautosubmit');
 
        // Section header title according to language file.
        $mform->addElement(
            'header',
            'configheader',
            get_string(
                'blocksettings',
                'block'
            )
        );
 
        // A sample string variable with a default value.
        $mform->addElement(
            'text',
            'config_button',
            //'tip count: ' . $blockinstance->config->tip_count
            get_string(
                'blockbutton',
                'block_tour_guide'
            )
        );
        $mform->setDefault('config_button', get_string('blockbutton_text', 'block_tour_guide'));
        $mform->setType('config_button', PARAM_TEXT);  

        // Add selection box for number of tips.
        $mform->addElement(
            'select',
            'config_tip_count',
            get_string(
                'tip_count',
                'block_tour_guide'
            ),
            array(
                1 => '1',
                2 => '2',
                3 => '3',
                4 => '4',
                5 => '5',
                6 => '6',
                7 => '7',
                8 => '8',
                9 => '9',
                10 => '10',
                11 => '11',
                12 => '12',
                13 => '13',
                14 => '14',
                15 => '15',
                16 => '16',
                17 => '17',
                18 => '18',
                19 => '19',
                20 => '20'
            ),
            array(
                'class' => '',
            )
        );

        // Loop through tips and output settings.
        $tipcount = get_config('config_tip_count', 'block_tour_guide');

        if (isset($blockinstance->config->tip_count)) {
            $tipcount = (int) $blockinstance->config->tip_count;
        }
        else {
            $tipcount = 1;
        }

        for ($i = 1; $i <= $tipcount; $i++) {

            // Add the tip selector field.
            $mform->addElement(
                'text',
                'config_tip_' . $i . '_selector',
                get_string(
                    'tip_selector',
                    'block_tour_guide',
                    array(
                        'tip' => $i
                    )
                )
            );

            // Add the tip content field.
            $mform->addElement(
                'editor',
                'config_tip_' . $i . '_content',
                get_string(
                    'tip_content',
                    'block_tour_guide',
                    array(
                        'tip' => $i
                    )
                )
            );

            // Set the type, default, and rules for the content and selector fields.
            $mform->setType('config_tip_' . $i . '_selector', PARAM_RAW);
            $mform->setDefault('config_tip_' . $i . '_selector', get_string('tip_selector_default', 'block_tour_guide'));
            $mform->addRule('config_tip_' . $i . '_selector', get_string('error', 'block_tour_guide'), 'required');

            $mform->setType('config_tip_' . $i . '_content', PARAM_RAW);
            $mform->setDefault('config_tip_' . $i . '_content', get_string('tip_content_default', 'block_tour_guide'));
            $mform->addRule('config_tip_' . $i . '_content', get_string('error', 'block_tour_guide'), 'required');
        }
 
    }

    // function set_data($defaults) {
    //     if (!empty($this->block->config) && is_object($this->block->config)) {
    //         $text = $this->block->config->text;
    //         $draftid_editor = file_get_submitted_draft_itemid('config_text');
    //         if (empty($text)) {
    //             $currenttext = '';
    //         } else {
    //             $currenttext = $text;
    //         }
    //         $defaults->config_text['text'] = file_prepare_draft_area($draftid_editor, $this->block->context->id, 'block_html', 'content', 0, array('subdirs'=>true), $currenttext);
    //         $defaults->config_text['itemid'] = $draftid_editor;
    //         $defaults->config_text['format'] = $this->block->config->format;
    //     } else {
    //         $text = get_string('tip_content_default', 'block_tour_guide');
    //     }

    //     // have to delete text here, otherwise parent::set_data will empty content
    //     // of editor
    //     unset($this->block->config->text);
    //     parent::set_data($defaults);
    //     // restore $text
    //     if (!isset($this->block->config)) {
    //         $this->block->config = new stdClass();
    //     }
    //     $this->block->config->text = $text;
    //     if (isset($title)) {
    //         // Reset the preserved title
    //         $this->block->config->title = $title;
    //     }
    // }
}