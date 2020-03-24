<?php

namespace Zento\Backend\Services;

class AdminConfigurationService extends AdminDashboardService
{
  protected $data = [];
  protected $pendingBeforeGroupCreated = [];

  public function getDetailGroup($key) {
    $key = strtolower($key);
    return $this->data[$key] ?? [];
  }

  public function registerGroup($paths, array $data) {
    if (!is_array($paths)) {
      $paths = [$paths];
    }
    $this->setDataByPaths($paths, array_merge_recursive($this->getDataByPaths($paths), $data));
  }

  protected function getDataByPaths(array $paths) {
    $data = $this->data;
    if ($paths) {
      foreach($paths as $path) {
        if (!isset($data[$path])) {
          return [];
        }
        $data = $data[$path];
      }
    }
    return $data;
  }

  protected function setDataByPaths(array $paths, $values) {
    if (count($paths) > 0) {
      $data = &$this->data;
      foreach($paths as $path) {
        if (!isset($data[$path])) {
          $data[$path] = [];
        }
        $data = &$data[$path];
      }
      $data = $values;
      // unset($data);
    }
  }
}