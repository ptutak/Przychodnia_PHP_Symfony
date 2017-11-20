$(function () {
    var date = new Date();
    var d = date.getDate();
    var m = date.getMonth();
    var y = date.getFullYear();

    function refetch(){
        $('#calendar-holder').fullCalendar('refetchEvents');
    }
    $('#calendar-holder').fullCalendar({
        header: {
            left: 'prev, next',
            center: 'title',
            right: 'month, basicWeek, basicDay'
        },
        allDayDefault:true,
        lazyFetching: true,
        timeFormat: 'H(:mm)',
        selectable:true,
        selectHelper:true,
        select: (function(start,end,jsEvent,view,resource){
            start.setHours(0,0,0);
            end.setHours(0,0,0);
            $.get(Routing.generate('set_kalendarz_data',{
                type: 'urlop',
                start:Math.round(start.getTime()/1000),
                end:Math.round(end.getTime()/1000),
                _:Date.now()
            }))
            refetch();
        }),
        eventSources: [
            {
                url: Routing.generate('get_kalendarz_data',{ type: 'urlop'}),
                type:'GET'
            }
        ]
    });
});
