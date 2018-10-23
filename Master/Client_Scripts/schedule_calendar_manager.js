$(document).ready(function() {

    // Getting today's current date
    var today = new Date();
    var date = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();

    console.log(date);

    $('#calendar').fullCalendar
    ({
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,basicWeek,basicDay'
        },
        defaultDate: date,
        navLinks: true, // can click day/week names to navigate views
        editable: true,
        eventLimit: true, // allow "more" link when too many events
        selectable: true,
        selectHelper: true,

        dayClick: function(date, allDay, jsEvent, view)
        {
            // Date object, need to increment day to get the right one
            var selectedDate = date._d;
            selectedDate.setDate(selectedDate.getDate() + 1);
            selectedDate = selectedDate.getFullYear() + '-' + (selectedDate.getMonth()+1) + '-' + selectedDate.getDate();
            console.log(selectedDate);
        },

        loading: function(bool) {
            $('#loading').toggle(bool);
        }

    });

});