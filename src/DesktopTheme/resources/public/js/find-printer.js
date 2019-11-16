var $ = jQuery.noConflict();
jQuery(document).ready(function ($) {
    var $brandSelector = $('#brand-id');
    var $printerSeriesSelector = $('#printer-series');
    var $printerModelSelector = $('#printer-model');
    var $loading = $('<option value="loading">Loading...</option>');

    function sortByAlphabet(a, b) {
        if (a.name < b.name) return -1;
        if (a.name > b.name) return 1;
        return 0;
    }

    $brandSelector.on('change', function () {
        $(this).siblings('.alert').hide();
        if ($(this).val() === 'default') {
            reset([$printerSeriesSelector, $printerModelSelector]);
            return false;
        }
        toggleLoading($printerSeriesSelector);
        $.ajax({
            url: '/brands/' + $(this).val() + '/printer-series',
            type: 'GET',
            dataType: 'json',
        })
            .done(function (response) {
                var series = response.data.sort(sortByAlphabet);
                reset([$printerSeriesSelector]);
                series.forEach(function (series) {
                    $printerSeriesSelector.append('<option value="' + series.ids.join(',') + '">' + series.name + '</option>');
                });
            })
            .fail(function () {
                console.error('Could not load printer series...');
            })
            .always(function () {
                toggleLoading($printerSeriesSelector);
            })
    });

    $printerSeriesSelector.on('change', function () {
        $(this).siblings('.alert').hide();
        if ($(this).val() === 'default') {
            reset([$printerModelSelector]);
            return false;
        }
        toggleLoading($printerModelSelector);
        $.ajax({
            url: '/brands/printer-series/printer-models',
            type: 'GET',
            dataType: 'json',
            data: {seriesIds: $(this).val()}
        })
            .done(function (response) {
                var printerModels = response.data.sort(sortByAlphabet);
                reset([$printerModelSelector]);
                printerModels.forEach(function (printerModel) {
                    $printerModelSelector.append('<option value="' + printerModel['url'] + '">' + printerModel['name'] + '</option>');
                });
            })
            .fail(function () {
                console.error('Could not load printer models...');
            })
            .always(function () {
                toggleLoading($printerModelSelector);
            });
    });

    $printerModelSelector.on('change', function () {
        $(this).siblings('.alert').hide();
    });

    $('#find').on('click', function () {
        if (validate()) {
            window.location = $printerModelSelector.val();
        }
    });

    function reset($selects) {
        $selects.forEach(function ($select) {
            $select.find('option').not(':first').remove();
        });
    }

    function validate() {
        return [$brandSelector, $printerSeriesSelector, $printerModelSelector].every(function ($select) {
            if ($select.val() !== 'default') {
                return true;
            }
            $select.siblings('.alert').show();
            return false;
        });
    }

    function toggleLoading($select) {
        if ($select.find('option').length === 1) {
            $select.prop('disabled', true).append($loading).val('loading');
            return true;
        }
        $select.prop('disabled', false).find('option[value="loading"]').remove();
        return false;
    }
});

