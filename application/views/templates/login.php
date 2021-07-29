<head>
	<title>Jomlasielsi</title>
	<link rel="apple-touch-icon" sizes="57x57" href="<?= base_url() ?>assets/favicon/bg-white/apple-icon-57x57.png">
	<link rel="apple-touch-icon" sizes="60x60" href="<?= base_url() ?>assets/favicon/bg-white/apple-icon-60x60.png">
	<link rel="apple-touch-icon" sizes="72x72" href="<?= base_url() ?>assets/favicon/bg-white/apple-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="76x76" href="<?= base_url() ?>assets/favicon/bg-white/apple-icon-76x76.png">
	<link rel="apple-touch-icon" sizes="114x114" href="<?= base_url() ?>assets/favicon/bg-white/apple-icon-114x114.png">
	<link rel="apple-touch-icon" sizes="120x120" href="<?= base_url() ?>assets/favicon/bg-white/apple-icon-120x120.png">
	<link rel="apple-touch-icon" sizes="144x144" href="<?= base_url() ?>assets/favicon/bg-white/apple-icon-144x144.png">
	<link rel="apple-touch-icon" sizes="152x152" href="<?= base_url() ?>assets/favicon/bg-white/apple-icon-152x152.png">
	<link rel="apple-touch-icon" sizes="180x180" href="<?= base_url() ?>assets/favicon/bg-white/apple-icon-180x180.png">
	<link rel="icon" type="image/png" sizes="192x192" href="<?= base_url() ?>assets/favicon/bg-white/android-icon-192x192.png">
	<link rel="icon" type="image/png" sizes="32x32" href="<?= base_url() ?>assets/favicon/bg-white/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="96x96" href="<?= base_url() ?>assets/favicon/bg-white/favicon-96x96.png">
	<link rel="icon" type="image/png" sizes="16x16" href="<?= base_url() ?>assets/favicon/bg-white/favicon-16x16.png">
	<link rel="manifest" href="<?= base_url() ?>assets/favicon/bg-white/manifest.json">
	<meta name="msapplication-TileColor" content="#0134d4">
	<meta name="theme-color" content="#0134d4">
	<meta name="msapplication-TileImage" content="<?= base_url() ?>assets/favicon/bg-white/ms-icon-144x144.png">
</head>
<style type="text/css">
	@import url('https://rsms.me/inter/inter-ui.css');

	::selection {
		background: #2D2F36;
	}

	::-webkit-selection {
		background: #2D2F36;
	}

	::-moz-selection {
		background: #2D2F36;
	}

	body {
		background: white;
		font-family: 'Inter UI', sans-serif;
		margin: 0;
		padding: 20px;
	}

	.page {
		background: #e2e2e5;
		display: flex;
		flex-direction: column;
		height: calc(100% - 40px);
		position: absolute;
		place-content: center;
		width: calc(100% - 40px);
	}

	@media (max-width: 767px) {
		.page {
			height: auto;
			margin-bottom: 20px;
			padding-bottom: 20px;
		}
	}

	.container {
		display: flex;
		height: 320px;
		margin: 0 auto;
		width: 680px;
	}

	@media (max-width: 767px) {
		.container {
			flex-direction: column;
			height: 530px;
			width: 320px;
		}
	}

	.left {
		background: white;
		height: calc(100% - 40px);
		top: 20px;
		position: relative;
		width: 50%;
	}

	@media (max-width: 767px) {
		.left {
			height: 100%;
			left: 20px;
			width: calc(100% - 40px);
			max-height: 270px;
		}
	}

	.login {
		font-size: 50px;
		font-weight: 900;
		margin: 50px 40px 40px;
	}

	.eula {
		color: #999;
		font-size: 14px;
		line-height: 1.5;
		margin-top: 40px;
		margin-bottom: 40px;
		margin-left: 40px;
		margin-right: 20px;
	}

	.right {
		background: #474A59;
		box-shadow: 0px 0px 40px 16px rgba(0, 0, 0, 0.22);
		color: #F1F1F2;
		position: relative;
		width: 50%;
	}

	@media (max-width: 767px) {
		.right {
			flex-shrink: 0;
			height: 100%;
			width: 100%;
			max-height: 350px;
		}
	}

	svg {
		position: absolute;
		width: 320px;
	}

	path {
		fill: none;
		stroke: url(#linearGradient);
		;
		stroke-width: 4;
		stroke-dasharray: 240 1386;
	}

	.form {
		margin: 40px;
		position: absolute;
	}

	label {
		color: #c2c2c5;
		display: block;
		font-size: 14px;
		height: 16px;
		margin-top: 20px;
		margin-bottom: 5px;
	}

	input {
		background: transparent;
		border: 0;
		color: #f2f2f2;
		font-size: 20px;
		height: 30px;
		line-height: 30px;
		outline: none !important;
		width: 100%;
	}

	input::-moz-focus-inner {
		border: 0;
	}

	#submit {
		color: #707075;
		margin-top: 40px;
		margin-left: -10px;
		transition: color 300ms;
	}

	#submit:focus {
		color: #f2f2f2;
	}

	#submit:active {
		color: #d0d0d2;
	}
</style>

<div class="page">
	<div class="container">
		<div class="left">
			<div class="login"></div>
			<div class="eula"><img src="assets/img/lg1.png" width="300" height="200">

			</div>
			<span style="margin-top:-10px"></span>
		</div>
		<div class="right">
			<svg viewBox="0 0 320 300">
				<defs>
					<linearGradient inkscape:collect="always" id="linearGradient" x1="13" y1="193.49992" x2="307" y2="193.49992" gradientUnits="userSpaceOnUse">
						<stop style="stop-color:#ff00ff;" offset="0" id="stop876" />
						<stop style="stop-color:#ff0000;" offset="1" id="stop878" />
					</linearGradient>
				</defs>
				<path d="m 40,120.00016 239.99984,-3.2e-4 c 0,0 24.99263,0.79932 25.00016,35.00016 0.008,34.20084 -25.00016,35 -25.00016,35 h -239.99984 c 0,-0.0205 -25,4.01348 -25,38.5 0,34.48652 25,38.5 25,38.5 h 215 c 0,0 20,-0.99604 20,-25 0,-24.00396 -20,-25 -20,-25 h -190 c 0,0 -20,1.71033 -20,25 0,24.00396 20,25 20,25 h 168.57143" />
			</svg>
			<div id="form" class="form">
				<label for="email">Email</label>
				<input type="email" id="email" name="email">
				<label for="password">Password</label>
				<input type="password" id="password" name="email">
				<input type="submit" id="submit" value="Submit" name="login">
				<!-- <button id="submit">Login</button> -->
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<br>
			<p style="text-align: center;"><?= $copyright ?></p>
		</div>
	</div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/2.2.0/anime.min.js"></script>
<script src="<?= base_url() ?>assets/js/notification/SmartNotification.min.js"></script>
<script src="<?= $this->plugin->build_url('javascripts/api-client.js', FALSE, 'site') ?>" type="text/javascript"></script>
<script src="<?= $this->plugin->build_url('javascripts/application.js', FALSE, 'site') ?>" type="text/javascript"></script>
<script type="text/javascript">
	var current = null;
	document.querySelector('#email').addEventListener('focus', function(e) {
		if (current) current.pause();
		current = anime({
			targets: 'path',
			strokeDashoffset: {
				value: 0,
				duration: 700,
				easing: 'easeOutQuart'
			},
			strokeDasharray: {
				value: '240 1386',
				duration: 700,
				easing: 'easeOutQuart'
			}
		});
	});
	document.querySelector('#password').addEventListener('focus', function(e) {
		if (current) current.pause();
		current = anime({
			targets: 'path',
			strokeDashoffset: {
				value: -336,
				duration: 700,
				easing: 'easeOutQuart'
			},
			strokeDasharray: {
				value: '240 1386',
				duration: 700,
				easing: 'easeOutQuart'
			}
		});
	});
	document.querySelector('#submit').addEventListener('focus', function(e) {
		if (current) current.pause();
		current = anime({
			targets: 'path',
			strokeDashoffset: {
				value: -730,
				duration: 700,
				easing: 'easeOutQuart'
			},
			strokeDasharray: {
				value: '530 1386',
				duration: 700,
				easing: 'easeOutQuart'
			}
		});
	});
</script>

<script type="text/javascript">
	$(() => {
		$("input[name='login']").on("click", function() {
			let username = $('#email').val()
			let password = $('#password').val()

			$.ajax({
				method: 'post',
				url: '<?= base_url() ?>login/doLogin',
				data: {
					username: username,
					password: password
				}
			}).done((data) => {
				if (data.status == 1) {
					$.warningMessage('Password salah.', 'LOGIN')

					$('#password').val('')

					$('#password').focus()
				} else if (data.status == 2) {
					$.failMessage('Akun tidak ditemukan.', 'LOGIN')

					$('#username').val('')
					$('#password').val('')

					$('#username').focus()
				} else {
					// $.smallBox({
					// 	title 		: "Login",
					// 	content 	: "Login success",
					// 	color 		: "#51a351",
					// 	iconSmall 	: "fa fa-check bounce animated",
					// 	timeout 	: 1000
					// })

					window.location.href = '<?= base_url() ?>dashboard'
				}
			})
		});

		// $('#form2').submit((ev) =>
		// {
		// 	ev.preventDefault()
		// 	alert('soni')
		// 	let username 	= $('#email').val()
		// 	let password 	= $('#password').val()

		// 	window.apiClient.login.cekLogin(username, password)
		// 	.done((data) =>
		// 	{
		// 		if(data.status == 1)
		// 		{
		// 			$.warningMessage('Password salah.', 'LOGIN')

		// 			$('#password').val('')

		// 			$('#password').focus()
		// 		}
		// 		else if(data.status == 2)
		// 		{
		// 			$.failMessage('Akun tidak ditemukan.', 'LOGIN')

		// 			$('#username').val('')
		// 			$('#password').val('')

		// 			$('#username').focus()
		// 		}
		// 		else
		// 		{
		// 			$.doneMessage('Login success.', 'LOGIN')

		// 			setInterval(() => { window.location.href = '<?= base_url() ?>dashboard' }, 1000)
		// 		}
		// 	})
		// })
	})
</script>