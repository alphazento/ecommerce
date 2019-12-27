<?php

namespace Zento\Backend\Services;

class AdminDashboardService
{
  protected $menus = [];

  public function getMenus() {
    return $this->menus;
  }

  /**
   * the url should be vue route url
   */
  public function registerRootLevelMenuNode($name, $title, $icon = null, $url = null) 
  {
    if (!isset($this->menus[$name])) {
      $this->menus[$name] = [
        'title' => $title,
        'url' => $url,
        'icon' => $icon,
        'items' => []
      ];
    }
  }

  public function registerL1MenuNode($parentName, $l1Name, $title, $icon = null,  $url = null) {
    if (!isset($this->menus[$parentName])) 
    {
      throw new \Exception(sprintf('Parent Menu %s not exists.', $parentName));
    }

    if (!$this->hasL1MenuNode($parentName, $l1Name))
    {
      $this->menus[$parentName]['items'][$l1Name] = [
        'title' => $title,
        'icon' => $icon,
        'url' => $url,
      ];
    }
  }

  protected function hasL1MenuNode($parentName, $l1Name) 
  {
    if (!isset($this->menus[$parentName])) {
      throw new \Exception(sprintf('Parent Menu %s not exists.', $parentName));
    }
    $menu = $this->menus[$parentName]['items'];
    return isset($menu[$l1Name]);
  }
}