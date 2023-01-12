<?php

/**
 * config
 *
 * @package Sngine
 * @author Zamblek
 */

// ** MySQL settings ** //
/** The name of the database */
define('DB_NAME', '{db_name}');

/** MySQL database username */
define('DB_USER', '{db_user}');

/** MySQL database password */
define('DB_PASSWORD', '{db_password}');

/** MySQL hostname */
define('DB_HOST', '{db_host}');

/** MySQL port */
define('DB_PORT', '{db_port}');


// ** System URL ** //
define('SYS_URL', '{sys_url}'); // e.g (http://example.com)


// ** i18n settings ** //
define('DEFAULT_LOCALE', 'en_us');


/**
 * For developers: Sngine debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use debug
 * in their development environments.
 */
define('DEBUGGING', '{debugging}');


/**
 * For developers: log errors in error.log
 */
define('ERROR_LOGGING', '{error_logging}');

define('TEST_ENVIRONMENT', '{test_environment}');


// ** LICENCE ** //
/**
 * A unique key for your licence.
 */
define('LICENCE_KEY', '');


define("WS_ENDPOINT", '{ws_endpoint}');
define("AWS_REGION", '{aws_region}');
define("AWS_SQS_QUEUE", '{aws_sqs_queue}');
define("REDIS_HOST", '{redis_host}');
define('REDIS_HOST_REPLICA', '{redis_host_replica}');
define('REDIS_PREFIX', '{redis_prefix}');

define("shntr_TOKEN_ID", '{token_id}');