(function(factory) {
    "use strict";

    if (typeof define === "function" && define.amd) {
        define(["../widgets/datepicker"], factory);
    } else {
        factory(jQuery.datepicker);
    }
})(function(datepicker) {
    "use strict";

    datepicker.regional.ar = {
        closeText: "Done",
        prevText: "Prev",
        nextText: "Next",
        currentText: "Today",
       monthNames: [ "يناير", "فبراير", "مارس", "أبريل", "مايو", "يونيو", "يوليو", "أغسطس", "سبتمبر", "أكتوبر", "نوفمبر", "ديسمبر" ],
        monthNamesShort: [ "Jan", "Feb", "Mar", "Apr", "May", "Jun",
        "Jul", "Aug", "Sep", "Oct", "Nov", "Dec" ],
        dayNames: [ "Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday" ],
        dayNamesShort: [ "Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat" ],
         dayNamesMin: [ "الأحد", "الاثنين", "الثلاثاء", "الأربعاء", "الخميس", "الجمعة", "السبت" ],
        weekHeader: "Wk",
        dateFormat: "dd/mm/yy",
        firstDay: 1,
        isRTL: true,
        showMonthAfterYear: false,
        yearSuffix: "" 
    };
    
    datepicker.setDefaults(datepicker.regional.ar);

    return datepicker.regional.ar;
});