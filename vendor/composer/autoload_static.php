<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit2eed4c4a97c8ebaa9ad71f3b8be56411
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'PHPMailer\\PHPMailer\\' => 20,
        ),
        'I' => 
        array (
            'Ifsnop\\' => 7,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'PHPMailer\\PHPMailer\\' => 
        array (
            0 => __DIR__ . '/..' . '/phpmailer/phpmailer/src',
        ),
        'Ifsnop\\' => 
        array (
            0 => __DIR__ . '/..' . '/ifsnop/mysqldump-php/src/Ifsnop',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit2eed4c4a97c8ebaa9ad71f3b8be56411::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit2eed4c4a97c8ebaa9ad71f3b8be56411::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
