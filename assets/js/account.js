
$(document).ready(function () {


	//=====================Register Script================================================================

	$("#Register").on('submit', (function (e) {
		e.preventDefault();
		var mobile = $('input#mobile').val();
		var otp = $('input#otp').val();
		var email = $('input#email').val();
		var password = $('input#password').val();
		var rcode = $('input#rcode').val();
		var action = $('input#action').val();
		var checkclick = document.getElementById("reg_otp");
		

		if ((mobile) == "") {
			document.getElementById("text").innerHTML="Mobile number is required";
            document.getElementById("msg1").style.display="block";
            setTimeout(function(){
                document.getElementById("msg1").style.display="none";
            }, 3000);
		}
		else if (mobile.length < 10) {
			document.getElementById("text").innerHTML="Mobile number is required";
            document.getElementById("msg1").style.display="block";
            setTimeout(function(){
                document.getElementById("msg1").style.display="none";
            }, 3000);
		}
		else if (otp== "") {
			document.getElementById("text").innerHTML="Verification code is required";
            document.getElementById("msg1").style.display="block";
            setTimeout(function(){
                document.getElementById("msg1").style.display="none";
            }, 3000);
		}
		else if(checkclick.clicked==false){
           document.getElementById("text").innerHTML="Verification code is required";
            document.getElementById("msg1").style.display="block";
            setTimeout(function(){
                document.getElementById("msg1").style.display="none";
            }, 3000);
        }

		else if ((password) == "") {
			document.getElementById("text").innerHTML="Password is required";
            document.getElementById("msg1").style.display="block";
            setTimeout(function(){
                document.getElementById("msg1").style.display="none";
            }, 3000);
		}
		else if (password.length < 5) {
			document.getElementById("text").innerHTML="Password must be 5 characters";
            document.getElementById("msg1").style.display="block";
            setTimeout(function(){
                document.getElementById("msg1").style.display="none";
            }, 3000);
		}
		else if ((rcode) == "") {
			document.getElementById("text").innerHTML="Recommendation code is required";
            document.getElementById("msg1").style.display="block";
            setTimeout(function(){
                document.getElementById("msg1").style.display="none";
            }, 3000);
		}
		else {
		    
		    //================================================match otp===================================================

               if ((otp) == "") {
        			document.getElementById("text").innerHTML="Please fill OTP";
                    document.getElementById("msg1").style.display="block";
                    setTimeout(function(){
                        document.getElementById("msg1").style.display="none";
                    }, 1000);
        		}
        		else if ((otp.length) < 6) {
        			document.getElementById("text").innerHTML="OTP Code Error. Must 6 characters";
                    document.getElementById("msg1").style.display="block";
                    setTimeout(function(){
                        document.getElementById("msg1").style.display="none";
                    }, 1000);
        		}
        		else{
        			$.ajax({
        				type: "POST",
        				url: "veryfynumberNow.php",
        				data: "otp="+otp + "&type="+"otpval",
        				
        				success: function (html) { //alert(html);
        					var arr = html.split('~');
        	
        					if (arr[0] == 1) {
        						
                                var mobile = document.getElementById("mobile").value;
                        		var email = document.getElementById("email").value;
                        		var password = document.getElementById("password").value;
                        		var rcode = document.getElementById("rcode").value;
                        		var action = document.getElementById("action").value;
                                $.ajax({
                        			type: "POST",
                        			url: "registerNow.php",
                        			data: {mobile:mobile,email:email,password:password,rcode:rcode,action:action},
                        
                        			success: function (html) {
                        				var arr = html.split('~');
                        				console.log(arr);
                                            
                        				if (arr[0] == 1) {
                        					document.getElementById("text").innerHTML="success";
                        					window.location.href='mine.php?data=2';
                                            document.getElementById("msg1").style.display="block";
                                            setTimeout(function(){
                                                document.getElementById("msg1").style.display="none";
                                            }, 3000);
                        				}
                        				else if (arr[0] == 2) {
                        					document.getElementById("text").innerHTML="Mobile No already registered!";
                                            document.getElementById("msg1").style.display="block";
                                            setTimeout(function(){
                                                document.getElementById("msg1").style.display="none";
                                            }, 3000);
                        				}
                        				else if (arr[0] == 3) {
                        					document.getElementById("text").innerHTML="Recommendation code error!";
                                            document.getElementById("msg1").style.display="block";
                                            setTimeout(function(){
                                                document.getElementById("msg1").style.display="none";
                                            }, 3000);
                        				}
                        				else if (arr[0] == 4) {
                        					document.getElementById("text").innerHTML="please verify mobile no!";
                                            document.getElementById("msg1").style.display="block";
                                            setTimeout(function(){
                                                document.getElementById("msg1").style.display="none";
                                            }, 3000);
                        				}
                        				else if (arr[0] == 0) {
                        					document.getElementById("text").innerHTML="something went wrong!";
                                            document.getElementById("msg1").style.display="block";
                                            setTimeout(function(){
                                                document.getElementById("msg1").style.display="none";
                                            }, 3000);
                        				}
                        
                        			}
                        		});
        					}
        					else if (arr[0] == 0) {
        					    document.getElementById("text").innerHTML="OTP Code Error";
                                document.getElementById("msg1").style.display="block";
                                setTimeout(function(){
                                    document.getElementById("msg1").style.display="none";
                                }, 1000);
            				}
        	
        				}
        			});
        		}
        		
        	 

		}

	}));
	
	
	$("#Envelope").on('submit', (function (e) {
		e.preventDefault();
		var code = $('input#code').val();
        var login_mobile = $('input#login_mobile').val();
		if ((code) == "") {
			$("input#code").focus();
			$('#code').addClass('borderline');
			return false;
		}
		if ((login_mobile) == "") {
			$("input#login_mobile").focus();
			$('#login_mobile').addClass('borderline');
			return false;
		}

		$.ajax({
			type: "POST",
			url: "wp-envelope.php",
			data: new FormData(this),
			contentType: false,
			cache: false,
			processData: false,

			success: function (html) { //alert(html);
				var arr = html.split('~');

				if (arr[0] == 1) {
					$("#Envelope")[0].reset();
					//window.location.href = "successvisitorNow";
					$('#registerthanksPopup').modal({ backdrop: 'static', keyboard: false })
					$('#registerthanksPopup').modal('show');
				}
				else if (arr[0] == 2) {
				    $("#Envelope")[0].reset();
					document.getElementById('regtoast').innerHTML = ('<font size="2" style="color:#f00;">Successfully Redeemed, Check Out Wallet Balance !</font>');
					$('#registertoast').modal({ backdrop: 'static', keyboard: false })
					$('#registertoast').modal('show');
				}
				else if (arr[0] == 3) {
				    $("#Envelope")[0].reset();
					document.getElementById('regtoast').innerHTML = ('<font size="2" style="color:#f00;">Wrong redeemed code enter !</font>');
					$('#registertoast').modal({ backdrop: 'static', keyboard: false })
					$('#registertoast').modal('show');
				}
				else if (arr[0] == 4) {
				    $("#Envelope")[0].reset();
					document.getElementById('regtoast').innerHTML = ('<font size="2" style="color:#f00;">Expired Red Envelope Code. !</font>');
					$('#registertoast').modal({ backdrop: 'static', keyboard: false })
					$('#registertoast').modal('show');
				}
				else if (arr[0] == 0) {
				    $("#Envelope")[0].reset();
					document.getElementById('regtoast').innerHTML = ('<font size="2" style="color:#f00;">Some Technical error !</font>');
					$('#registertoast').modal({ backdrop: 'static', keyboard: false })
					$('#registertoast').modal('show');
				}

			}
		});


	}));
	
	//=====================Login Script================================================================

	$("#loginForm").on('submit', (function (e) {
		e.preventDefault();

		var loginmobile = $('input#login_mobile').val();
		var loginpassword = $('input#login_password').val();

		if ((loginmobile) == "") {
			document.getElementById("text").innerHTML="Mobile number is required";
            document.getElementById("msg1").style.display="block";
            setTimeout(function(){
                document.getElementById("msg1").style.display="none";
            }, 3000);
		}

		else if ((loginpassword) == "") {
			document.getElementById("text").innerHTML="Password is required";
            document.getElementById("msg1").style.display="block";
            setTimeout(function(){
                document.getElementById("msg1").style.display="none";
            }, 3000);
		}
		
		else{

    		$.ajax({
    			type: "POST",
    			url: "loginNow.php",
    			data: new FormData(this),
    			contentType: false,
    			cache: false,
    			processData: false,
    
    			success: function (html) {
    				var arr = html.split('~');
    
    				if (arr[0] == 1) {
    				    document.getElementById("text").innerHTML="success";
                        document.getElementById("msg1").style.display="block";
                        setTimeout(function(){
                            document.getElementById("msg1").style.display="none";
                        }, 3000);
    					window.location.href = "mine.php";
    				}
    				else if (arr[0] == 0) {
    					document.getElementById("text").innerHTML="Account or password error, please login in 10 seconds";
                        document.getElementById("msg1").style.display="block";
                        setTimeout(function(){
                            document.getElementById("msg1").style.display="none";
                        }, 3000);
    				}
    
    			}
    		});
    		
		}


	}));
	
	
	$("#forgotform").on('submit', (function (e) {
		e.preventDefault();
		var fmobile = $('input#fmobile').val();
		var npassword = $('input#npassword').val();
		var otp = $('input#otp').val();
		var action =  'forgotpass';

		if ((fmobile) == "") {
			document.getElementById("text").innerHTML="Mobile number is required";
            document.getElementById("msg1").style.display="block";
            setTimeout(function(){
                document.getElementById("msg1").style.display="none";
            }, 3000);
		}
		else if (fmobile.length < 10) {
			document.getElementById("text").innerHTML="Mobile number is required";
            document.getElementById("msg1").style.display="block";
            setTimeout(function(){
                document.getElementById("msg1").style.display="none";
            }, 3000);
		}
        else if (otp== "") {
			document.getElementById("text").innerHTML="Verification code is required";
            document.getElementById("msg1").style.display="block";
            setTimeout(function(){
                document.getElementById("msg1").style.display="none";
            }, 3000);
		}
		else if ((npassword) == "") {
			document.getElementById("text").innerHTML="Password is required";
            document.getElementById("msg1").style.display="block";
            setTimeout(function(){
                document.getElementById("msg1").style.display="none";
            }, 3000);
		}
		else if (npassword.length < 5) {
			document.getElementById("text").innerHTML="Password must be 5 characters";
            document.getElementById("msg1").style.display="block";
            setTimeout(function(){
                document.getElementById("msg1").style.display="none";
            }, 3000);
		}

		else{
		    
		    if ((otp) == "") {
        			document.getElementById("text").innerHTML="Please fill OTP";
                    document.getElementById("msg1").style.display="block";
                    setTimeout(function(){
                        document.getElementById("msg1").style.display="none";
                    }, 1000);
        		}
        		else if ((otp.length) < 6) {
        			document.getElementById("text").innerHTML="OTP Code Error. Must 6 characters";
                    document.getElementById("msg1").style.display="block";
                    setTimeout(function(){
                        document.getElementById("msg1").style.display="none";
                    }, 1000);
        		}
        		else{
        			$.ajax({
        				type: "POST",
        				url: "forgotpassotpverification.php",
        				data: "otp="+otp + "&type="+"otpval",
        				
        				success: function (html) { //alert(html);
        					var arr = html.split('~');
        	
        					if (arr[0] == 1) {
        						
                                var fmobile = document.getElementById("fmobile").value;
                        		var npassword = document.getElementById("npassword").value;
                        		var action = 'forgotpass';
                                $.ajax({
                        			type: "POST",
                        			url: "forgotNow.php",
                        			data: {fmobile:fmobile,npassword:npassword,action:action},
                        
                        			success: function (html) {
                        				var arr = html.split('~');
                        				console.log(arr);
                                            
                        				if (arr[0] == 1) {
                        					document.getElementById("text").innerHTML="success";
                        					window.location.href='mine.php';
                                            document.getElementById("msg1").style.display="block";
                                            setTimeout(function(){
                                                document.getElementById("msg1").style.display="none";
                                            }, 3000);
                        				}
                        				else if (arr[0] == 2) {
                        					document.getElementById("text").innerHTML="No account exist!";
                                            document.getElementById("msg1").style.display="block";
                                            setTimeout(function(){
                                                document.getElementById("msg1").style.display="none";
                                            }, 3000);
                        				}
                        				else if (arr[0] == 3) {
                        					document.getElementById("text").innerHTML="Same Password error!";
                                            document.getElementById("msg1").style.display="block";
                                            setTimeout(function(){
                                                document.getElementById("msg1").style.display="none";
                                            }, 3000);
                        				}
                        				else if (arr[0] == 4) {
                        					document.getElementById("text").innerHTML="please verify mobile no!";
                                            document.getElementById("msg1").style.display="block";
                                            setTimeout(function(){
                                                document.getElementById("msg1").style.display="none";
                                            }, 3000);
                        				}
                        				else if (arr[0] == 0) {
                        					document.getElementById("text").innerHTML="something went wrong!";
                                            document.getElementById("msg1").style.display="block";
                                            setTimeout(function(){
                                                document.getElementById("msg1").style.display="none";
                                            }, 3000);
                        				}
                        
                        			}
                        		});
        					}
        					else if (arr[0] == 0) {
        					    document.getElementById("text").innerHTML="OTP Code Error";
                                document.getElementById("msg1").style.display="block";
                                setTimeout(function(){
                                    document.getElementById("msg1").style.display="none";
                                }, 1000);
            				}
        	
        				}
        			});
        		}
		    
		}

	}));
	


});

function visible(){
    var currenttype = document.getElementById("login_password");
    if(currenttype.type==="password"){
        currenttype.type="text";
        document.getElementById("passvisicon").src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACUAAAAeCAYAAACrI9dtAAAABHNCSVQICAgIfAhkiAAAA5xJREFUWEfFV4tx2kAQjWggpALLFQRXED4FBFcQqCC4AkMFgQqMKwgUACgVBFcQSiANQN4772n2VidxjGcczTBId3urd2/f7q2yD+rabDajLMueMFTg/77X6x31/HvdZ/pF2+22wPMXGdsDGHC9P7AAlGLKY/0vwAJQRJIKbLfbtU+n0xPYzLGsI7s44P9wPp8PrVZrj/s1mObYVVcFVCowgJ8C0GPC28j2HOCeE2ydSRRUCjAw1QFTTIiPiS87wPYB4FaX7GtBJQJr004ng4DtAEAXYRxa0BhbIbTjpgRqBNUAjE6pmcZLdDeEEUN9o4zJGktO1MdFUDXAjlIunFNVSijyAkwUWkMCjsC+K2CBD727WPZ5ARf9fr/njeG4Cw2tVDicU8wfAeRPhDLqjRoq2ajzYRlrrFNwemecWnE7YAA1AahvEWAVNiIJQptbrbESFHcB5zvleA2mqIfgqnHKyr/HXA42R1gwMYwGL434CIq0A8WYA9Bv3OaC4IXZU5chTcDEn2X0GRsk2PKyJOD9i8FgQMZf6xQK4dyLEJN/IdSOrcQC5JGVGnOzBGAB8/D/yW4S7yWjPzxSL5fMIpZUrRQ4ZBjHvrqdvB7UxSVgWEORf5Y1LAExvwXmyyYAjN5lpjP4hcGu1RGftZ0HVROqUtwmAjOEZ2p9iw6pKXcyIFLjDAvppBzAwuU1oOqAwfkD5to+PHyG73mNb+rZHeqwmxGUPlgr6emdGKYqoYidhQQCUO5l+J/EEgfrhrD7qXR1S02xBSF97hjg2YQd3dsd6VBgrpJNwhizmBpxOvLhqGNfsp6F152hPgN9SQjQMq7WEZmQsuFeVpcQ8qIkYGCfdbErgJj1OdksiycMlpgsq7Kt5lxobBjqKZwsLKspwGwzqZNHV3RLfeyICEItYHgIsx05Qga51LHFJWC6FFHcOjODs0/0xbbCN24xYDlBaN1YplQda9QYJUE9seZpH5UuIZZFkjllmAQ8jwR9xnlhByfCJcbshpxeY4MxYLCrtCJcK+1Ijlv++MHAXuqg/V4LrLbJizmSLGFPtUTlX8c25MdYqRHmG9i+MKNqgC2hpXEl/E2OOdfw1cKvZ9a3QA8UuxTM8rNLMtkDox79WcfaVAGW1A7LrqdwFmvkLu2LNS3oEGz5sXUxCZQOCZjgF8oIY2XVjqFiC0QW8eM3X8Am7TWwN4Gy4sUzmzmX1n6OQsf9MeVrh/0Ube3p8Q/B6g33LHqkSAAAAABJRU5ErkJggg==";
    }
    else{
        currenttype.type="password";
        document.getElementById("passvisicon").src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACUAAAAcCAYAAADm63ZmAAAABHNCSVQICAgIfAhkiAAAA3dJREFUWEedV4tx2kAQtWjAdBBSQXAF4VOAcQWBCsAVRK7ApIJABYYCALkCkwoid0AagLx3s6s5jtuTQDMemdPe7tu3n9vL7m54ttvtY5Zl3dPp1MP2Lv7anpo91stWq1Vgbd3v98trTWRNN+x2u87xeJwCzDgAUadijz1zgFvWCer3WlAAQxam8D5vqtSQKwFuAnBkMPkkQQEQQ/QGDR1fC9b+wcAK7wJhYnj2MHYgm5QFoz18Z2i/h9axZz4cDp9TqExQm81mDMW/AzCf+J1D6aLOW34nSGH4RyDPkMKP/iGmJwrKAPQCMDeFUMDREZ85E9gFqBAQPP1EiEbwat+EnZQMdOdg6KcnEwV2BgoejSSHdN8f5oZFM3NOKpK5xII4MNfwXlp7IlG4AFaBEoo/RDlBJQFB+RwApgYzrLQni91INBZIjYnqqkChIRIQG+Edqwsh61qNzwfkVSKB+BVH1pjM0bBHgE20gByoMNbiJcNw8YDRHoDs5MOazdQPFVMAIV1g/R4yxWAw6Ft5BiKY/FqZdOKBRGQStr+6EQZ/AfEsoYhgH6UAyOZFWcPJGQy8UoewVRgOtuEAc+qLfF/CiXHmo00ZUqWQP0mIky0CwOj5PXQm5cLiwp6vBOWMiFdMzmjYQlApBigLvWSHfWkN70cW8yLLvPumzmbwiAnq6KsLnShQpp4R5rllTPXW6QyrHvIT5pSfuMwBJpvZKD1jK4B6MnKFx4vLUxpJHUvQ9wabjkmmD2Q7rvo8qvlzD7ofEgxUXdkyqPqktXQSzfesWWvVO1AyDbBPuSdFOUcZv2KgKGfe4K/EPuYQf2u/M5M80qyr3Kuap1/GdbTL8VJIL7JIdeVthLctvc5v1hWjZ2df0MyS+WCNJcwLsmXlEZn2ARF0mMfhgcwNBeRcecqGHDnxYtEhk6nzGM8hVSTiCIdGlY86fjG6iCdnwAB0hbOQo2x0KLMA++vSJDk0VpcMq1CiQ14MGFkAzbNrLgAEJReOVy17BZpqFeY4LMDYHMNRls2W68nrE69hMDzige0zJm2Ch7h5cjS5zfinfhipEgtsBbzn8d0TAX2H8u8yVXCf+dSCkhCwN+X4n5cJjiRXPXLQM/TJc1WVNgKlwtI4CYwhqSo0hlCHP8gumtz1fB1XgQqN89zEGlmsWgLCyHOzvOW6rvr/AyuCfuZkQ2aCAAAAAElFTkSuQmCC";
    }
}

	//=====================OTP Generation Script================================================================

function mobileveryfication() {
	var mobile = $('input#mobile').val();
	
	$.ajax({
		type: "Post",
		data: "mobile=" + mobile + "& type=" + "mobile",
		url: "veryfynumberNow.php",

		success: function (html) {
			//alert(html);
			var arr = html.split('~');
			if (arr[0] == 1) {
				//data = JSON.parse(arr[1])
				//alert(data.Status);
				$("#otpclose").click();
				$('#otploader').show()
				document.getElementById("reg_otp").style.backgroundColor ="#999999";
				document.getElementById("reg_otp").disabled=true;
				
				setTimeout(function(){
					$('#otploader').hide()
				
				    document.getElementById("text").innerHTML="OTP sent";
                    document.getElementById("msg1").style.display="block";
                    setTimeout(function(){
                        document.getElementById("msg1").style.display="none";
                    }, 3000);
				
				}, 2000);
				
				var countdownNum = 30;
                incTimer();
                
				function incTimer(){
                    setTimeout (function(){
                        if(countdownNum != 0){
                        countdownNum--;
                        document.getElementById('reg_otp').innerHTML = countdownNum + ' seconds';
                        incTimer();
                        } else {
                        document.getElementById("reg_otp").style.backgroundColor ="#F27B21";
                        document.getElementById("reg_otp").disabled= null;
                        document.getElementById('reg_otp').innerHTML ='OTP';
                        }
                    },1000);
                }
			}
			else if (arr[0] == 2) {
				document.getElementById("text").innerHTML="The mobile number has been registered, please enter the password to login!";
                document.getElementById("msg1").style.display="block";
                setTimeout(function(){
                    document.getElementById("msg1").style.display="none";
                }, 2000);
			}
			else if (arr[0] == 3) {
				document.getElementById("text").innerHTML="Phone Number is required!";
                document.getElementById("msg1").style.display="block";
                setTimeout(function(){
                    document.getElementById("msg1").style.display="none";
                }, 2000);
			}
			return false;
		},
		error: function (e) { }
	});

}



function forgotpassmobileveryfication() {
	var fmobile = $('input#fmobile').val();
	
	$.ajax({
		type: "Post",
		data: "fmobile=" + fmobile + "& type=" + "fmobile",
		url: "forgotpassotpverification.php",

		success: function (html) {
			//alert(html);
			var arr = html.split('~');
			if (arr[0] == 1) {
				//data = JSON.parse(arr[1])
				//alert(data.Status);
				$("#otpclose").click();
				$('#otploader').show()
				document.getElementById("reg_otp").style.backgroundColor ="#999999";
				document.getElementById("reg_otp").disabled=true;
				
				setTimeout(function(){
					$('#otploader').hide()
				
				    document.getElementById("text").innerHTML="OTP sent";
                    document.getElementById("msg1").style.display="block";
                    setTimeout(function(){
                        document.getElementById("msg1").style.display="none";
                    }, 3000);
				    
				}, 2000);
				
				
				var countdownNum = 30;
                incTimer();
                
				function incTimer(){
                    setTimeout (function(){
                        if(countdownNum != 0){
                        countdownNum--;
                        document.getElementById('reg_otp').innerHTML = countdownNum + ' seconds';
                        incTimer();
                        } else {
                        document.getElementById("reg_otp").style.backgroundColor ="#F27B21";
                        document.getElementById("reg_otp").disabled= null;
                        document.getElementById('reg_otp').innerHTML ='OTP';
                        }
                    },1000);
                }
				
                    
			}
			else if (arr[0] == 0) {
				document.getElementById("text").innerHTML="No account exist with this phone number!";
                document.getElementById("msg1").style.display="block";
                setTimeout(function(){
                    document.getElementById("msg1").style.display="none";
                }, 2000);
			}
			else if (arr[0] == 3) {
				document.getElementById("text").innerHTML="Phone Number is required!";
                document.getElementById("msg1").style.display="block";
                setTimeout(function(){
                    document.getElementById("msg1").style.display="none";
                }, 2000);
			}
			return false;
		},
		error: function (e) { }
	});

}

function openpop(id){
    document.getElementById(id).style.display="block";
}
function closepop(id){
    document.getElementById(id).style.display="none";
}