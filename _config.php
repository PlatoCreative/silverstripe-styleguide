<?php

/**
 * Fetches the name of the current module folder name.
 *
 * @return string
**/
define('STYLEGUIDE_DIR', ltrim(Director::makeRelative(realpath(__DIR__)), DIRECTORY_SEPARATOR));
