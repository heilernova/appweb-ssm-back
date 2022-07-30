<?php

use App\appfiles;
use HNova\Rest\req;

$case_id = req::params()->caseId;
$name_file = req::params()->name;

return appfiles::deleteFileCase($case_id, $name_file);