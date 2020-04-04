<?php

namespace Zento\Customer\Http\Controllers\Api;

use Route;
use Request;
use Response;
use Auth;

use Zento\Customer\Model\ORM\Country;
use Zento\Kernel\Http\Controllers\ApiBaseController;

class AddressController extends ApiBaseController
{
    protected $states;

    /**
     * list coutries and their states
     * @group Utility
     * @queryParam active_for required ['backend', 'frontend'] Example:frontend
     */
    public function countryAndStates() {
      $isBackend = Request::get('active_for') === 'backend';
      $collection = Country::with('states');
      if ($isBackend) {
        $collection->where('backend_active', '=', 1);
      } else {
        $collection->where('frontstore_active', '=', 1);
      }
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