
function handleSalary() {
    // console.log($("#salaryInput").val() + "€ per " + $("#salaryTime").val());
    let salary = $("#salaryInput").val();
    let timeInterval = $("#salaryTime").val();
    let monthlySalary = 0;
    switch(timeInterval) {
        case "hour":
            break;
        case "month":
            break;
        case "year":
            break;
    }
}

function toggleHours() {
    console.log("changing interval");
    let choice = $("#salaryTime").val();
    console.log(choice);
    if (choice == "hour"){
        $("#hoursPerWeek").show();
    }
    else {
        $("#hoursPerWeek").hide();
    }
}