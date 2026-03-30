"use strict"
var app = new Vue({
  el: '#app',
  data: {
    counter: parseInt(counters),
    names: []
  },
  created() {
    $.get(reservationRoute, (data) => {
      for (var i = 0; i < data.length; i++) {
        this.names.push(data[i].name);
      }

    });
  },
  methods: {
    addOption() {
      $("#optionarea").addClass('d-block');
      this.counter++;
    },
    removeOption(n) {
      $("#counterrow" + n).remove();
      if ($(".counterrow").length == 0) {
        this.counter = 0;
      }
    }
  }
})
