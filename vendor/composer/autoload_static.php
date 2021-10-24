<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit2e1645fe09896ce4ca426f50d8a9813e
{
    public static $files = array (
        'da253f61703e9c22a5a34f228526f05a' => __DIR__ . '/..' . '/wixel/gump/gump.class.php',
    );

    public static $prefixLengthsPsr4 = array (
        'G' => 
        array (
            'GUMP\\' => 5,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'GUMP\\' => 
        array (
            0 => __DIR__ . '/..' . '/wixel/gump/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit2e1645fe09896ce4ca426f50d8a9813e::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit2e1645fe09896ce4ca426f50d8a9813e::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit2e1645fe09896ce4ca426f50d8a9813e::$classMap;

        }, null, ClassLoader::class);
    }
}