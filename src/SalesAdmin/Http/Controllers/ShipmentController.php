<?php

namespace Zento\SalesAdmin\Http\Controllers\Api;

use Route;
use Request;
use Response;
use Auth;

use Zento\Sales\Model\ORM\ShipmentCarrier;
use Zento\Sales\Model\ORM\ShipmentMethod;

use Zento\Kernel\Http\Controllers\ApiBaseController;

class ShipmentController extends ApiBaseController
{
    public function carriersAndMethodes() {
      $carrierProvider = app('\Zento\Sales\Model\ORM\ShipmentCarrier');
      $collection = $carrierProvider->with('methodes');

      $collection->where('active', '=', 1);
      $this->states = [];
      $countries = $collection->get()->map(function($item) {
        $this->states[$item->alpha2_code] = $item->states->map(function($state) {
          return [
            'label' => $state->name,
            'value' => $state->code
          ];
        });
        return [
          'label' => $item->name,
          'value' => $item->alpha2_code
        ];
      });

      return $this->withData([
        'countries' => $countries,
        'states' => $this->states
      ]);
    }
}