"use strict";
(function () {

  if (typeof disqus_shortname !== 'undefined') {
  var d = document, s = d.createElement('script');
  s.src = `https://${disqus_shortname}.disqus.com/embed.js`;
  s.setAttribute('data-timestamp', +new Date());
  (d.head || d.body).appendChild(s);
  }
 
  if (typeof hasSubdomain !== 'undefined') {
    $("input[name='username']").on('input', function () {
      let username = $(this).val();
      if (username.length > 0) {
        $("#username").text(username);
      } else {
        $("#username").text("{username}");
      }
    });

    $("input[name='username']").on('change', function () {
      let username = $(this).val();
      if (username.length > 0) {
        $.get(window.origin + "/check/" + username + '/username', function (data) {
          if (data === true) {
            $("#usernameAvailable").text('This username is already taken.');
          } else {
            $("#usernameAvailable").text('');
          }
        });
      } else {
        $("#usernameAvailable").text('');
      }
    });
  }
})();
