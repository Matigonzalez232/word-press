<?php

// autoload_real.php @generated by Composer

class ComposerAutoloaderInitcf02631abc2cbdbf472187b4f5e8fa90
{
    private static $loader;

    public static function loadClassLoader($class)
    {
        if ('Composer\Autoload\ClassLoader' === $class) {
            require __DIR__ . '/ClassLoader.php';
        }
    }

    /**
     * @return \Composer\Autoload\ClassLoader
     */
    public static function getLoader()
    {
        if (null !== self::$loader) {
            return self::$loader;
        }

        require __DIR__ . '/platform_check.php';

        spl_autoload_register(array('ComposerAutoloaderInitcf02631abc2cbdbf472187b4f5e8fa90', 'loadClassLoader'), true, false);
        self::$loader = $loader = new \Composer\Autoload\ClassLoader(\dirname(__DIR__));
        spl_autoload_unregister(array('ComposerAutoloaderInitcf02631abc2cbdbf472187b4f5e8fa90', 'loadClassLoader'));

        require __DIR__ . '/autoload_static.php';
        call_user_func(\Composer\Autoload\ComposerStaticInitcf02631abc2cbdbf472187b4f5e8fa90::getInitializer($loader));

        if (method_exists($loader,"setClassMapAuthoritative")){
            $loader->setClassMapAuthoritative(true);
        }
        $loader->register(false);

        return $loader;
    }
}
