<?php

use App\appfiles;
use HNova\Rest\req;


return appfiles::renameFileCase(req::params()->caseId, str_replace('%20', ' ', req::params()->name), req::body());