@section('title','後台管理系統-重設密碼-泰達運動顧問有限公司')

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
					<h1><a title="Login Page" tabindex="-1">重設密碼</a></h1>
					@if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
					<form action="{{ route('password.email') }}" method="post">
						{{ csrf_field() }}
						<p>
							<label for="email">Email<br />
								<input type="email" name="email" id="email" class="input" placeholder="Email" size="20" required /></label>
								@if ($errors -> has('email'))
									<span class="help-block">
										<strong>{{ $errors->first('email') }}</strong>
									</span>
								@endif
						</p>
						<p class="submit">
							<input type="submit" name="wp-submit" id="wp-submit" class="btn btn-accent btn-block" value="送出" />
						</p>
					</form>
					<p id="nav">
						<a class="pull-left" href="{{ route('login') }}" title="登入">登入</a>
					</p>
				</div>
			</div>
		</div>
		@include('partials.footer')
	</body>
</html>