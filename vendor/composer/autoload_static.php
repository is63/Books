<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit64d5dd59d7eeae8e4b0cbae7e15e516d
{
    public static $files = array (
        '9e4824c5afbdc1482b6025ce3d4dfde8' => __DIR__ . '/..' . '/league/csv/src/functions_include.php',
    );

    public static $prefixLengthsPsr4 = array (
        'L' => 
        array (
            'League\\Csv\\' => 11,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'League\\Csv\\' => 
        array (
            0 => __DIR__ . '/..' . '/league/csv/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
        'FPDF' => __DIR__ . '/..' . '/setasign/fpdf/fpdf.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit64d5dd59d7eeae8e4b0cbae7e15e516d::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit64d5dd59d7eeae8e4b0cbae7e15e516d::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit64d5dd59d7eeae8e4b0cbae7e15e516d::$classMap;

        }, null, ClassLoader::class);
    }
}
