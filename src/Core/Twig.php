<?php
namespace GCWorld\FormConfig\Core;

use GCWorld\FormConfig\FormControlElements\FormConfigComplexElement;
use GCWorld\FormConfig\FormControlElements\FormConfigFormElement;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use Twig\Loader\FilesystemLoader;
use Twig\Loader\LoaderInterface;
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

    protected static ?Environment     $twig      = null;
    protected static ?LoaderInterface $loader    = null;
    protected static ?string $FCVersion          = null;

    /**
     * @return string
     */
    public static function getFCVersion(): string
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
    public static function attachPath(FilesystemLoader $filesystem): void
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
    public static function mapAll(Environment $environment): void
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

        $environment->addFunction(new TwigFunction('FC_Enum', function (string $fullClassName): object {
            $parts     = \explode('::', $fullClassName);
            $className = $parts[0];
            $constant  = $parts[1] ?? null;

            if (!\enum_exists($className)) {
                throw new \Exception(\sprintf('"%s" is not an enum.', $className));
            }

            if ($constant) {
                return \constant($fullClassName);
            }

            return new class($fullClassName) {
                /**
                 * @param string $fullClassName
                 */
                public function __construct(private string $fullClassName)
                {
                }

                /**
                 * @param string $caseName
                 * @param array  $arguments
                 *
                 * @return mixed
                 */
                public function __call(string $caseName, array $arguments): mixed
                {
                    return \call_user_func_array([$this->fullClassName, $caseName], $arguments);
                }
            };
        }));

    }

    /**
     * @return Environment
     */
    public static function get(): Environment
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
    public static function getLoader(): FilesystemLoader
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
    protected static function getTwigDir(): string
    {
        return __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'twig';
    }

    /**
     * @param string     $name
     * @param array|null $context
     *
     * @throws SyntaxError
     * @throws LoaderError
     * @throws RuntimeError|\Throwable
     *
     * @return string
     */
    public static function render(string $name, array $context = null): string
    {
        try {
            if (null == $context) {
                return self::get()->render($name);
            }

            return self::get()->render($name, $context);
        } catch (SyntaxError|LoaderError $e) {
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
