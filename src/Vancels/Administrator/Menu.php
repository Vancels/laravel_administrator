<?php
namespace Vancels\Administrator;

use Illuminate\Config\Repository AS Config;

class Menu
{

    /**
     * The config instance
     *
     * @var \Illuminate\Config\Repository
     */
    protected $config;

    /**
     * The config instance
     *
     */
    protected $configFactory;

    /**
     * Create a new Menu instance
     *
     * @param \Illuminate\Config\Repository $config
     */
    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    /**
     * Gets the menu items indexed by their name with a value of the title
     *
     * @param array $subMenu (used for recursion)
     *
     * @return array
     */
    public function getMenu($subMenu = null)
    {
        $menu = array();

        if (!$subMenu) {
            $subMenu = $this->config->get('administrator.menu');
        }

        //iterate over the menu to build the return array of valid menu items
        foreach ($subMenu as $key => $item) {
            //if the item is a string, find its config
            if (is_string($item)) {
                //fetch the appropriate config file
                $config = $this->make($item);

                //if a config object was returned and if the permission passes, add the item to the menu
                if (1) {
                    $menu[$item] = $config;
                } //otherwise if this is a custom page, add it to the menu
                else {
                    if ($config === true) {
                        $menu[$item] = $key;
                    }
                }
            } else {
                //if the item is an array, recursively run this method on it
                if (is_array($item)) {
                    $menu[$key] = $this->getMenu($item);

                    //if the submenu is empty, unset it
                    if (empty($menu[$key])) {
                        unset($menu[$key]);
                    }
                }
            }
        }

        return $menu;
    }

    public function make($item)
    {
        $default     = [
            'selected' => "",
            'url'      => '#',
            'title'    => '',
            'child'    => [],
        ];
        $rtn         = [];
        $config_path = config_path("administrator/{$item}.php");
        if (is_file($config_path)) {
            $rtn = include $config_path;
        }

        $rtn = array_merge($default, $rtn);
        $rtn = collect($rtn);

        return $rtn;
    }


}