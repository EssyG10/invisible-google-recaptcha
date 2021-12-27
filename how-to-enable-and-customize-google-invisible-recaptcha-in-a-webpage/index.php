<?php
require_once "config.php";
if (isset($_POST['submit'])) {
    if (isset($_POST['captcha-response']) && ! empty($_POST['captcha-response'])) {
        $data = array(
            'secret' => SECRET_KEY,
            'response' => $_POST['captcha-response']
        );
        $verify = curl_init();
        curl_setopt($verify, CURLOPT_URL, "https://www.google.com/recaptcha/api/siteverify");
        curl_setopt($verify, CURLOPT_POST, true);
        curl_setopt($verify, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($verify, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($verify, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($verify);
        if ($response == true) {
            $result = '<div class="success">Your request has been successfully submitted</div>';
            echo $result;
        } else {
            $result = '<div class="error">Verification failed, please try again</div>';
            echo $result;
        }
    } else {
        $result = '<div class="error">Verification failed, please try again</div>';
        echo $result;
    }
}
?>
<html>
<head>
<title>How to Enable and Customize Google Invisible reCAPTCHA in a Webpage</title>
<style>
body {
	font-family: Arial;
	color: #212121;
	font-size: 0.9em;
}

.form-row {
	margin-bottom: 20px;
}

input {
	padding: 10px;
	width: 100%;
	border: #E0E0E0 1px solid;
	border-radius: 0px;
     margin-top: 3px;
}

form {
	width: 350px;
	margin: 0 auto;
	border: #E0E0E0 1px solid;
	padding: 20px;
	border-radius: 3px;
}

input[type="submit"] {
	padding: 10px 40px;
	background: #4CAF50;
	border: #45a049 1px solid;
	color: #FFF;
	cursor: pointer;
	border-radius: 0px;
}

span {
	color: #da5454;
	margin-left: 5px;
}
.error {
    color: #483333;
    padding: 10px;
    background: #ffbcbc;
    border: #efb0b0 1px solid;
    border-radius: 3px;
    margin: 0 auto;
    margin-bottom: 20px;
    width: 350px;
}

.success {
    color: #483333;
    padding: 10px 20px;
    background: #cff9b5;
    border: #bce4a3 1px solid;
    border-radius: 3px;
    margin: 0 auto;
    margin-bottom: 20px;
    width: 350px;
}
</style>
</head>
<body>
	<form action="" method="post"
		onsubmit="return validateContact();">
		<div class="form-row">
			<label>Name:</label><span id="userName-info" class="info"></span><br>
			<input type="text" name="name" id="name">
		</div>

		<div class="form-row">
			<label>Email:</label> <span id="userEmail-info" class="info"></span><br>
			<input type="text" name="email" id="email">
		</div>
		<!-- Google reCAPTCHA widget -->
		<div class="form-row">
			<div class="g-recaptcha"
				data-sitekey="<?php echo SITE_KEY; ?>"
				data-badge="inline" data-size="invisible"
				data-callback="setResponse"></div>
			<input type="hidden" id="captcha-response" name="captcha-response" />
		</div>
		</div>
		<div class="button-row">
			<input type="submit" name="submit" value="SUBMIT">
		</div>
	</form>
	<script
		src="https://www.google.com/recaptcha/api.js?onload=onloadCallback"
		async defer></script>
	<script
		src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
	<script>
var onloadCallback = function() {
    grecaptcha.execute();
};

function setResponse(response) { 
    document.getElementById('captcha-response').value = response; 
}
function validateContact() {
    var valid = true;
        $(".info").html('');
    if(!$("#name").val()) {
        $("#userName-info").html("(required)");
                 $("#name").css('border-color','#da5454');
        valid = false;
    }
    if(!$("#email").val()) {
        $("#userEmail-info").html("(required)");
                 $("#email").css('border-color','#da5454');
        valid = false;
    }
    if(!$("#email").val().match(/^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/)) {
        $("#userEmail-info").html("(invalid)");
                 $("#email").css('border-color','#da5454');
        valid = false;
    }
    return valid;
}
</script>
</body>
</html>