function refetchDelay(delay){
    window.setTimeout(function(){
        $('#calendar-holder').fullCalendar('refetchEvents');
    },delay);
}

$(function () {
    var date = new Date();
    var d = date.getDate();
    var m = date.getMonth();
    var y = date.getFullYear();

    $('#calendar-holder').fullCalendar({
        locale:'pl',
        header: {
            left: 'prev, next',
            center: 'title',
        },
        allDayDefault:true,
        lazyFetching: false,
        timeFormat: 'H(:mm)',
        selectable:true,
        selectHelper:true,
        select: function(start,end,jsEvent,view,resource){
            $.get(Routing.generate('set_kalendarz_data',{
                type: 'urlop',
                start:start.unix(),
                end:end.unix()-1,
                _:Date.now()
            }));
            refetchDelay(150);
        },
        eventClick: function(event,jsEvent,view){
            var startDate=event.start.unix();
            $.get(Routing.generate('set_kalendarz_data',{
                type:'urlop',
                start: startDate,
                end: startDate,
                _:Date.now()
            }));
            refetchDelay(150);
        },
        events: function(start, end, timezone, callback) {
            $.ajax({
                url: Routing.generate('get_kalendarz_data',{ type: 'urlop'}),
                dataType: 'json',
                data: {
                    start: start.unix(),
                    end: end.unix(),
                    _:Date.now()
                },
                success: function(json) {
                    var events = []
                    jQuery.each(json, function(i, ob) {
                        events.push(ob);
                    });
                    callback(events);
                },
            });
        }
    });


});
