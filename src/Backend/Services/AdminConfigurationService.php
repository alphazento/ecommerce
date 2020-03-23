<?php

namespace Zento\Backend\Services;

class AdminConfigurationService extends AdminDashboardService
{
  protected $data = [];
  protected $pendingBeforeGroupCreated = [];

  public function getDetailGroup($key) {
    return isset($this->data[$key]) ? $this->data[$key]: [];
  }

  public function registerGroup($pathTag, $sub, array $group) {
    if (!isset($this->data[$pathTag])) {
      $this->data[$pathTag] = [$sub => $group];
    } else {
      if (!isset($this->data[$pathTag][$sub])) {
        $this->data[$pathTag][$sub] = $group;
      } else {
        throw new \Exception(sprintf('%s contains same group(%s).', $pathTag, $sub));
      }
    }
    
    $key = strtolower(sprintf('%s:%s', $pathTag, $sub));
    foreach($this->pendingBeforeGroupCreated[$key] ?? [] as $callback) {
      $callback($this, $pathTag, $sub);
    }    
  }

  public function registerItemToGroup($pathTag, $sub, array $item, $sort = 0) {
    if ($this->data[$pathTag][$sub] ?? false) {
        if (!isset($this->data[$pathTag][$sub]['items'])) {
          $this->data[$pathTag][$sub]['items'] = [];
        }
        if ($sort && !isset($this->data[$pathTag][$sub][$sort])) {
          $this->data[$pathTag][$sub]['items'][$sort] = $item;
        } else {
          $this->data[$pathTag][$sub]['items'][] = $item;
        }
    } else {
      //call after group is created.
      $key = strtolower(sprintf('%s:%s', $pathTag, $sub));
      if (!isset($this->pendingBeforeGroupCreated[$key])) {
        $this->pendingBeforeGroupCreated[$key] = [];
      }
      $this->pendingBeforeGroupCreated[$key][] = function($AdminConfigurationService, $pathTag, $sub) use ($item, $sort) {
        $AdminConfigurationService->registerItemToGroup($pathTag, $sub, $item, $sort);
      };
    }
  }

  public function removeItemFromGroup($pathTag, $sub, $itemName) {
    $items = $this->data[$pathTag][$sub]['items'] ?? [];
    for($i = 0, $len = count($items); $i < $len; $i++) {
      $item = $items[$i];
      if ((isset($item['text']) && $item['text'] === $itemName)) {
          array_splice($this->data[$pathTag][$sub]['items'], $i, 1);
      }
    }
  }

  public function registerSubgroupToGroup($pathTag, $sub, $subsub, array $item) {
    if (!isset($this->data[$pathTag])) {
      $this->data[$pathTag] = [$sub => ['subgroups' => [$subsub => [$item]]]];
    } else {
      if (isset($this->data[$pathTag][$sub])) {
        if (!isset($this->data[$pathTag][$sub]['subgroups'])) {
          $this->data[$pathTag][$sub]['subgroups'] = [];
        }
        $this->data[$pathTag][$sub]['subgroups'][$subsub] = $item;
      } else {
        $this->data[$pathTag][$sub]['subgroups'] = [$subsub => $item];
      }
    }
  }

  protected function hasGroup($parentName, $l1Name, $sub) 
  {
    if ($this->hasLevel1MenuNode($parentName, $l1Name)) {
      $groups = $this->menus[$parentName][$l1Name]['groups'];
      return isset($l1Menu[$sub]);
    }
    return false;
  }
}