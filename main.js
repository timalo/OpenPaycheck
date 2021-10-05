



function add_inputs() {
    n = $('#my_input').val();
    $("#rolonum").html('');
    for (var i = 1; i <= n; i++) {
      $("#rolonum").append('<span>Member ' + i + ' </span><input id="rolo_add' + i + '" name="addposition"  type="email" value="" required/><br>');

    }
  }

    function returnText(){
      let groupName = document.getElementById("groupName").value;
      let email_1 = document.getElementById("email_1").value;
      n = $('#my_input').val();
      var arr = [];

      for (var i = 1; i <= n; i++) {
        arr.push(document.getElementById("rolo_add" + i).value);
    }
      alert(arr);
  }


  