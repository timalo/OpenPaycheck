
function add_inputs() {
  n = $('#my_input').val();
  $("#rolonum").html('');
  for (var i = 1; i <= n; i++) {
    $("#rolonum").append('<span>Member ' + i + ' </span><input id="rolo_add' + i + '" name="addposition"  type="email" value="" required/><br>');

    }

}
