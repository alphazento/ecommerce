<?php

namespace Zento\CatalogSearch\Model;

use Zento\Catalog\Model\ORM\SearchableFulltext;

class FullTextSearchEngine {
  private function handleHyphenWord($queryValue) {
    if (preg_match_all('/\w+(-\w+)+/', $queryValue, $matches)) {
        $replaces = [];
        $matches = $matches[0];
        foreach($matches as $match) {
            if(preg_match_all('/[a-zA-Z]+(\d+)\w+/', $match, $matches1) ) {
                if (count($matches1[0]) > 1) {
                    $replaces[$match] = str_replace('-', ' ', $match);
                }
            }
        }

        foreach($replaces as $key => $value) {
            $queryValue = str_replace($key, $value, $queryValue);
        }
    }
    return $queryValue;
  }

  public function search($query_text) {
      $ft_min_word_len = 2;
      $keywords = str_replace('-', '', $this->handleHyphenWord($query_text));
      return (new SearchableFulltext())->search($keyword);
  }
}