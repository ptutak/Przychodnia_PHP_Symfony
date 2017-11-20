$(function () {
    var date = new Date();
    var d = date.getDate();
    var m = date.getMonth();
    var y = date.getFullYear();

    $('#calendar-holder').fullCalendar({
        header: {
            left: 'prev, next',
            center: 'title',
            right: 'month, basicWeek, basicDay'
        },
        displayEventTime: true,
        lazyFetching: true,
        timeFormat: 'H(:mm)',
        selectable:true,
        selectHelper:true,
        select: (function(start,end,jsEvent,view,resource){
            $.get(Routing.generate('set_kalendarz_data',{
                type: 'urlop',
                start:start.getTime(),
                end:end.getTime(),
                _:Date.now()
            }))
        }),
        eventSources: [
            {
                url: Routing.generate('get_kalendarz_data',{ type: 'urlop'}),
                type:'GET'
            }
        ]
    });
});
