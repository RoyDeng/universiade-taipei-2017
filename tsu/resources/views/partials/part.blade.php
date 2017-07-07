<div class="page-sidebar fixedscroll">
	<div class="page-sidebar-wrapper" id="main-menu-wrapper">
		<div class="profile-info row">
			<div class="profile-image col-xs-4">
				<img alt="" src="{{ asset('assets/images/user.png') }}" class="img-responsive img-circle">
			</div>
			<div class="profile-details col-xs-8">
				<h3>
					{{ Auth::user() -> name }}
					<span class="profile-status online"></span>
				</h3>
				<p class="profile-title">{{ Auth::user() -> username }}</p>
			</div>
		</div>
		<ul class='wraplist'>
			<li class="{{ Request::segment(1) === null ? 'open' : null }}">
				<a href="{{ url('/') }}">
					<i class="fa fa-dashboard"></i>
					<span class="title">首頁</span>
				</a>
			</li>
			<li class="{{ Request::segment(1) === 'item' ? 'open' : null }}">
				<a href="{{ url('/item') }}">
					<i class="fa fa-bicycle"></i>
					<span class="title">項目</span>
				</a>
			</li>
			<li class="{{ Request::segment(1) === 'location' ? 'open' : null }}">
				<a href="{{ url('/location') }}">
					<i class="fa fa-building"></i>
					<span class="title">場館</span>
				</a>
			</li>
			<li class="{{ Request::segment(1) === 'eqpt' ? 'open' : null }}">
				<a href="{{ url('/eqpt') }}">
					<i class="fa fa-futbol-o"></i>
					<span class="title">運動器材</span>
				</a>
			</li>
			<li class="{{ Request::segment(1) === 'form' ? 'open' : null }}">
				<a href="{{ url('/form') }}">
					<i class="fa fa-file-excel-o"></i>
					<span class="title">驗收單</span>
				</a>
			</li>
			<li class="{{ Request::segment(1) === 'user' ? 'open' : null }}">
				<a href="{{ url('/user') }}">
					<i class="fa fa-users"></i>
					<span class="title">工作人員</span>
				</a>
			</li>
			<li class="{{ Request::segment(1) === 'check_log' ? 'open' : null }}">
				<a href="{{ url('/check_log') }}">
					<i class="fa fa-sticky-note"></i>
					<span class="title">簽到/退表</span>
				</a>
			</li>
			<li class="{{ Request::segment(1) === 'note' ? 'open' : null }}">
				<a href="{{ url('/note') }}">
					<i class="fa fa-exclamation-triangle"></i>
					<span class="title">注意事項</span>
				</a>
			</li>
			<li>
				<a href="https://apps.ionic.io/login?next=/apps/" target="_blank">
					<i class="fa fa-info-circle"></i>
					<span class="title">推撥通知</span>
				</a>
			</li>
		</ul>
	</div>
</div>