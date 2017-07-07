@section('title','後台管理系統-使用者登入-泰達運動顧問有限公司')

<!DOCTYPE html>
<html>
	<head>
		<title>@yield('title')</title>
		@include('partials.head')
	</head>
	<body class=" login_page">
		<div class="container-fluid">
			<div class="login-wrapper row">
				<div id="login" class="login loginpage col-lg-offset-4 col-md-offset-3 col-sm-offset-3 col-xs-offset-0 col-xs-12 col-sm-6 col-lg-4">
					<h1><a title="Login Page" tabindex="-1">使用者登入</a></h1>
					<form action="{{ route('login') }}" method="post">
						{{ csrf_field() }}
						<p>
							<label for="username">帳號或Email<br />
								<input type="text" name="username" id="username" class="input" placeholder="帳號或Email" size="20" required /></label>
								@if ($errors -> has('username'))
									<span class="help-block">
										<strong>{{ $errors->first('username') }}</strong>
									</span>
								@endif
						</p>
						<p>
							<label for="password">密碼<br />
								<input type="password" name="password" id="password" class="input" placeholder="密碼" size="20" required /></label>
								@if ($errors -> has('password'))
									<span class="help-block">
										<strong>{{ $errors -> first('password') }}</strong>
									</span>
								@endif
						</p>
						<p class="forgetmenot">
							<label class="icheck-label form-label" for="remember"><input name="remember" type="checkbox" id="remember" class="icheck-minimal-aero" {{ old('remember') ? 'checked' : '' }}> 記住我</label>
						</p>
						<p class="submit">
							<input type="submit" name="wp-submit" id="wp-submit" class="btn btn-accent btn-block" value="登入" />
						</p>
					</form>
					<p id="nav">
						<a class="pull-left" href="{{ route('password.request') }}" title="忘記密碼？">忘記密碼？</a>
					</p>
				</div>
			</div>
		</div>
		@include('partials.footer')
	</body>
</html>