<?php
namespace GCWorld\FormConfig;

use GCWorld\FormConfig\Core\Compiler;
use Composer\Script\Event;
use Symfony\Component\Yaml\Yaml;

/**
 * Used for a post autoload dump script in composer.
 *
 * Class ComposerInstaller
 */
class ComposerInstaller
{
    const CONFIG_FILE_NAME = 'GCWorld_FormConfig.yml';

    /**
     * @param Event|null $event
     *
     * @return bool
     */
    public static function setupConfig(Event $event = null)
    {
        $ds    = DIRECTORY_SEPARATOR;
        $myDir = __DIR__;

        if($event !== null) {
            $vendorDir = $event->getComposer()->getConfig()->get('vendor-dir');
        } else {
            $vendorDir = rtrim(__DIR__,DIRECTORY_SEPARATOR).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'vendor';
        }

        // Determine if FormConfig yml already exists.
        $ymlPath = realpath($vendorDir.$ds.'..'.$ds.'config').$ds;

        if (!is_dir($ymlPath)) {
            @mkdir($ymlPath);
            if (!is_dir($ymlPath)) {
                echo 'WARNING:: Cannot create config folder in application root:: '.$ymlPath;
                return false;   // Silently Fail.
            }
        }
        if (!file_exists($ymlPath.self::CONFIG_FILE_NAME)) {
            $example = file_get_contents($myDir.$ds.'..'.$ds.'config'.$ds.'config.example.yml');
            file_put_contents($ymlPath.self::CONFIG_FILE_NAME, $example);
        }

        $tmpYml = explode(DIRECTORY_SEPARATOR, $ymlPath);
        $tmpMy  = explode(DIRECTORY_SEPARATOR, $myDir);
        $loops  = max(count($tmpMy),count($tmpYml));

        array_pop($tmpYml); // Remove the trailing slash

        for($i=0;$i<$loops;++$i) {
            if(!isset($tmpYml[$i]) || !isset($tmpMy[$i])) {
                break;
            }
            if($tmpYml[$i] === $tmpMy[$i]) {
                unset($tmpYml[$i]);
                unset($tmpMy[$i]);
            }
        }

        $relPath = str_repeat('..'.DIRECTORY_SEPARATOR,count($tmpMy));
        $relPath .= implode(DIRECTORY_SEPARATOR, $tmpYml);
        $ymlPath = $relPath.DIRECTORY_SEPARATOR.self::CONFIG_FILE_NAME;

        $tmp = ['config_path' => $ymlPath];

        file_put_contents($myDir.$ds.'..'.$ds.'config'.$ds.'config.yml', Yaml::dump($tmp,4));

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
}
