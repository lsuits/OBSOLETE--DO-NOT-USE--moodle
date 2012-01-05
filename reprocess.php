<?php

# Call http://host/reprocess.php?id=COURSEID

require_once 'config.php';
require_once $CFG->dirroot . '/enrol/ues/publiclib.php';

ues::require_daos();

if (!is_siteadmin($USER->id)) {
    echo "You don'y exist. Go away.";
    exit;
}

$courseid = required_param('id', PARAM_INT);
$course = $DB->get_record('course', array('id' => $courseid), '*', MUST_EXIST);

header("Content-Type: text/plain");

$sections = ues_section::from_course($course);

ues::enroll_users($sections, false);

echo "Done";
