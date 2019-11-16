<div class="header-search-div"></div>
<div class="header-search-form">
    <form id="quick_find" name="quick_find" action="/search" method="GET">
        <div class="input-group">
            <input name="keywords" value="{{ !empty($oldSearchKeywords) ? $oldSearchKeywords: '' }}"
                   class="form-control py-2  border search-input"
                   placeholder="Search entire store here..."
                   autocomplete="tonercity"
                   size="10"
                   maxlength="30"
                   type="text">
            <button class="btn btn-outline-secondary border-left-0 border" type="submit">Search</button>
        </div>
    </form>
</div>

@push('rqjs_body')
requirejs(['jQuery', 'bootstrap', 'typeahead', 'lodash'], function($) {

    var debouncedGetSuggestions = _.debounce(function(query, process) {
        var suggestions = [];
        return $.get('{{ route('search.autoSuggest') }}', { keywords: query },
            function(data) {
                $.each(data, function(index, record) {
                    suggestions.push(record.keywords + "#" + record.count);
                });
                process(suggestions);
            });
    }, 500);

    $('[name="keywords"]').typeahead({
        highlighter: function(item) {
            var parts = item.split('#');
            var html = '<div class="typeahead">';
            html += '<span class="">' + parts[0] + '</span>';
            html += '</div>';
            return html;
        },
        updater: function(item) {
            return item.split('#')[0];
        },
        // Do not let this plugin have a chance to sort data for us
        // because backend system has sorted.
        sorter: function(items) {
            return items;
        },
        source: function(query, process) {
            debouncedGetSuggestions(query, process);
        },
        items: 20,
        // Disable auto selecting the first item so that users can search for whatever they type.
        autoSelect: false,
        afterSelect: function() {
            $('#quick_find').submit();
        },
        enterHandler: function(e) {
            if(e.keyCode == 13) {
                $('#quick_find').submit();
            }
        }
    });

    $('[name="keywords"]').on('keypress', function(e) {
        if(e.which == 13) {
            $('#quick_find').submit();
        }
    });
});
@endpush
