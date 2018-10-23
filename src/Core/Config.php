<?php
namespace GCWorld\FormConfig\Core;

use Exception;
use Symfony\Component\Yaml\Yaml;

/**
 * Class Config
 */
class Config
{
    /**
     * @var array
     */
    protected $config = [];
    /**
     * @var null|string
     */
    protected $configPath = null;
    /**
     * @var null|Config
     */
    protected static $instance = null;

    /**
     * Config constructor.
     * @throws Exception
     */
    protected function __construct()
    {
        $file = rtrim(__DIR__, DIRECTORY_SEPARATOR).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..';
        $file .= DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.yml';
        if (!file_exists($file)) {
            throw new Exception('Config File Not Found');
        }
        $this->configPath = $file;
        $config           = Yaml::parseFile($file);
        if (isset($config['config_path'])) {
            // We need an extra ../ here due to the composer installer being 1 level up.

            $file             = __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.$config['config_path'];
            $this->configPath = $file;
            $config           = Yaml::parseFile($file);
        }

        // Get the example config, make sure we have all variables.
        $example = rtrim(dirname(__FILE__), DIRECTORY_SEPARATOR).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..';
        $example .= DIRECTORY_SEPARATOR.'config/config.example.yml';
        $exConfig = Yaml::parseFile($example);

        $reSave = false;
        foreach ($exConfig as $k => $v) {
            if (!isset($config[$k])) {
                $config[$k] = $v;
                $reSave     = true;
            } else {
                foreach ($v as $x => $y) {
                    if (!isset($config[$k][$x])) {
                        $config[$k][$x] = $y;
                        $reSave         = true;
                    }
                }
            }
        }

        if ($reSave) {
            file_put_contents($file, Yaml::dump($config,4));
        }

        foreach (array_keys($config) as $key) {
            if (strpos($key, 'example') !== false) {
                unset($config[$key]);
            }
        }

        $this->config = $config;
    }

    /**
     * @return Config|null
     * @throws Exception
     */
    public static function getInstance()
    {
        if(self::$instance == null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * @return array
     */
    public function getConfig()
    {
        return $this->config;
    }
}
