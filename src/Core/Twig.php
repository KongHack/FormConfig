<?php
namespace GCWorld\FormConfig\Core;

use GCWorld\FormConfig\Forms\FormConfigFormElement;

/**
 * Class Twig
 */
class Twig
{
    const TWIG_NAMESPACE_REPLACE     = 'form_config_REPLACE';
    const TWIG_NAMESPACES = [
        'BS3',
    ];

    protected static $twig   = null;
    protected static $loader = null;

    /**
     * @param \Twig_Loader_Filesystem $filesystem
     *
     * @return void
     */
    public static function attachPath(\Twig_Loader_Filesystem $filesystem)
    {
        $dir = rtrim(__DIR__, DIRECTORY_SEPARATOR).DIRECTORY_SEPARATOR;
        $dir .= '..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'twig';
        $dir = realpath($dir);
        $dir = rtrim($dir,DIRECTORY_SEPARATOR).DIRECTORY_SEPARATOR;

        foreach(self::TWIG_NAMESPACES as $namespace) {
            $ns = str_replace('REPLACE',$namespace, self::TWIG_NAMESPACE_REPLACE);
            $filesystem->addPath($dir.$namespace.DIRECTORY_SEPARATOR, $ns);
        }
    }

    /**
     * @param \Twig_Environment $environment
     * @return void
     */
    public static function mapAll(\Twig_Environment $environment)
    {
        $loader = $environment->getLoader();
        if ($loader instanceof \Twig_Loader_Filesystem) {
            self::attachPath($loader);
        }

        $environment->addFunction(new \Twig_SimpleFunction('FC_getConfig', function(){
            $config  = Config::getInstance()->getConfig();
            unset($config['forms']);
            return $config;
        }));

        $environment->addFunction(new \Twig_SimpleFunction('FC_isFormElement',function($obj){
            return $obj instanceof FormConfigFormElement;
        }));
    }

    /**
     * @return \Twig_Environment
     */
    public static function get()
    {
        if (null == self::$twig) {
            $loader     = self::getLoader();
            $twig       = new \Twig_Environment($loader, [
                'cache'       => self::getTwigDir().DIRECTORY_SEPARATOR.'cache',
                'auto_reload' => true,
            ]);
            self::$twig = $twig;
        }

        return self::$twig;
    }

    /**
     * @return \Twig_Loader_Filesystem
     */
    public static function getLoader()
    {
        if (null == self::$loader) {
            $loader       = new \Twig_Loader_Filesystem(self::getTwigDir());
            self::$loader = $loader;
        }

        return self::$loader;
    }

    /**
     * @return string
     */
    protected static function getTwigDir()
    {
        return __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'twig';
    }
}

