<?php

use HNova\Rest\res;
use HNova\Rest\router;

router::get('/:dateStart/:dateEnd', function(){


    return res::file(__DIR__.'/test.xlsx');

});