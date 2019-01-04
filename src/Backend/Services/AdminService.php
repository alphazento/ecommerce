<?php

namespace Zento\Customer\Services;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Zento\Customer\Model\ORM\Customer;
use Zento\Customer\Model\ORM\CustomerAddress;

class AdminService
{
  protected $menus = [];
  public function registerRootLevelMenuNode($name, $title) 
  {
    $this->menus[$name] = [
      'title' => $title,
      'items' => []
    ];
  }

  public function registerL1MenuNode($parentName, $l1Name, $title) {
    if (!isset($this->menus[$parentName])) 
    {
      throw new \Exception(sprintf('Parent Menu %s not exists.', $parentName));
    }

    if ($menu = $this->hasL1MenuNode($parentName, $l1Name))
    {
      throw new \Exception(sprintf('%s has a same name Menu Node %s exists.', $parentName, $l1Name));
    }

    $menu[$l1Name] = [
      'title' => $title,
      'groups' => []
    ];
  }

  public function registerGroupToL1($parentName, $l1Name, $groupName, array $group) {
    if (!$this->hasGroup($parentName, $l1Name, $groupName)) {
      $this->menus[$parentName][$l1Name]['groups'] = $group;
    } else {
      throw new \Exception(sprintf('%s %s contains same group(%s).', $parentName, $l1Name, $groupName));
    }
  }

  public function registerItemToGroup($parentName, $l1Name, $groupName, array $item) {
    if ($this->hasGroup($parentName, $l1Name, $groupName)) {
      if (isset($this->menus[$parentName][$l1Name]['groups'][$groupName]['items'])) {
        $this->menus[$parentName][$l1Name]['groups'][$groupName]['items'] =[$group];
      } else {
        $this->menus[$parentName][$l1Name]['groups'][$groupName]['items'][] = $group;
      }
    } else {
      throw new \Exception(sprintf('%s %s does not contain group(%s).', $parentName, $l1Name, $groupName));
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

  protected function hasGroup($parentName, $l1Name, $groupName) 
  {
    if ($this->hasL1MenuNode($parentName, $l1Name)) {
      $groups = $this->menus[$parentName][$l1Name]['groups'];
      return isset($l1Menu[$groupName]);
    }
    return false;
  }
}