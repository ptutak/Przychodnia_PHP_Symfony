function refetch(){
    $('#calendar-holder').fullCalendar('refetchEvents');
}

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
        allDayDefault:true,
        lazyFetching: false,
        timeFormat: 'H(:mm)',
        selectable:true,
        selectHelper:true,
        select: function(start,end,jsEvent,view,resource){
            $.get(Routing.generate('set_kalendarz_data',{
                type: 'urlop',
                start:Math.round(start.getTime()/1000)+3600,
                end:Math.round(end.getTime()/1000)+3600,
                _:Date.now()
            }));
            refetch();
        },
        eventClick: function(event,jsEvent,view){
            var startDate=Math.round(event.start.getTime()/1000)+3600;
            $.get(Routing.generate('set_kalendarz_data',{
                type:'urlop',
                start: startDate,
                end: startDate,
                _:Date.now()
            }));
            refetch();
        },

        eventSources: [
            {
                url: Routing.generate('get_kalendarz_data',{ type: 'urlop'}),
                type:'GET'
            }
        ]
    });


});
