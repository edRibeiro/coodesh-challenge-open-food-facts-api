<?php

use Illuminate\Support\Facades\Schedule;

Schedule::command('import:products')->dailyAt('00:30');
