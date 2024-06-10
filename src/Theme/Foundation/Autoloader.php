<?php

namespace Plott\PlottTheme\Foundation;

use Plott\PlottTheme\Contract\ConfigInterface;
use Plott\PlottTheme\Foundation\Exception\FileNotFoundException;

class Autoloader
{

    /**
     * Theme config instance
     * 
     * @var \Plott\PlottTheme\Contract\ConfigInterface
     */
    protected $config;

    /**
     * Construct autoloader
     * 
     * @param \Plott\PlottTheme\Contract\ConfigInterface $config
     */
    public function __construct(ConfigInterface $config)
    {
        $this->config =  $config;
    }

    /**
     * Autload registered files
     * 
     * @throws \Plott\PlottTheme\Foundation\Exception\FileNotFoundException
     * 
     * @return void
     */
    public function register()
    {
        do_action('plott/plotttheme/autloader/before_load');
        $this->load();
        do_action('plott/plotttheme/autloader/after_load');
    }

    /**
     * Localize and autoload files
     * 
     * @return void
     */
    public function load()
    {
        foreach($this->config['autoload'] as $file){
            if(!locate_template( $this->getRelativePath($file), true, true )){
                throw new FileNotFoundException("Autoloaded file [{$this->getPath($file)}] cannot be found, Please check your entries in `config/app.php file.");
            }
        }
    }

    /**
     * Gets absolute file path
     * 
     * @param string $file
     * 
     * @return string
     */
    public function getPath($file)
    {
        $file = $this->getRelativePath($file);

        return $this->config['paths']['directory'] . '/' . $file;
    }

    /**
     * Gets file path within the `theme` directory
     * 
     * @return string
     */
    public function getRelativePath($file)
    {
        return $this->config['directories']['app'] . '/' . $file;
    }

}
