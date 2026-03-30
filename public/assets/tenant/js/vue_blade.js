var app = new Vue({
  el: '#app',
  data: {
    type: 1,
    counter: 0,
    placeholdershow: true
  },
  methods: {
    typeChange() {
      if (this.type == 3) {
        this.placeholdershow = false;
      } else {
        this.placeholdershow = true;
      }
      if (this.type == 2 || this.type == 3) {
        this.counter = 1;
      } else {
        this.counter = 0;
      }
    },
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
