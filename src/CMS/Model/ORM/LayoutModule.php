<?php

namespace Zento\CMS\Model\ORM;

use Illuminate\Support\Collection;

class LayoutModule extends \Illuminate\Database\Eloquent\Model
{
    protected $connection = 'opencart';
    protected $table = 'oc_layout_module';
    protected $primaryKey = 'layout_module_id';

    public function getDesignModule() {
        $codes = explode('.', $this->code);
        if (count($codes) < 2) {
            return null;
        }
        return DesignModule::where('code', $codes[0])
            ->first();
    }
}