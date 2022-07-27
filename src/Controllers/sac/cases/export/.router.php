<?php
use HNova\Rest\router;

router::get('/:dateStart/:dateEnd', fn() => require __DIR__ . '/export-excel-get.php');