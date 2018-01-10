<?php
namespace GCWorld\FormConfig;

use GCWorld\FormConfig\Core\Compiler;
use Composer\Script\Event;

/**
 * Used for a post autoload dump script in composer.
 *
 * Class ComposerInstaller
 */
class ComposerInstaller
{
    /**
     * Runs post-dump after composer finishes executing.
     *
     * @return bool
     */
    public static function setupConfig(Event $event = null)
    {
        register_shutdown_function(['\\GCWorld\\FormConfig\\ComposerInstaller', 'trace']);

        $ds    = DIRECTORY_SEPARATOR;
        $myDir = __DIR__;

        if($event !== null) {
            $vendorDir = $event->getComposer()->getConfig()->get('vendor-dir');
        } else {
            $vendorDir = rtrim(__DIR__,DIRECTORY_SEPARATOR).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'vendor';
        }

        // Determine if FormConfig ini already exists.
        $iniPath = realpath($vendorDir.$ds.'..'.$ds.'config').$ds;

        if (!is_dir($iniPath)) {
            @mkdir($iniPath);
            if (!is_dir($iniPath)) {
                echo 'WARNING:: Cannot create config folder in application root:: '.$iniPath;
                return false;   // Silently Fail.
            }
        }
        if (!file_exists($iniPath.'GCWorld_FormConfig.ini')) {
            $example = file_get_contents($myDir.$ds.'..'.$ds.'config'.$ds.'config.example.ini');
            file_put_contents($iniPath.'GCWorld_FormConfig.ini', $example);
        }
        file_put_contents($myDir.$ds.'..'.$ds.'config'.$ds.'config.ini', 'config_path='.$iniPath.'GCWorld_FormConfig.ini');

        self::generateCode();

        return true;
    }

    /**
     * @return void
     */
    public static function generateCode()
    {
        $cCompiler = new Compiler();
        $cCompiler->run();
    }

    /**
     * @return void
     */
    public static function trace()
    {
        debug_print_backtrace();
    }
}
