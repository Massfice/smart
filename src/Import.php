<?php

namespace Massfice\Smart;

class Import {
    private static function returnBlank(array $packages) : string {
        return $packages["Massfice\\Smart\\"][0]."/import/blank.php";
    }

    public static function option(string $package, string $option) : string {
        $path = dirname(dirname(__FILE__));

        $packages = require($path."/vendor/composer/autoload_psr4.php");

        if(!isset($packages[$package][0])) {
            return self::returnBlank($packages);
        } else {
            $package = $packages[$package][0];
        }

        $schema = $package."/massfice.si.json";

        if(!is_file($schema)) {
            return self::returnBlank($packages);
        }

        $json = file_get_contents($schema);

        $options = json_decode($json,true);

        if(!isset($options[$option])) {
            return self::returnBlank($packages);
        } else {
            $file_path = $package."/".$options[$option];
        }

        if(!is_file($file_path)) {
            return self::returnBlank($packages);
        }

        return $file_path;
    }
}

?>