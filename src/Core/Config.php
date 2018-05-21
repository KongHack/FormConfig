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

    protected $configPath = null;

    /**
     * Config constructor.
     * @throws Exception
     */
    public function __construct()
    {
        $file = rtrim(__DIR__, DIRECTORY_SEPARATOR).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..';
        $file .= DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.yml';
        if (!file_exists($file)) {
            throw new Exception('Config File Not Found');
        }
        $this->configPath = $file;
        $config           = Yaml::parse(file_get_contents($file));
        if (isset($config['config_path'])) {
            $file             = $config['config_path'];
            $this->configPath = $file;
            $config           = Yaml::parse(file_get_contents($file));
        }

        // Get the example config, make sure we have all variables.
        $example = rtrim(dirname(__FILE__), DIRECTORY_SEPARATOR).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..';
        $example .= DIRECTORY_SEPARATOR.'config/config.example.yml';
        $exConfig = Yaml::parse(file_get_contents($example));

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
     * @return array
     */
    public function getConfig()
    {
        return $this->config;
    }
}
