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
 * Block Class
 *
 * @package    block_tour_guide
 * @copyright  2014 Thomas Threadgold - LearningWorks Ltd
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class block_tour_guide extends block_base {

    // Initialises the block.
    public function init() {
        global $PAGE, $CFG;

        $PAGE->requires->jquery();
        $PAGE->requires->js( new moodle_url($CFG->wwwroot . '/blocks/tour_guide/js/scripts.js') );

        $this->title = get_string('block_title', 'block_tour_guide');
    }

    // Outputs the block content.
    public function get_content() {
        if ($this->content !== null) {
          return $this->content;
        }
     
        // Output the content of the block.
        $this->content = new stdClass;

        // Get the text for the tour guide button.
        if (isset($this->config->button)) {
            $this->content->text = '<input type="button" class="tour_guide_trigger" value=' . json_encode($this->config->button) . '>';
        } else {      
            $this->content->text = '<input type="button" class="tour_guide_trigger" value=' . json_encode(get_string('blockbutton_text', 'block_tour_guide')) . '>';
        }

        // Output a JS Array with the block instance settings.
        $this->content->footer = '<script type="text/javascript">var tour_guide_content = [';

        // Set tipcount to zero if it is not defined. There are no tips.
        if (isset($this->config->tip_count)) {

            // Loop through all the object settings.
            for ($i = 1; $i <= (int) $this->config->tip_count; $i++) {

                $selector = 'tip_' . $i . '_selector';

                // Check that the selector has been set.
                if (!isset($this->config->$selector)) {
                    break;
                }

                if(strlen($this->config->$selector) > 0) {
                    $theSelector = $this->config->$selector;
                } else {
                    $theSelector = 'html';
                }

                // Add the content.
                $content = 'tip_' . $i . '_content';
                $the_content = $this->config->$content;

                // Output the settings as a JS Object.
                $this->content->footer .= '
                {
                    "selector" : ' . json_encode($theSelector) . ',
                    "content" : ' . json_encode($the_content['text']);

                if( $i !== (int) $this->config->tip_count) {
                    $this->content->footer .= '
                },';
                } else {
                    $this->content->footer .= '
                }';
                }
            }


        }
        
        $this->content->footer .= "];";

        $highlight_colour = get_config('block_tour_guide', 'highlight_colour');

        if (empty($highlight_colour)) {
            $this->content->footer .= "var tour_guide_highlight_color = false;";
        }
        else {
            $this->content->footer .= "var tour_guide_highlight_color = " . json_encode($highlight_colour) . ";";
        }
        
        $this->content->footer .= "</script>";
     
        return $this->content;
    }

    //Enable global block settings.
    function has_config() {
        return true;
    }

    // Hide the block header.
    public function hide_header() {
      return true;
    }

    // Define which page formats the block can be used.
    public function applicable_formats() {
      return array('all' => true);
    }
}