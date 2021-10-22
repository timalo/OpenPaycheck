function add_inputs() {
  n = $('#my_input').val();
  $("#emailform").html('');
  $("#emailform").append('<br><label for="group_name">Group name:</label>');
  $("#emailform").append('<input type="text" name="group_name" value="" ><br><br>');
  $("#emailform").append('<label for="your_email">Your email:</label>');
  $("#emailform").append('<input id="rolo_add' + 0 + '" name="email[]" type="email" value="" required/><br>');
  for (var i = 2; i <= n; i++) {
    $("#emailform").append('<span>Member ' + i + ': </span><input id="rolo_add' + i + '" name="email[]" type="email" value="" required/><br>');
    

    }
    $("#emailform").append('<br><input type="submit" value="Submit">');
  }

