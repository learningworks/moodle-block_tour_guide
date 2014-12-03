/*
 * Moodle Plugin
 *
 * scripts.js
 *
 * @package    block
 * @subpackage tour_guide
 * @copyright  2014 Thomas Threadgold, LearningWorks Ltd
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


/*
*	Initialise on load
*/
jQuery(document).ready(function($) {
	var tip_index = 0;
	var prev_index = false;

	$('.block_tour_guide .tour_guide_trigger').on('click', function(event) {
		// ENSURE INDEX IS SET TO 0.
		tip_index = 0;

		// SHOW FIRST TOUR BOX.
		displayTourBox(tip_index);
	});

	function showNextTourBox() {
		// INCREASE INDEX.
		tip_index++;
		displayTourBox(tip_index);
	}

	function showPrevTourBox() {
		// DECREASE INDEX.
		tip_index--;
		displayTourBox(tip_index);
	}

	function endTour() {
		// REMOVE LAST TOUR BOX.
		$(tour_guide_content[tip_index].selector).removeClass('tour_highlight');
		$('#tour_box_' + tip_index).remove();

		// RESET INDEX TO 0.
		tip_index = 0;		
	}

	function displayTourBox(index) {
		var html = '';

		// IF PREV INDEX HAS BEEN SET, THEN REMOVE OLD TOUR BOX.
		if(prev_index !== false) {
			$(tour_guide_content[prev_index].selector).removeClass('tour_highlight');
			$('#tour_box_' + prev_index).remove();
		}

		// SET UP HTML BASED ON INDEX POSITION.
		if( tip_index === 0 ) {
			if( tour_guide_content.length !== 1 ) {
				html = '<div id="tour_box_' + tip_index + '" class="tour_box_popup">' + tour_guide_content[tip_index].content + '<div class="tour_guide_navigation"><input type="button" class="tour_guide_next_button" value="Next"></div></div>';
			} else {
				html = '<div id="tour_box_' + tip_index + '" class="tour_box_popup">' + tour_guide_content[tip_index].content + '<div class="tour_guide_navigation"><input type="button" class="tour_guide_finish_button" value="Finish"></div></div>';
			}
		} else if(tip_index === tour_guide_content.length - 1) {
			html = '<div id="tour_box_' + tip_index + '" class="tour_box_popup">' + tour_guide_content[tip_index].content + '<div class="tour_guide_navigation"><input type="button" class="tour_guide_prev_button" value="Previous"><input type="button" class="tour_guide_finish_button" value="Finish"></div></div>';
		} else {
			html = '<div id="tour_box_' + tip_index + '" class="tour_box_popup">' + tour_guide_content[tip_index].content + '<div class="tour_guide_navigation"><input type="button" class="tour_guide_prev_button" value="Previous"><input type="button" class="tour_guide_next_button" value="Next"></div></div>';
		}

		// HIGHLIGHT THE TARGET AND SHOW TOUR BOX.
		$(tour_guide_content[tip_index].selector).addClass('tour_highlight');
		$('body').append(html);

		// SMOOTH SCROLL TO THE TARGET.
	 	$('html,body').animate({
		    scrollTop: $(tour_guide_content[tip_index].selector).offset().top
		}, 300);

	 	// SET PREVIOUS INDEX TO THE ONE JUST USED.
		prev_index = tip_index;

		// ATTACH EVENT HANDLERS TO NEW DOM ELEMENTS.
	 	$('.tour_guide_prev_button').on('click', showPrevTourBox);
	 	$('.tour_guide_next_button').on('click', showNextTourBox);
	 	$('.tour_guide_finish_button').on('click', endTour);
	}

});