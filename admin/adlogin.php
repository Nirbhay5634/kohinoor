<?php
session_start();

function validateMobileNumber($input) {
    return preg_match('/^\d{10}$/', $input);
}

function sanitizeInput($input) {
    return htmlspecialchars($input, ENT_QUOTES);
}

if (isset($_SESSION['adusername'])) {
    header("location: admin");
    exit;
}
?>
<html lang="en" style="font-size: 37.5px;">

<head>
    <?php include("header.php");?>
    <link href="css/app.46643acf.css" rel="preload" as="style">
    <link href="css/chunk-vendors.cf06751b.css" rel="preload" as="style">
    <link href="css/chunk-vendors.cf06751b.css" rel="stylesheet">
    <link href="css/app.46643acf.css" rel="stylesheet">
</head>

<body style="font-size: 36px;">
    <div data-v-309ccc10="" class="recharge">
        <nav data-v-309ccc10="" class="top_nav">
            <div data-v-309ccc10="" class="left"><a href="index"><img data-v-309ccc10=""
                        src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADIAAAAyCAYAAAAeP4ixAAAByUlEQVRoQ+3ZwSsFURTH8e/5N5SV/0AWtpbIggUlKSlJJCUpSUlJSlKSkpKUbEjK1tbCkhV/hT/gp1deXa95z8y8md4905v1vXfO5515M+feY1Tksoo46EJiy2Q3I60yImkHGAZ6gTszWys7g4VnRNI2sNsQ+JCZvZSJKRQiaQvYSwh43MweXEAkbQL7CcG+mdlAmYja2oVkRNIGcJAQ7DswaWYf0UMkrQOHnUS0nRFJtbfRUacRbUEkrQLHMSByQyStACexIHJBJC0BpzEhMkMkLQJnsSEyQSQtAOcxIlJDJM0DF7EiUkEkzQGXMSP+hUiaBa5iR7SESJoBrj0gmkIkTQM3XhCJEElTwG0TxHLZxV+a9ZP2Nn+qX0mjwFOaxTo85hvoN7PPehyNkEdgrMNBpr39s5mNVB5SjUerlqZK/Nnrz1slXr8Bxv8HMcD4L1ECjP+iMcD4L+MDjP+NVYDxv9UNMP4PHwKM/+OgAOP/gC7A+D8yDTD+D7EDjP+2QoDx3+gJMP5bbwEmqRk6aGavafewecYV0nprvPFve7pW0vQA92Y2kSe4LHNKgQTZ6TOzrywB5R1bKiRvUHnmdSF5frUy51QmIz+4oeozWPEp9QAAAABJRU5ErkJggg=="
                        alt=""></a><span data-v-309ccc10="">Admin Login</span></div>
        </nav>
        <div data-v-309ccc10="" class="recharge_box">
            <form action="av" id="adminverify" method="POST" class="form-signup">
                <div data-v-309ccc10="" class="input_box">
                    <img data-v-309ccc10="" src="data:image/png;base64,..." alt="">
                    <input data-v-309ccc10="" type="text" id="Username" name="username" placeholder="Mobile Number"
                        value="<?php echo sanitizeInput($_POST['username'] ?? ''); ?>">
                    <span data-v-309ccc10="" class="tips_span">Mobile number is required</span>
                </div>
                <div data-v-309ccc10="" class="input_box">
                    <img data-v-309ccc10="" src="data:image/png;base64,..." alt="">
                    <input data-v-309ccc10="" type="password" id="inputPassword" name="password" placeholder="Password">
                    <span data-v-309ccc10="" class="tips_span">Password is required</span>
                </div>
                <div data-v-309ccc10="" class="input_box_btn">
                    <button data-v-309ccc10="" class="login_btn ripple">Login</button>
                </div>
            </form>
            <div data-v-309ccc10="" class="input_box_btn">
                <div data-v-309ccc10="" class="two_btn"></div>
            </div>
        </div>

        <div data-v-74fec56a="" data-v-309ccc10="" id="loading" class="loading" style="display: none;">
            <div data-v-74fec56a="" class="v-dialog v-dialog--persistent" style="width: 300px; display: block;">
                <div data-v-74fec56a="" data-v-5197ff2a="" class="v-card v-sheet theme--dark teal">
                    <div data-v-74fec56a="" data-v-5197ff2a="" class="v-card__text"><span
                            data-v-74fec56a="">Loading</span>
                        <div data-v-74fec56a="" data-v-5197ff2a="" role="progressbar" aria-valuemin="0"
                            aria-valuemax="100" class="v-progress-linear mb-0" style="height: 7px;">
                            <div data-v-74fec56a="" class="v-progress-linear__background white"
                                style="height: 7px; opacity: 0.3; width: 100%;"></div>
                            <div data-v-74fec56a="" class="v-progress-linear__bar">
                                <div data-v-74fec56a=""
                                    class="v-progress-linear__bar__indeterminate v-progress-linear__bar__indeterminate--active">
                                    <div data-v-74fec56a="" class="v-progress-linear__bar__indeterminate long white">
                                    </div>
                                    <div data-v-74fec56a="" class="v-progress-linear__bar__indeterminate short white">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
    if (navigator.onLine) {
        document.getElementById("loading").style.display = "none";

    } else {
        document.getElementById("loading").style.display = "";
    }
    document.getElementById('adminverify').addEventListener('submit', function(event) {
        var mobileNumber = document.getElementById('Username').value;
        if (!validateMobileNumber(mobileNumber)) {
            alert('Invalid mobile number. Please enter a valid 10-digit mobile number.');
            event.preventDefault();
        }
    });

    if (navigator.onLine) {
        document.getElementById("loading").style.display = "none";
    } else {
        document.getElementById("loading").style.display = "";
    }
    </script>

</body>

</html>