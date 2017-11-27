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
        defaultView:'agendaDay',
        themeSystem:'bootstrap3',
        header: false,
        columnHeader:false,
        businessHours: {
            dow: [ 1, 2, 3, 4, 5 ], // Monday - Friday
           start: '7:00', // a start time
            end: '21:00', // an end time
        },
        displayEventTime:true,
        slotDuration:'00:05:00',
        minTime:'06:00:00',
        maxTime:'22:00:00',
        allDaySlot:false,
        allDayDefault:false,
        lazyFetching: false,
        timeFormat: 'H:mm',
        selectable:true,
        selectHelper:true,
        selectOverlap:false,
        eventOverlap:false,
        select: function(start,end,jsEvent,view,resource){
            $.get(Routing.generate('set_kalendarz_data',{
                type: 'godz_przyj_add',
                start:start.unix(),
                end:end.unix(),
                _:Date.now()
            }));
            refetchDelay(150);
        },
        events: function(start, end, timezone, callback) {
            $.ajax({
                url: Routing.generate('get_kalendarz_data',{ type: 'godz_przyj'}),
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
