<!DOCTYPE html>
<!-- CuriouzMind Tech | The Web Agency -->
<!--[if lt IE 7 ]><html class="ie ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!-->
<html lang="en"> <!--<![endif]-->

	<head>

		<!-- Basic -->
		<meta charset="utf-8">
		<title>CuriouzMind Tech | The Web Agency</title>
		<meta name="author" content="DSA79">
		<meta name="norobots" content="noindex,nofollow">
		<meta name="keywords" content="web design, web development, graphic design, digital marketing, mobile app development, cms,
                                       		content management system, custom applications, software development,
                                       		app makers, brand identity, e-commerce">
		<meta name="description" content="CuriouzMind Tech - The Web Design & Development Agency">

		<!-- Mobile Specific Metas -->
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">			
		   
		<!-- Libs CSS -->
		<link href="css/style.css" rel="stylesheet" type="text/css" />
		<link href="css/bootstrap.css" rel="stylesheet" type="text/css" />
		
		<!-- Favicons -->	
		<link rel="shortcut icon" href="img/icons/favicon.ico">
		<link rel="apple-touch-icon" sizes="144x144" href="img/icons/apple-touch-icon-144x144.png">
		<link rel="apple-touch-icon" sizes="114x114" href="img/icons/apple-touch-icon-114x114.png">
		<link rel="apple-touch-icon" sizes="72x72" href="img/icons/apple-touch-icon-72x72.png">
		<link rel="apple-touch-icon" href="img/icons/apple-touch-icon.png">
			
		<!-- Google Fonts -->	
		<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic,800,800italic&subset=latin,greek,greek-ext,vietnamese,cyrillic-ext,cyrillic,latin-ext' rel='stylesheet' type='text/css'>
		
	</head>

	<body>
	
		<div id="contentForm">

			<?php
			header('Content-Type: text/html; charset=utf-8');

			if(isset($_POST['email'])) {
				 
					 
				// EDIT THE 2 LINES BELOW AS REQUIRED
				 
				$email_to = "info@curiouzmind.com";
				 
				$email_subject = "New Enquiry";
				 
				   
				$first_name = $_POST['first_name']; // required 
				$email_from = $_POST['email']; // required
				$subject = $_POST['subject']; // required
				$comments = $_POST['message']; // required
				 
				$email_message = "Form details below.\n\n";
				 
					
				function clean_string($string) {
					$bad = array("content-type","bcc:","to:","cc:","href");
					return str_replace($bad,"",$string);
				}
				 
				 
				$email_message .= "Name: ".clean_string($first_name)."\n";
				$email_message .= "Email Address: ".clean_string($email_from)."\n";
				$email_message .= "Subject: ".clean_string($subject)."\n";
				$email_message .= "Message: ".clean_string($comments)."\n";
				 
					 
				// create email headers
				 
				$headers = 'From: '.$email_from."\r\n".
				 
				'Reply-To: '.$email_from."\r\n" .
				 
				'X-Mailer: PHP/' . phpversion();
				 
				@mail($email_to, $email_subject, $email_message, $headers); 
				 
				?>
				 
				<!-- Message sent! (change the text below as you wish)-->
				<div class="container">
					<div class="row">
						<div class="col-sm-6 col-sm-offset-3">
							<div id="form_response" class="text-center">
								<img class="img-responsive" src="img/thumbs/mail_sent.png" alt="image" />
								<h1>Congratulations!</h1>
								<p>Thank you <span><?=$first_name;?></span>, your message is sent.</p>
								<p>We'll get back to you as soon as possible.</p>
								<a class="btn btn-theme" href="/">Back To The CuriouzMind Tech</a>
							</div>
						</div>	
					</div>					
				</div>
				 <!--End Message Sent-->

				<?php
				 
				}

				?>

		</div>
		
	</body>

</html>