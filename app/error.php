<?php

exec('tail error.log -n 100', $error_logs);

foreach($error_logs as $error_log) {

    echo '<br />' . $error_log;
}