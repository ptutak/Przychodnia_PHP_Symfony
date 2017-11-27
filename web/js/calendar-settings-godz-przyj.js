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
        columnHeader:false,
        header: false,
        locale:"pl",
        businessHours: {
            dow: [ 1, 2, 3, 4, 5 ], // Monday - Friday
           start: '7:00', // a start time
            end: '21:00', // an end time
        },
        allDaySlot:false,
        allDayDefault:false,
        lazyFetching: false,
        timeFormat: 'H:mm',
        selectable:true,
        selectHelper:true,
        select: function(start,end,jsEvent,view,resource){
            $.get(Routing.generate('set_kalendarz_data',{
                type: 'godz_przyj',
                start:Math.round(start.getTime()/1000)+3600,
                end:Math.round(end.getTime()/1000)+3600,
                _:Date.now()
            }));
            refetchDelay(150);
        },
        eventClick: function(event,jsEvent,view){
            var startDate=Math.round(event.start.getTime()/1000)+3600;
            var endDate=Math.round(event.end.getTime()/1000)+3600;
            $.get(Routing.generate('set_kalendarz_data',{
                type:'godz_przyj',
                start: startDate,
                end: endDate,
                _:Date.now()
            }));
            refetchDelay(150);
        },

        eventSources: [
            {
                url: Routing.generate('get_kalendarz_data',{ type: 'godz_przyj'}),
                type:'GET'
            }
        ]
    });


});
