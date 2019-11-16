
<section class="brand-finder">
    <h2 class="brand-finder__h2">{{ $brandName }} Finder</h2>
    <div class="brand-finder__row">
        <div class="brand-finder__left">
            <div class="brand-finder__holder">

                    <div class="form-group">
                        <h3 class="brand-finder__h3">Search by {{ $brandName }} Type</h3>
                        <select class="form-control" name="c" onchange="location = this.value;">
                            <option value="" selected="" disabled="true">Select {{ $brandName }} Printer
                                Series
                            </option>
                            <option value="{{$brandUrl}}">All Cartridge Types</option>
                            @foreach($seriesDropDown as $drop)
                                @if($typeName ==$drop['name']  )
                                    <option selected value="{{ $drop['url'] }}">{{$drop['name'] }}</option>
                                @else
                                    <option value="{{$drop['url']  }} ">{{ $drop['name']}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>

                    <div class="d-md-flex">
                        <div class="pr-md-2 w-100">
                            <div class="form-group mb-3">
                                <h3 class="brand-finder__h3">Search by {{ $brandName }} Printer Model</h3>
                                <select class="form-control" onchange="location = this.value;">
                                    <option value="" selected="" disabled="true">Select {{ $brandName }} Printer Model
                                    </option>
                                    @foreach($printerModelsDropDown as $drop)
                                        <option value="{{$drop['url']  }} ">{{ $drop['name']}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

            </div>
        </div>
        <div class="brand-finder__middle">
            OR
        </div>
        <div class="brand-finder__right">
            <div class="brand-finder__holder">
                <h3 class="brand-finder__h3">Search by {{ $brandName }} Cartridge Code</h3>
                    <div class="form-group">
                        <select class="form-control" onchange="location = this.value;">
                            <option value="" selected="">Select your cartridge...</option>
                            <?php $cartridgeSeries = \Inkstation\Catalog\Model\DB\CartridgeSeries::findBrandType($brandName, $typeName,
                                ['allChildren', 'allChildren.description', 'allChildren.activeChildren', 'allChildren.activeChildren.description' ]);?>
                            @if ($cartridgeSeries)
                                <?php
                                $map = [];
                                $names = [];

                                $childrenCollection = $cartridgeSeries->activeChildren;
                                if ($model = $childrenCollection->first()) {
                                    $model->massAssignEav($childrenCollection, 'url_rewrite');
                                }
                                foreach ($childrenCollection as $model) {
                                    // foreach ($cartridgeSeries->activeChildren as $model) {
                                    $names[] = $model->getName();
                                    $map[$model->getName()] = $model->getUrl();
                                }
                                natsort($names);
                                ?>
                                @foreach($names as $name)
                                    <option value="{{ $map[$name]  }} ">{{ $name}}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
            </div>
        </div>
    </div>
</section>

