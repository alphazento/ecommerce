<?php

namespace Zento\Catalog\Services;

use Zento\Catalog\Model\DB\Product as ProductModel;
use DB;
use Store;
use PrinterCategory;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ProductService
{

    const CURRENT_FREE_SHIPPING_CONFIGS = 'sales/free_shipping/%/active';
    const FREE_SHIPPING_RULES = 'sales/free_shipping/%s/active';
    const FREE_SHIPPING_RULES_THRESHOLD = 'sales/free_shipping/%s/threshold';

    protected $freeShippingRules = [];

    public function __construct()
    {
        $configs = Store::getConfigs(self::CURRENT_FREE_SHIPPING_CONFIGS);
        foreach ($configs as $config) {
            $paths = explode('/', $config->path);
            array_pop($paths);
            $rule = array_pop($paths);
            $this->freeShippingRules[] = $rule;
        }
    }

    public function load($idOrIds)
    {
        if (is_array($idOrIds)) {
            return ProductModel::whereIn('products_id', $idOrIds)->get();
        } else {
            return ProductModel::find($idOrIds);
        }
    }

    public function loadIdsByOrder($idOrIds)
    {
        if (is_array($idOrIds)) {
            return ProductModel::whereIn('products_id', $idOrIds)->orderByRaw("field(products_id," . implode(',', $idOrIds) . ")")->get();
        } else {
            return ProductModel::find($idOrIds);
        }
    }

    public function collection()
    {
        return (new ProductModel)->newQuery();
    }

    public function url($product)
    {
        $product = ($product instanceof ProductModel) ? $product : ProductModel::find($product);
        return null;
    }

    public function images($product)
    {
        $product = ($product instanceof ProductModel) ? $product : ProductModel::find($product);
    }

    public function isShippingFree($price, $weight)
    {
        foreach ($this->freeShippingRules as $rule) {
            $isActive = Store::getConfig(sprintf(self::FREE_SHIPPING_RULES, $rule));
            if ($isActive) {
                $threshold = Store::getConfig(sprintf(self::FREE_SHIPPING_RULES_THRESHOLD, $rule));
                if ($rule == 'check_order_subtotal') {
                    if ($price >= (int)$threshold) {
                        return true;
                    }
                }
                if ($rule == 'check_single_product_weight') {
                    if ($weight == (float)$threshold) {
                        return true;
                    }
                }
            }
        }
        return false;
    }

    /**
     * @param ProductModel $product
     * @param $printerModelId
     * @return array
     */
    public function getBreadcrumbs(ProductModel $product, $printerModelId)
    {
        if (is_null($printerModelId)) {
            return $product->getCartridgeSeries(true);
        }

        $printerModel = PrinterCategory::load($printerModelId);
        if (!is_null($printerModel)) {
            return $printerModel->categoryTree(false);
        }

        throw new NotFoundHttpException('Printer model was not found.');
    }

    /**
     * @param ProductModel $product
     * @param $printerModelId
     * @return string
     */
    public function getDisplayName(ProductModel $product, $printerModelId)
    {
        if (is_null($printerModelId)) {
            return $product->getName(true);
        }

        $printerModel = PrinterCategory::load($printerModelId);
        if (!is_null($printerModel)) {
            return $product->getName(true) . ' for ' . $printerModel->category_name . ' printer';
        }

        throw new NotFoundHttpException('Printer model was not found.');
    }

}