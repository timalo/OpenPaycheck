function add_inputs() {
  n = $('#my_input').val();
  $("#emailform").html('');
  for (var i = 1; i <= n; i++) {
    $("#emailform").append('<span>Member ' + i + ' </span><input id="rolo_add' + i + '" name="email[]" type="email" value="" required/><br>');

    }
    $("#emailform").append('<input type="submit" value="Submit">');
  }

function returnText(){
  console.log("paska");
  let groupName = document.getElementById("groupName").value;
  let email_1 = document.getElementById("email_1").value;
  n = $('#my_input').val();
  var arr = [];

  var display = document.getElementById("content");
  var xmlhttp = new XMLHttpRequest();
  xmlhttp.open("GET", "mail.php");
  xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xmlhttp.send(email_1);
  xmlhttp.onreadystatechange = function() {
    if (this.readyState === 4 && this.status === 200) {
      display.innerHTML = this.responseText;
    } else {
      display.innerHTML = "Loading...";
    };
  }
  

  for (var i = 1; i <= n; i++) {
    arr.push(document.getElementById("rolo_add" + i).value);
}
  alert(arr);
}  
