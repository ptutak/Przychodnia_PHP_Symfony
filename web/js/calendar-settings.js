$(function () {
    var date = new Date();
    var d = date.getDate();
    var m = date.getMonth();
    var y = date.getFullYear();

    $('#calendar-holder').fullCalendar({
        header: {
            left: 'prev, next',
            center: 'title',
            right: 'month, basicWeek, basicDay,'
        },
        lazyFetching: true,
        timeFormat: {
            // for agendaWeek and agendaDay
            agenda: 'h:mmt',    // 5:00 - 6:30

            // for all other views
            '': 'h:mmt'         // 7p
        },
        eventSources: [
            {
                url: Routing.generate('fullcalendar_loader'),
                type: 'POST',

                // A way to add custom filters to your event listeners
                data: {
                    filter:'my_filter',
                    url:getBaseUrl()
                },

                error: function() {
                   //alert('There was an error while fetching Google Calendar!');
                }
            },
            {
                url: '/php/calendar-feed.php',
                type: 'POST',
                data: {
                    filter:'my_filter'
                },

                error: function() {
                    //alert('There was an error while fetching Google Calendar!');
                }
            }
        ]
    });
});
