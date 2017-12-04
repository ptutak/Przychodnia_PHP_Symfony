$(function () {
    $('#calendar-holder').fullCalendar({
        themeSystem: 'bootstrap3',
        header: {
            left: 'prev, next',
            center: 'title',
            right: 'month, basicWeek, basicDay'
        },
        displayEventTime: true,
        lazyFetching: true,
        timeFormat: 'H(:mm)',
        events: function(start, end, timezone, callback) {
            var item=$('#lekarzChoice').jqxDropDownList('getSelectedItem');
            if (item)
                item=item.value;
            $.ajax({
                url: Routing.generate('get_kalendarz_data',{ type: 'wizyta_new'}),
                dataType: 'json',
                data: {
                    start: start.unix(),
                    end: end.unix(),
                    idLekarz: item,
                    _:Date.now()
                },
                success: function(json) {
                    var events = [];
                    jQuery.each(json, function(i, ob) {
                        events.push(ob);
                    });
                    callback(events);
                }
            });
        }
    });
});
