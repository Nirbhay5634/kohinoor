document.addEventListener("DOMContentLoaded", function () {
  const passwordField = document.getElementById("password");
  const togglePasswordIcon = document.getElementById("togglePassword");
  const changePasswordLink = document.getElementById("changePassword");
  const cancelChangePasswordButton =
    document.getElementById("cancelChangePass");
  const passwordBox = document.getElementById("passwordBox");
  const editAccountDetailsLink = document.getElementById("editAccountDetails");
  const accountBox = document.getElementById("accountBox");
  const accountChangeSection = document.getElementById("account_change");
  const accountNumberField = document.getElementById("accountNumber");
  const ifscCodeField = document.getElementById("ifscCode");
  const changeAccountButton = document.getElementById("changeAccount");
  const cancelChangeAccButton = document.getElementById("cancelChangeAcc");
  const userID = document.getElementById("userID").value;

  const oldPasswordField = document.getElementById("oldPassword");
  const newPasswordField = document.getElementById("newPassword");

  var initialAccountNumberValue;
  var initialIFSCValue;

  // Toggle password visibility
  togglePasswordIcon.addEventListener("click", function () {
    const type =
      passwordField.getAttribute("type") === "password" ? "text" : "password";
    passwordField.setAttribute("type", type);
    togglePasswordIcon.src =
      type === "password"
        ? "assets/icons/openEye.png"
        : "assets/icons/closeEye.png";
  });

  // Show password change fields
  changePasswordLink.addEventListener("click", function () {
    passwordBox.style.display = "block";
    document.getElementById("oldPassword").focus();
    document.getElementById("oldPassword").placeholder =
      "Enter current password";
    document.getElementById("newPassword").placeholder = "Enter new password";
    accountBox.style.display = "none";
    accountNumberField.disabled = true;
    ifscCodeField.disabled = true;
    accountNumberField.placeholder = "";
    ifscCodeField.placeholder = "";
  });

  // Hide password change fields
  cancelChangePasswordButton.addEventListener("click", function () {
    passwordBox.style.display = "none";
    oldPasswordField.value = "";
    newPasswordField.value = "";
  });

  // Hide account change fields
  cancelChangeAccButton.addEventListener("click", function () {
    accountBox.style.display = "none";
    accountNumberField.disabled = true;
    ifscCodeField.disabled = true;
    accountNumberField.value = initialAccountNumberValue;
    ifscCodeField.value = initialIFSCValue;
  });

  // Show account change fields
  editAccountDetailsLink.addEventListener("click", function () {
    passwordBox.style.display = "none";
    accountBox.style.display = "block";
    accountNumberField.disabled = false;
    initialAccountNumberValue = accountNumberField.value;
    initialIFSCValue = ifscCodeField.value;
    accountNumberField.value = "";
    accountNumberField.placeholder = "XXXX XXXX XXXX";
    accountNumberField.focus();
    ifscCodeField.disabled = false;
    ifscCodeField.value = "";
    ifscCodeField.placeholder = "XXXXXXXXXX";
  });

  // Add validation for changing account details
  changeAccountButton.addEventListener("click", function () {
    const accountNumber = accountNumberField.value.trim();
    const ifscCode = ifscCodeField.value.trim();
    const accountNumberRegex = /^\d{9,18}$/;
    const ifscCodeRegex = /^[A-Z]{4}0[A-Z0-9]{6}$/;

    if (accountNumber == "") {
      document.getElementById("toast__text").innerHTML =
        "Account no is required";
      document.getElementById("van-toast").style.display = "flex";
      setTimeout(function () {
        document.getElementById("van-toast").style.display = "none";
      }, 3000);
    } else if (!accountNumberRegex.test(accountNumber)) {
      document.getElementById("toast__text").innerHTML = "Invalid Account no!";
      document.getElementById("van-toast").style.display = "flex";
      setTimeout(function () {
        document.getElementById("van-toast").style.display = "none";
      }, 3000);
    } else if (ifscCode == "") {
      document.getElementById("toast__text").innerHTML =
        "IFSC code is required";
      document.getElementById("van-toast").style.display = "flex";
      setTimeout(function () {
        document.getElementById("van-toast").style.display = "none";
      }, 3000);
    } else if (!ifscCodeRegex.test(ifscCode)) {
      document.getElementById("toast__text").innerHTML = "Invalid Ifsc code";
      document.getElementById("van-toast").style.display = "flex";
      setTimeout(function () {
        document.getElementById("van-toast").style.display = "none";
      }, 3000);
    } else {
      var action = "update_bank";
      $.ajax({
        type: "POST",
        url: "globalApi.php",
        data: {
          userID: userID,
          accountNumber: accountNumber,
          ifscCode: ifscCode,
          action: action,
        },

        success: function (html) {
          var arr = html.split("~");

          if (arr[0] == 1) {
            document.getElementById("toast__text").innerHTML = "success";
            document.getElementById("van-toast").style.display = "flex";
            setTimeout(function () {
              document.getElementById("van-toast").style.display = "none";
              location.href = "profile";
            }, 3000);
          } else {
            document.getElementById("toast__text").innerHTML =
              "something went wrong!!";
            document.getElementById("van-toast").style.display = "flex";
            setTimeout(function () {
              document.getElementById("van-toast").style.display = "none";
              location.href = "profile";
            }, 3000);
          }
        },
      });
      accountNumberField.disabled = true;
      ifscCodeField.disabled = true;
      accountNumberField.placeholder = "";
      ifscCodeField.placeholder = "";
      accountBox.style.display = "none";
    }
  });

  finalChangePassword.addEventListener("click", function () {
    const currentPassword = document.getElementById("password").value.trim();
    const oldPassword = oldPasswordField.value.trim();
    const newPassword = newPasswordField.value.trim();

    if (oldPassword == "") {
      document.getElementById("toast__text").innerHTML = "Password is required";
      document.getElementById("van-toast").style.display = "flex";
      setTimeout(function () {
        document.getElementById("van-toast").style.display = "none";
      }, 3000);
    } else if (oldPassword != currentPassword) {
      document.getElementById("toast__text").innerHTML =
        "Password doesn't macth";
      document.getElementById("van-toast").style.display = "flex";
      setTimeout(function () {
        document.getElementById("van-toast").style.display = "none";
      }, 3000);
    } else if (newPassword == "") {
      document.getElementById("toast__text").innerHTML = "Password is required";
      document.getElementById("van-toast").style.display = "flex";
      setTimeout(function () {
        document.getElementById("van-toast").style.display = "none";
      }, 3000);
    } else if (newPassword < 5) {
      document.getElementById("toast__text").innerHTML =
        "Password must be 5 characters";
      document.getElementById("van-toast").style.display = "flex";
      setTimeout(function () {
        document.getElementById("van-toast").style.display = "none";
      }, 3000);
    } else if (newPassword == currentPassword) {
      document.getElementById("toast__text").innerHTML = "Password are same";
      document.getElementById("van-toast").style.display = "flex";
      setTimeout(function () {
        document.getElementById("van-toast").style.display = "none";
      }, 3000);
    } else {
      var action = "reset_password";
      $.ajax({
        type: "POST",
        url: "globalApi.php",
        data: {
          userID: userID,
          oldPassword: oldPassword,
          newPassword: newPassword,
          action: action,
        },

        success: function (html) {
          var arr = html.split("~");

          if (arr[0] == 1) {
            document.getElementById("toast__text").innerHTML = "success";
            document.getElementById("van-toast").style.display = "flex";
            setTimeout(function () {
              document.getElementById("van-toast").style.display = "none";
              location.href = "profile";
            }, 3000);
          } else if (arr[0] == 0) {
            document.getElementById("toast__text").innerHTML =
              "something went wrong!!";
            document.getElementById("van-toast").style.display = "flex";
            setTimeout(function () {
              document.getElementById("van-toast").style.display = "none";
              location.href = "profile";
            }, 3000);
          } else if (arr[0] == 2) {
            document.getElementById("toast__text").innerHTML =
              "Account Blocked!!";
            document.getElementById("van-toast").style.display = "flex";
            setTimeout(function () {
              document.getElementById("van-toast").style.display = "none";
              location.href = "profile";
            }, 3000);
          } else if (arr[0] == 3) {
            document.getElementById("toast__text").innerHTML =
              "Invalid username or password!!";
            document.getElementById("van-toast").style.display = "flex";
            setTimeout(function () {
              document.getElementById("van-toast").style.display = "none";
              location.href = "profile";
            }, 3000);
          }
        },
      });
      oldPasswordField.disabled = true;
      newPasswordField.disabled = true;
      oldPasswordField.value = "";
      newPasswordField.value = "";
      passwordBox.style.display = "none";
    }
  });
});
