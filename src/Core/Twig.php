<?php
namespace GCWorld\FormConfig\Core;

/**
 * Class Twig
 */
class Twig
{
    const TWIG_NAMESPACE = 'form_config';

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

        $filesystem->addPath($dir, self::TWIG_NAMESPACE);
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

    }
}
