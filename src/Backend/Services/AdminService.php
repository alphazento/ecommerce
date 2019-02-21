<?php

namespace Zento\Backend\Services;

class AdminService
{
  protected $menus = [];
  protected $config_groups = [];
  protected $pendingBeforeGroupCreated = [];

  public function getMeus() {
    return $this->menus;
  }

  public function getDetailGroup($key) {
    return isset($this->config_groups[$key]) ? $this->config_groups[$key]: [];
  }

  public function registerRootLevelMenuNode($name, $title) 
  {
    if (!isset($this->menus[$name])) {
      $this->menus[$name] = [
        'title' => $title,
        'items' => []
      ];
    }
  }

  public function registerL1MenuNode($parentName, $l1Name, $title) {
    if (!isset($this->menus[$parentName])) 
    {
      throw new \Exception(sprintf('Parent Menu %s not exists.', $parentName));
    }

    if (!$this->hasL1MenuNode($parentName, $l1Name))
    {
      $this->menus[$parentName]['items'][$l1Name] = [
        'title' => $title,
      ];
    }
  }

  public function registerGroup($l0name_l1Name, $groupName, array $group) {
    if (!isset($this->config_groups[$l0name_l1Name])) {
      $this->config_groups[$l0name_l1Name] = [$groupName => $group];
    } else {
      if (!isset($this->config_groups[$l0name_l1Name][$groupName])) {
        $this->config_groups[$l0name_l1Name][$groupName] = $group;
      } else {
        throw new \Exception(sprintf('%s contains same group(%s).', $l0name_l1Name, $groupName));
      }
    }
    
    $key = strtolower(sprintf('%s:%s', $l0name_l1Name, $groupName));
    foreach($this->pendingBeforeGroupCreated[$key] ?? [] as $callback) {
      $callback($this, $l0name_l1Name, $groupName);
    }    
  }

  public function registerItemToGroup($l0name_l1Name, $groupName, array $item, $sort = 0) {
    if (!isset($this->config_groups[$l0name_l1Name]) || !isset($this->config_groups[$l0name_l1Name][$groupName])) {
        //call after group is created.
        $key = strtolower(sprintf('%s:%s', $l0name_l1Name, $groupName));
        if (!isset($this->pendingBeforeGroupCreated[$key])) {
          $this->pendingBeforeGroupCreated[$key] = [];
        }
        $this->pendingBeforeGroupCreated[$key][] = function($adminService, $l0name_l1Name, $groupName) use ($item, $sort) {
          $adminService->registerItemToGroup($l0name_l1Name, $groupName, $item, $sort);
        };
    } else {
      // if (isset($this->config_groups[$l0name_l1Name][$groupName])) {
        if (!isset($this->config_groups[$l0name_l1Name][$groupName]['items'])) {
          $this->config_groups[$l0name_l1Name][$groupName]['items'] = [];
        }
        if ($sort && !isset($this->config_groups[$l0name_l1Name][$groupName][$sort])) {
          $this->config_groups[$l0name_l1Name][$groupName]['items'][$sort] = $item;
        } else {
          $this->config_groups[$l0name_l1Name][$groupName]['items'][] = $item;
        }
      // } else {
      //   $this->config_groups[$l0name_l1Name][$groupName]['items']= [$item];
      // }
    }
  }

  public function registerSubgroupToGroup($l0name_l1Name, $groupName, $subGroupName, array $item) {
    if (!isset($this->config_groups[$l0name_l1Name])) {
      $this->config_groups[$l0name_l1Name] = [$groupName => ['subgroups' => [$subGroupName => [$item]]]];
  } else {
    if (isset($this->config_groups[$l0name_l1Name][$groupName])) {
      if (!isset($this->config_groups[$l0name_l1Name][$groupName]['subgroups'])) {
        $this->config_groups[$l0name_l1Name][$groupName]['subgroups'] = [];
      }
      $this->config_groups[$l0name_l1Name][$groupName]['subgroups'][$subGroupName] = $item;
    } else {
      $this->config_groups[$l0name_l1Name][$groupName]['subgroups'] = [$subGroupName => $item];
    }
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