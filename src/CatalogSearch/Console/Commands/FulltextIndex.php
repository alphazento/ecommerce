<?php

namespace Zento\CatalogSearch\Console\Commands;

use Zento\Catalog\Model\ORM\Product;
use Zento\CatalogSearch\Model\ORM\FulltextIndex as FulltextIndexModel;
use Zento\CatalogSearch\Providers\Facades\CatalogSearchService;

class FulltextIndex extends \Zento\Kernel\PackageManager\Console\Commands\Base
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'searchdata:index';
        
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'reindex fulltext for product search';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle() {
        $this->build();
    }

    const SEARCH_FIELDS = [
        'sku', 'url_key', 'name', 'climate', 'pattern', 'style_general'
    ];

    protected function collectFulltext($product, &$fields) {
        $productArray = $product->toArray();
        foreach(self::SEARCH_FIELDS as $field) {
            if (!isset($productArray[$field])) {
                continue;
            }
            $value = $productArray[$field];
            if (!isset($fields[$field])) {
                $fields[$field] = [];
            }
            $fields[$field] = array_merge($fields[$field], is_array($value) ? $value : [$value]);
        }
        foreach($product->configurables ?? [] as $subItem) {
            $this->collectFulltext($subItem, $fields);
        }
    }

    private function build() {
        $products = Product::all();
        foreach($products as $product) {
            $fields = [];
            $this->collectFulltext($product, $fields);

            foreach($fields as $key => $values) {
                $index = FulltextIndexModel::where('product_id', '=', $product->id)
                    ->where('field_name', '=', $key)
                    ->first();
                if (count($values) == 0) {
                    if (!empty($index)) {
                        $index->delete();
                    }
                    continue;
                }
                if (empty($index)) {
                    $index = new FulltextIndexModel();
                    $index->product_id = $product->id;
                    $index->field_name = $key;
                }
                $index->data_index = implode(' ', array_unique($values));
                $index->save();
            }
        }
    }
}
