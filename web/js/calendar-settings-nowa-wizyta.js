$(function () {
    $('#calendar-holder').fullCalendar({
        validRange: function(nowDate) {
            return {
                start: nowDate
            };
        },
        themeSystem: 'bootstrap3',
        defaultView: 'basicWeek',
        header: {
            left: 'prev, next',
            center: 'title',
            right: 'month, basicWeek, basicDay'
        },
        displayEventTime: true,
        displayEventEnd:true,
        lazyFetching: true,
        allDayDefault:false,
        timeFormat: 'H(:mm)',
        eventClick: function(event,jsEvent,view){
            var startDate=event.start.unix();
            $.get(Routing.generate('set_kalendarz_data',{
                type:'wizyta_new_select',
                start: startDate,
                end: startDate,
                idLekarzGodzPrzyj:event.idLekarzGodzPrzyj,
                _:Date.now()
            }));
//            refetchDelay(150);
            window.location.replace(Routing.generate('fos_user_profile_expose'));
        },
        events: function(start, end, timezone, callback) {
            var item=$('#lekarzChoice').jqxDropDownList('getSelectedItem');
            if (item)
                item=item.value;
            $.ajax({
                url: Routing.generate('get_kalendarz_data',{ type: 'wolna_wizyta_lekarz'}),
                dataType: 'json',
                data: {
                    start: moment().unix(),
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
