function validateAmount() {
  var amountInput = document.getElementById("amount");
  var amount = parseInt(amountInput.value);
  var errorDiv = document.getElementById("amount-error");
  var minRecharge = document.getElementById("minRecharge");

  if (isNaN(amount) || amount < minRecharge.value) {
    errorDiv.textContent = "Minimum amount: Rs " + minRecharge.value;
    errorDiv.style.color = "red";
    return false;
  } else {
    errorDiv.textContent = "";
    return true;
  }
}

function showPopup() {
  var errorDiv = document.getElementById("amount-error");
  errorDiv.textContent = "";
  document.getElementById("popupForm").style.display = "flex";
}

function hidePopup() {
  document.getElementById("popupForm").style.display = "none";
}
window.addEventListener("click", function (event) {
  var popup = document.getElementById("popupForm");
  if (event.target == popup) {
    popup.style.display = "none";
  }
});
