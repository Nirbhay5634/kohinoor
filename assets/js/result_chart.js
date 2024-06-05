function updateTable() {
  var month = document.getElementById("month-dropdown").value;
  var year = document.getElementById("year-dropdown").value;
  var action = "result-history";

  var tableBody = document.getElementById("table-body");
  tableBody.innerHTML = "";

  var today = new Date();
  var currentMonth = today.getMonth() + 1;
  var currentYear = today.getFullYear();
  var currentDay = today.getDate();

  var xhr = new XMLHttpRequest();
  xhr.open("POST", "globalAPI.php", true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xhr.onreadystatechange = function () {
    if (xhr.readyState === XMLHttpRequest.DONE) {
      if (xhr.status === 200) {
        var responseData = JSON.parse(xhr.responseText);

        if (
          parseInt(year) > currentYear ||
          (parseInt(year) == currentYear && parseInt(month) > currentMonth)
        ) {
          tableBody.innerHTML =
            "<tr><td colspan='4'>No data available</td></tr>";
        } else {
          var daysInMonth = new Date(year, month, 0).getDate();
          var endDay =
            parseInt(year) === currentYear && parseInt(month) === currentMonth
              ? currentDay
              : daysInMonth;
          for (var day = 1; day <= endDay; day++) {
            var dateStr =
              year +
              "-" +
              (month.length < 2 ? "0" : "") +
              month +
              "-" +
              (day < 10 ? "0" : "") +
              day;
            var hasData = false;
            responseData.forEach(function (rowData) {
              if (rowData.date === dateStr) {
                addRow(
                  tableBody,
                  rowData.date,
                  rowData.faridabad,
                  rowData.ds,
                  rowData.gali
                );
                hasData = true;
              }
            });
            if (!hasData) {
              addRow(tableBody, dateStr, "XX", "XX", "XX");
            }
          }
        }
      } else {
        console.error("Failed to fetch data from the server");
      }
    }
  };
  xhr.send("month=" + month + "&year=" + year + "&action=" + action);
}

function addRow(tableBody, date, faridabad, ds, gali) {
  var rowData = "<tr>";
  rowData += "<td>" + date + "</td>";
  rowData += "<td>" + (faridabad ? faridabad : "XX") + "</td>";
  rowData += "<td>" + (ds ? ds : "XX") + "</td>";
  rowData += "<td>" + (gali ? gali : "XX") + "</td>";
  rowData += "</tr>";
  tableBody.innerHTML += rowData;
}

// Populate year dropdown with current year and last 10 years
var yearDropdown = document.getElementById("year-dropdown");
var currentYear = new Date().getFullYear();
for (var i = 0; i <= 10; i++) {
  var option = document.createElement("option");
  option.value = currentYear - i;
  option.textContent = currentYear - i;
  yearDropdown.appendChild(option);
}

// Populate month dropdown with month names
var monthDropdown = document.getElementById("month-dropdown");
var months = [
  "January",
  "February",
  "March",
  "April",
  "May",
  "June",
  "July",
  "August",
  "September",
  "October",
  "November",
  "December",
];
for (var i = 0; i < months.length; i++) {
  var option = document.createElement("option");
  option.value = i + 1;
  option.textContent = months[i];
  monthDropdown.appendChild(option);
}

// Set default values for year and month dropdowns
var defaultYear = new Date().getFullYear();
var defaultMonth = new Date().getMonth() + 1;
yearDropdown.value = defaultYear;
monthDropdown.value = defaultMonth;

// Populate table initially
updateTable();
