<?php
namespace GCWorld\FormConfig\Core;

use GCWorld\FormConfig\FormControlElements\FormConfigComplexElement;
use GCWorld\FormConfig\FormControlElements\FormConfigFormElement;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use Twig\Loader\FilesystemLoader;
use Twig\TwigFunction;
use Twig\TwigTest;

/**
 * Class Twig
 */
class Twig
{
    const TWIG_NAMESPACE_REPLACE = 'form_config_REPLACE';
    const TWIG_NAMESPACES        = [
        'BS3',
    ];

    protected static $twig      = null;
    protected static $loader    = null;
    protected static $FCVersion = null;

    /**
     * @return string
     */
    public static function getFCVersion()
    {
        if(static::$FCVersion === null) {
            $file  = rtrim(__DIR__, DIRECTORY_SEPARATOR).DIRECTORY_SEPARATOR;
            $file .= '..'.DIRECTORY_SEPARATOR;
            $file .= '..'.DIRECTORY_SEPARATOR;
            $file .= 'VERSION';

            static::$FCVersion = trim(file_get_contents($file));
        }

        return static::$FCVersion;
    }

    /**
     * @param FilesystemLoader $filesystem
     *
     * @return void
     */
    public static function attachPath(FilesystemLoader $filesystem)
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
     * @param Environment $environment
     * @return void
     */
    public static function mapAll(Environment $environment)
    {
        $loader = $environment->getLoader();
        if ($loader instanceof FilesystemLoader) {
            self::attachPath($loader);
        }

        $environment->addFunction(new TwigFunction('FC_getConfig', function(){
            $config  = Config::getInstance()->getConfig();
            unset($config['forms']);
            return $config;
        }));

        $environment->addTest(new TwigTest('FC_isFormElement',function($obj){
            return $obj instanceof FormConfigFormElement;
        }));
        $environment->addTest(new TwigTest('FC_isComplexElement',function($obj){
            return $obj instanceof FormConfigComplexElement;
        }));
    }

    /**
     * @return Environment
     */
    public static function get()
    {
        if (null == self::$twig) {
            $loader     = self::getLoader();
            $twig       = new Environment($loader, [
                'cache'       => self::getTwigDir().DIRECTORY_SEPARATOR.'cache',
                'auto_reload' => true,
            ]);
            self::mapAll($twig);
            self::$twig = $twig;
        }

        return self::$twig;
    }

    /**
     * @return FilesystemLoader
     */
    public static function getLoader()
    {
        if (null == self::$loader) {
            $loader       = new FilesystemLoader(self::getTwigDir());
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

    /**
     * @param string     $name
     * @param array|null $context
     *
     * @throws SyntaxError
     * @throws LoaderError
     * @throws RuntimeError
     *
     * @return string
     */
    public static function render(string $name, array $context = null)
    {
        try {
            if (null == $context) {
                return self::get()->render($name);
            }

            return self::get()->render($name, $context);
        } catch (SyntaxError $e) {
            d($e);

            throw $e;
        } catch (LoaderError $e) {
            d($e);

            throw $e;
        } catch (RuntimeError $e) {
            $previous = $e->getPrevious();
            if (\is_object($previous)) {
                throw $previous;
            }

            throw $e;
        }
    }
}
