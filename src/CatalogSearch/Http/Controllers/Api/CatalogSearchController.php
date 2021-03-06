<?php

namespace Zento\CatalogSearch\Http\Controllers\Api;

use CatalogSearchService;
use Request;
use Route;
use Zento\Kernel\Facades\DanamicAttributeFactory;
use Zento\Kernel\Http\Controllers\ApiBaseController;

class CatalogSearchController extends ApiBaseController
{
    /**
     * execute a general catalog search or under a specified category from storefront
     * @group Catalog Search
     * @urlParam id number specified category id
     */
    public function search()
    {
        return $this->_search();
    }

    /**
     * execute a catalog search from admin
     * @group Catalog Search
     */
    public function adminSearch()
    {
        DanamicAttributeFactory::withoutMappedValue(false);
        return $this->_search('admin', false);
    }

    protected function _search($visibility = 'storefront', $withAggreate = true)
    {
        $params = Request::all();
        $per_page = 15;
        $page = 1;

        $underCategorId = Route::input('id');

        if (isset($params['per_page'])) {
            $per_page = $params['per_page'];
            unset($params['per_page']);
        }

        if (isset($params['page'])) {
            $page = $params['page'];
            unset($params['page']);
        }

        if (!isset($params['visibility'])) {
            $params['visibility'] = $visibility;
        }
        $result = CatalogSearchService::search($underCategorId, $params, $per_page, $page, $withAggreate);
        $result['success'] ? $this->success($result['code']) : $this->error($result['code']);
        return $this->withData(
            $result['data']
        );
    }
}
