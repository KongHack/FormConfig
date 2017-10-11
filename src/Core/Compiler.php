<?php
namespace GCWorld\FormConfig\Core;

use GCWorld\FormConfig\FieldInterface;
use Riimu\Kit\PHPEncoder\PHPEncoder;

/**
 * Class Compiler
 * @package GCWorld\FormConfig\Core
 */
class Compiler
{
    protected $groups = [];

    /**
     * Compiler constructor.
     */
    public function __construct()
    {
        $base = rtrim(__DIR__, DIRECTORY_SEPARATOR).DIRECTORY_SEPARATOR;
        $dir  = $base . '..'.DIRECTORY_SEPARATOR.'Fields';
        $this->groups['\\GCWorld\\FormConfig\\Fields'] = $dir;

        $cConfig = new Config();
        $config = $cConfig->getConfig();

        foreach($config as $group => $item) {
            $namespace = $item['namespace'];
            $directory = $item['directory'];
            // Core / Source / Vendors
            $found = false;
            for($i=3;$i<10;++$i) {
                $up = str_repeat('..'.DIRECTORY_SEPARATOR,$i);
                if(is_dir($base.$up.$directory)) {
                    $this->addFieldGroup($namespace,realpath($base.$up.$directory));
                    $found = true;
                    break;
                }
            }
            if(!$found) {
                throw new \Exception('Did not find the things in group: '.$group);
            }
        }
    }

    /**
     * @param string $namespace
     * @param string $directory
     *
     * @return $this
     */
    public function addFieldGroup(string $namespace, string $directory)
    {
        $this->groups[rtrim($namespace, '\\')] = rtrim($directory, DIRECTORY_SEPARATOR);

        return $this;
    }

    /**
     * @param bool $debug
     * @return void
     */
    public function run($debug = false)
    {
        $objects = [];
        foreach ($this->groups as $ns => $dir) {
            $files = glob($dir.DIRECTORY_SEPARATOR.'*.php');
            if($debug) {
                d($dir);
                d($files);
            }
            foreach ($files as $file) {
                $tmp       = explode(DIRECTORY_SEPARATOR, $file);
                $fileName  = array_pop($tmp);
                $tmp       = explode('.', $fileName);
                $className = array_shift($tmp);
                $fullName  = $ns.'\\'.$className;
                $cObject   = new $fullName();

                if ($cObject instanceof FieldInterface) {
                    $objects[$className] = $cObject;
                }

            }
        }

        if ($debug) {
            d($objects);
        }

        $constants   = [];
        $definitions = [];
        foreach ($objects as $name => $object) {
            /** @var $object FieldInterface */
            $constant = 'TYPE_'.$object::getConstantName();
            $key      = $object::getKey();
            $twig     = $object::getTwigPath();
            $class    = get_class($object);

            $constants[$constant] = $key;
            $definitions[$key]    = [
                'name'     => $name,
                'constant' => $constant,
                'twig'     => $twig,
                'class'    => $class,
            ];
        }

        // Make sure directory exists!
        $dir = rtrim(__DIR__, DIRECTORY_SEPARATOR).DIRECTORY_SEPARATOR.'..'.
            DIRECTORY_SEPARATOR.'Generated'.DIRECTORY_SEPARATOR;
        if (!is_dir($dir)) {
            mkdir($dir);
        }
        $fileName = 'FieldConstants.php';
        $contents = '<?php'.PHP_EOL;
        $contents .= 'namespace GCWorld\\FormConfig\\Generated;'.PHP_EOL;
        $contents .= PHP_EOL;
        $contents .= 'interface FieldConstants'.PHP_EOL;
        $contents .= '{'.PHP_EOL;
        foreach ($constants as $k => $v) {
            $contents .= '    const '.$k.' = '.var_export($v, true).';'.PHP_EOL;
        }
        $contents .= PHP_EOL;

        $cEncoder = new PHPEncoder();
        $encoded  = $cEncoder->encode($definitions, [
            'array.base'         => 4,
            'array.inline'       => false,
            'array.omit'         => false,
            'array.indent'       => 4,
            'boolean.capitalize' => true,
            'null.capitalize'    => true,
        ]);
        $contents .= '    const DEFINITIONS = '.$encoded.';'.PHP_EOL;
        $contents .= '}'.PHP_EOL.PHP_EOL;

        file_put_contents($dir.$fileName, $contents);
    }
}
