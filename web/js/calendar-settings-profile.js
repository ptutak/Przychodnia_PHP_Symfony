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
        eventSources: [
            {
                url: Routing.generate('get_kalendarz_data',{ type: 'profile'}),
                type:'GET'
            }
        ]
    });
});
