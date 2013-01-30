<?php
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

require_once(dirname(__FILE__) . '/locallib.php');

/**
 * Kaltura video assignment grade preferences form
 *
 * @package    local
 * @subpackage kaltura
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * This function adds a link to Kaltura course reports in the navigation block tree
 *
 * @param object - navigation_node
 * @return - nothing
 */
function kaltura_extends_navigation($navigation) {

    global $COURSE;
    
    $context = get_context_instance(CONTEXT_COURSE, $COURSE->id, MUST_EXIST);
    if (!isloggedin()) {
        return '';
    }
    if(!has_capability('local/kaltura:view_report', $context)){
        return '';
    }

    //get a reference to the 'Site Pages' root nav item
    $node_home = $navigation->get('1');
    $reports_home = $node_home->find(6,  navigation_node::TYPE_UNKNOWN);

    $report_text = get_string('kaltura_course_reports', 'local_kaltura');

    if ($reports_home) {
        $node_reports = $reports_home->add($report_text, null, 70, $report_text, 'kal_reports');
    }

    $courses_node = $navigation->get('mycourses');
    
    if($courses_node){

        $course_node = $courses_node->find($COURSE->id, navigation_node::TYPE_UNKNOWN);
        $reports_node = $course_node->find(1,navigation_node::TYPE_UNKNOWN);
        $reports_node->add(
                'Kaltura Viewership', 
                new moodle_url('/local/kaltura/reports.php',array('courseid' => $COURSE->id)),
                navigation_node::NODETYPE_LEAF, 
                format_string($COURSE->shortname), 
                'kal_reports_course'
                );
    }


}

