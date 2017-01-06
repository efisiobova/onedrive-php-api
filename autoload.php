<?php

namespace Efisiobova\Onedrive;

// The Onedrive SDK autoloader.  You probably shouldn't be using this.  Instead,
// use a global autoloader, like the Composer autoloader.
//
// But if you really don't want to use a global autoloader, do this:
//
//     require_once __DIR__ . '/Onedrive/autoload.php'

/**
 * @internal
 */
function autoload($name)
{
    // If the name doesn't start with "Efisiobova\Onedrive\", then it's not one of our classes.
    if (substr_compare($name, 'Efisiobova\\Onedrive\\', 0, 18) !== 0) {
        return;
    }

    // Take the "Efisiobova\Onedrive\" prefix off.
    $stem = substr($name, 18);

    // Convert "\" and "_" to path separators.
    $pathifiedStem = str_replace(array('\\', '_'), '/', $stem);

    $path = __DIR__ . '/src/Efisiobova/Onedrive/' . $pathifiedStem . '.php';

    if (is_file($path)) {
        require_once $path;
    }
}

spl_autoload_register('Efisiobova\Onedrive\autoload');
