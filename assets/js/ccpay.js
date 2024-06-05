function toPaytm() {
  var accNo = $("#nes_accno").html();
  if (accNo == "") {
    alert("The payee is blank");
    return false;
  }
  accNo = accNo.split("@")[0];
  window.open(
    "paytmmp://cash_wallet?featuretype=sendmoneymobile&recipient=" + accNo
  );
}

function submit() {
  if (document.getElementById("utr").value.length < 12) {
    document.getElementById("error").innerHTML = "Invalid UTR number";
    document.getElementById("error").style.display = "block";
    setTimeout(function error() {
      document.getElementById("error").innerHTML = "";
      document.getElementById("error").style.display = "none";
    }, 2000);
  } else {
    document.getElementById("payment").submit();
  }
}

function countDown() {
  var time = document.getElementById("second_show");
  if (time.innerText == 0) {
    alert("Order timeout!");
    window.location.href='recharge';
    clearTimeout(id);
  } else {
    var re = /[\u4000-\uFFFF]/g;
    time.innerText = parseFloat(time.innerText.replace(re, "") - 1);
  }
}
var id = window.setInterval("countDown()", 1000);

function copyBtn(objID) {
  var txt = document.getElementById(objID).innerHTML;
  if (txt == null || txt == "") {
    alert("Copy content is empty");
    return false;
  }
  document.getElementById("content_span").innerHTML = txt;
  const range = document.createRange();
  range.selectNode(document.getElementById("content_span"));

  const selection = window.getSelection();
  if (selection.rangeCount > 0) selection.removeAllRanges();
  selection.addRange(range);
  document.execCommand("copy");
  document.getElementById("error").innerHTML = "copy success!";
  document.getElementById("error").style.display = "block";
  setTimeout(function error() {
    document.getElementById("error").innerHTML = "";
    document.getElementById("error").style.display = "none";
  }, 2000);

  // alert(document.getElementById("content_span").innerHTML + " copy success！");
}
