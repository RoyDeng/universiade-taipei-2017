<div class="page-topbar ">
	<div class="logo-area"></div>
	<div class="quick-area">
		<div class="pull-left">
			<ul class="info-menu left-links list-inline list-unstyled">
				<li class="sidebar-toggle-wrap">
					<a href="#" data-toggle="sidebar" class="sidebar_toggle">
						<i class="fa fa-bars"></i>
					</a>
				</li>
				<li class="notify-toggle-wrapper">
					<a href="#" data-toggle="dropdown" class="toggle">
						<i class="fa fa-bell"></i>
						@if (count($nts) > 0)
						<span class="badge badge-accent">{{ $nts -> count() }}</span>
						@endif
					</a>
					<ul class="dropdown-menu notifications animated fadeIn">
						<li class="total">
							<span class="small">
								目前有<strong>{{ $nts -> count() }}</strong>個異常事項。
							</span>
						</li>
						<li class="list">
							@foreach ($nts as $nt)
							<ul class="dropdown-menu-list list-unstyled ps-scrollbar">
								<a href="{{ url('/form_detail') }}/{{ $nt -> eqpt -> form -> id }}">
									<li class="busy">
										<div class="notice-icon">
											<i class="fa fa-exclamation-triangle"></i>
										</div>
										<div>
											<span class="name">
												<strong>{{ $nt -> remark }}</strong>
												<span class="time small">{{ $nt -> eqpt -> form -> item_detail -> location -> name }}</span>
											</span>
										</div>
									</li>
								</a>
							</ul>
							@endforeach
						</li>
					</ul>
				</li>
			</ul>
		</div>
		<div class="pull-right">
			<ul class="info-menu right-links list-inline list-unstyled">
				<li class="profile">
					<a href="#" data-toggle="dropdown" class="toggle">
						<img src="{{ asset('assets/images/user.png') }}" alt="user-image" class="img-circle img-inline">
						<span>{{ Auth::user() -> name }} <i class="fa fa-angle-down"></i></span>
					</a>
					<ul class="dropdown-menu profile animated fadeIn">
						<li>
							<a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
								<i class="fa fa-sign-out"></i>
								登出
							</a>
							<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
								{{ csrf_field() }}
							</form>
						</li>
					</ul>
				</li>
			</ul>			
		</div>
	</div>
</div>