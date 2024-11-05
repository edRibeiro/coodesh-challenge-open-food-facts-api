<?php

use Illuminate\Support\Facades\Schedule;

Schedule::command('import:products')->dailyAt(env('IMPORT_TIME', '00:30'));
