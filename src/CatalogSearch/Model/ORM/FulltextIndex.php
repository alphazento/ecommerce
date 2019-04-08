<?php

namespace Zento\CatalogSearch\Model\ORM;

use DB;

class FulltextIndex extends \Illuminate\Database\Eloquent\Model {
    protected $primaryKey = 'product_id';
    public $timestamps = false;

    private function getTableName() {
        return sprintf('%s%s', $this->getConnection()->getTablePrefix(), $this->getTable());
    }
    
    public function search($keyword) {
        // $sql = sprintf('SELECT m.product_id,
        //     ((0) + LEAST((MATCH (m.data_index) AGAINST ("%s" IN BOOLEAN MODE)), 1000000) * POW(2, s.search_weight)) AS `score`    
        //     from %s as m
        //     inner join ink_search_fields as s on m.field_name = s.field_name
        //     where (MATCH (data_index) AGAINST ("%s" IN BOOLEAN MODE)) order by score',
        //         $keyword, 
        //         $this->getTableName(),
        //         $keyword);
        $sql = sprintf('SELECT m.product_id,
                ((0) + LEAST((MATCH (m.data_index) AGAINST ("%s" IN BOOLEAN MODE)), 1000000) * POW(2, 10)) AS `score`    
                from %s as m
                where (MATCH (data_index) AGAINST ("%s" IN BOOLEAN MODE)) order by score',
                    $keyword, 
                    $this->getTableName(),
                    $keyword);
        
        return \DB::table(\DB::raw('('.$sql.') as A'))
                ->selectRaw('A.product_id')
                ->groupBy(DB::raw('A.product_id'))
                ->get()
                ->pluck("product_id")
                ->toArray();
    }
}