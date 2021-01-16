<?php 

    $BS_SETTINGS_INTERNAL = array(
        "GENERAL" => array(
            "DEBUG_MODE_PHP" => true, // show all php errors
            "DEBUG_MODE" => true, // if enabled on error/warnig create a log file
            "DEBUG" => true, // If true all actions are save in var: $DEBUG

            "PRE_DECLARED_CLASSES" => true,
            "PRE_DECLARED_CLASSES_NAMES" => array("tools"   => "class_tools",
                                                  "captcha" => "class_captcha",
                                                  "agent"   => "class_agent",
                                                  "sql"     => "class_sql",
                                                  "html"    => "class_html"
                                                )
        ),
        "PLUGINS" => array(
            "IS_ENABLED" => true,
            "FOLDER_NAME" => "plugins",
            "FILE-INCLUDED_FROM_BASECODE" => "index.php",
            "FILE-GUI_PLUGIN_MANAGER" => "config.php",
        ),
        "DB" => array(
            "IS_ENABLED" => false, // enable or disabled db
            "HOST" => array("localhost"), // for multiple dbs use (example): array("localhost-db1","localhost-db2","localhost-db3"),
            "NAME" => array("basecodeDB_test"), // for multiple dbs use (example): array("dbname-db1","dbname-db2","dbname-db3"),
            "USER" => array("basecodeDB_UserTest"), // for multiple dbs use (example): array("dbuser-db1","dbuser-db2","dbuser-db3"),
            "PASS" => array("basecodeDB_PasswordTest"), // for multiple dbs use (example): array("dbuserpass-db1","dbuserpass-db2","dbuserpass-db3"),
        ),
        "CAPTCHA" => array(
            "GOOGLE_CAPTCHA_PUBLIC-KEY" => "key_value",
            "GOOGLE_CAPTCHA_PRIVATE-KEY" => "key_value",
            "HCAPTCHA_PUBLIC-KEY" => "key_value",
            "HCAPTCHA_PRIVATE-KEY" => "key_value",
        ),
        // Errors
        "ERRORS" => array(
            "NEVER_DIE_PAGE" => true, // false
            "SHOW_HTML_ERROR_MESSAGE" => true,

            "DEFAULT_PUBLIC_ERROR" => "Action not allowed!",
            "DEFAULT_ERROR" => "Unable to complete this operation, check the logs for more details",
            "DEFAULT_DIE_ERROR" => "Critical Error Detected, please check the log file",
        ),
    );
