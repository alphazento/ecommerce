<?php
namespace Zento\BladeTheme\Services\Concerns;

trait TraitBreadcrumb
{
    protected $breadcrumbData = [];

    public function __toString()
    {
        return json_encode($this->breadcrumbData, JSON_PRETTY_PRINT);
    }

    public function breadcrumb($url, $title)
    {
        $this->breadcrumbData[] = compact('url', 'title');
        return $this;
    }

    public function getBreadcrumb()
    {
        return $this->breadcrumbData;
    }
}
