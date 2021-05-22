var dp;

$(document).ready(function() {
    $("#filter").change(function() {
        loadResources();
    });

    $("#newRoom").click(function (args) {

        var modal = new DayPilot.Modal();
        modal.closed = function() {
            dp.clearSelection();

            var data = this.result;
            if (data && data.result === "OK") {
                loadResources();
            }
        };
        modal.showUrl(GlobalVariable.createRoomAjaxUrl);

    });

    initDp();
    loadResources();
    loadEvents();
});

function loadResources() {
    $.get(GlobalVariable.indexRoomAjaxUrl + "?capacity=" + $("#filter").val(),
        function(data) {
            dp.resources = data;
            dp.update();
        });
}

function loadEvents() {
    var start = dp.visibleStart();
    var end = dp.visibleEnd();

    $.get(GlobalVariable.indexReservationAjaxUrl,
        {
            start: start.toString(),
            end: end.toString()
        },
        function(data) {
            dp.events.list = data;
            dp.update();
        }
    );
}

function initDp()
{
    dp = new DayPilot.Scheduler("dp"); // створюємо новий примірник
    dp.startDate = DayPilot.Date.today().firstDayOfMonth(); //буде показуватися з першого дня поточного місяця
    dp.days = DayPilot.Date.today().daysInMonth();
    dp.scale = "Day"; //показувати тільки днями
    dp.timeHeaders = [ //налаштовуємо формат виводу заголовку
        { groupBy: "Month", format: "MMMM yyyy" },
        { groupBy: "Day", format: "d" }
    ];
    dp.rowHeaderColumns = [
        {title: "Room", width: 80},
        {title: "Capacity", width: 80},
        {title: "Status", width: 80}
    ];
    dp.onBeforeResHeaderRender = function(args) {
        var beds = function(count) {
            return count + " bed" + (count > 1 ? "s" : "");
        };

        args.resource.columns[0].html = beds(args.resource.capacity);
        args.resource.columns[1].html = args.resource.status;
        switch (args.resource.status) {
            case "Dirty":
                args.resource.cssClass = "status_dirty";
                break;
            case "Cleanup":
                args.resource.cssClass = "status_cleanup";
                break;
        }
    };
    dp.onBeforeEventRender = function(args) {
        var start = new DayPilot.Date(args.e.start);
        var end = new DayPilot.Date(args.e.end);

        var today = DayPilot.Date.today();
        var now = new DayPilot.Date();

        args.e.html = args.e.text + " (" + start.toString("M/d/yyyy") + " - " + end.toString("M/d/yyyy") + ")";

        switch (args.e.status) {
            case "new":
                var in2days = today.addDays(1);

                if (start < in2days) {
                    args.e.barColor = 'red';
                    args.e.toolTip = 'Застаріле (не підтверджено вчасно)';
                }
                else {
                    args.e.barColor = 'orange';
                    args.e.toolTip = 'Новий';
                }
                break;
            case "confirmed":
                var arrivalDeadline = today.addHours(18);

                if (start < today || (start.getDatePart() === today.getDatePart() && now > arrivalDeadline)) { // must arrive before 6 pm
                    args.e.barColor = "#f41616";  // red
                    args.e.toolTip = 'Пізнє прибуття';
                }
                else {
                    args.e.barColor = "green";
                    args.e.toolTip = "Підтверджено";
                }
                break;
            case 'arrived': // arrived
                var checkoutDeadline = today.addHours(10);

                if (end < today || (end.getDatePart() === today.getDatePart() && now > checkoutDeadline)) { // must checkout before 10 am
                    args.e.barColor = "#f41616";  // червоний
                    args.e.toolTip = "Пізній виїзд";
                }
                else
                {
                    args.e.barColor = "#1691f4";  // блакитний
                    args.e.toolTip = "Прибув";
                }
                break;
            case 'checkout': // перевірено
                args.e.barColor = "gray";
                args.e.toolTip = "Перевірено";
                break;
            default:
                args.e.toolTip = "Невизначений стан";
                break;
        }

        args.e.html = args.e.html + "<br /><span style='color:gray'>" + args.e.toolTip + "</span>";

        var paid = args.e.paid;
        var paidColor = "#aaaaaa";

        args.e.areas = [
            { bottom: 10, right: 4, html: "<div style='color:" + paidColor + "; font-size: 8pt;'>Paid: " + paid + "%</div>", v: "Visible"},
            { left: 4, bottom: 8, right: 4, height: 2, html: "<div style='background-color:" + paidColor + "; height: 100%; width:" + paid + "%'></div>", v: "Visible" }
        ];

    };
    dp.onTimeRangeSelected = function (args) {

        var modal = new DayPilot.Modal();
        modal.closed = function() {
            dp.clearSelection();

            var data = this.result;
            if (data && data.result === "OK") {
                loadEvents();
            }
        };
        modal.showUrl(GlobalVariable.createReservationAjaxUrl + "?start=" + args.start + "&end=" + args.end + "&resource=" + args.resource);

    };
    dp.onEventClick = function(args) {
        var modal = new DayPilot.Modal();
        modal.closed = function() {
            // reload all events
            var data = this.result;
            if (data && data.result === "OK") {
                loadResources();
            }
        };
        modal.showUrl(GlobalVariable.editReservationAjaxUrl.replace(':id', args.e.id()));
    };
    dp.onEventMoved = function (args) {
        $.post(GlobalVariable.changeDateReservationAjaxUrl.replace(':id', args.e.id()),
            {
                newStart: args.newStart.toString(),
                newEnd: args.newEnd.toString(),
                newResource: args.newResource
            },
            function(data) {
                dp.message(data.message);
            });
    };
    dp.allowEventOverlap = false;

    dp.eventDeleteHandling = "Update";
    dp.onEventDeleted = function(args) {
        console.log(1);
        $.ajax({
            url: GlobalVariable.deleteReservationAjaxUrl.replace(':id', args.e.id()),
            type: 'DELETE',
            success: function () {
                dp.message("Deleted.");
            }
        });
    };
    dp.init();
}
