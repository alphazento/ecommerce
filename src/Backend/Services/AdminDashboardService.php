<?php

namespace Zento\Backend\Services;

use Illuminate\Support\Str;

class AdminDashboardService
{
  protected $menus = [];

  public function getMenus() {
    return $this->menus;
  }

  /**
   * the url should be vue route url
   */
  public function registerRootLevelMenuNode($name, $icon = null, $url = null) 
  {
    $key = strtolower(Str::slug($name));
    if (!isset($this->menus[$key])) {
      $this->menus[$key] = [
        'text' => $name,
        'url' => $url,
        'icon' => $icon,
        'items' => []
      ];
    }
  }

  public function registerLevel1MenuNode($parentName, $l1Name, $icon = null,  $url = null) {
    $key0 = strtolower(Str::slug($parentName));
    if (!isset($this->menus[$key0])) 
    {
      throw new \Exception(sprintf('Parent Menu %s not exists.', $parentName));
    }

    if (!$this->hasLevel1MenuNode($key0, $l1Name))
    {
      $key1 = strtolower(Str::slug($l1Name));
      $this->menus[$key0]['items'][$key1] = [
        'text' => $l1Name,
        'icon' => $icon,
        'url' => $url,
      ];
    }
  }

  protected function hasLevel1MenuNode($parentName, $l1Name) 
  {
    $key0 = strtolower(Str::slug($parentName));
    if (!isset($this->menus[$key0])) {
      throw new \Exception(sprintf('Parent Menu %s not exists.', $parentName));
    }
    $menu = $this->menus[$key0]['items'];
    $key1 = strtolower(Str::slug($l1Name));
    return isset($menu[$key1]);
  }
}