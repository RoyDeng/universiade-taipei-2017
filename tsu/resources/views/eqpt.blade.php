@extends('layouts.master')

@section('title','後台管理系統-器材-泰達運動顧問有限公司')

@section('content')

<section id="main-content">
	<section class="wrapper main-wrapper row">
		<div class="col-xs-12">
			<div class="page-title">
				<div class="pull-left">
					<h1 class="title">運動器材</h1>
				</div>
			</div>
		</div>
		<div class="clearfix"></div>
		<div class="col-lg-12">
			<section class="box ">
				<header class="panel_header">
					<h2 class="title pull-left">器材</h2>
				</header>
				<div class="content-body">
					<div class="row">
						<div class="col-xs-12">
							<table id="example-1" class="table table-striped dt-responsive display">
								<thead>
									<tr>
										<th>編號</th>
										<th>項目</th>
										<th>場館</th>
										<th>操作</th>
									</tr>
								</thead>
								<tbody align="center">
									@foreach ($items as $i => $item)
									<tr>
										<td>{{ $i + 1 }}</td>
										<td>{{ $item -> item -> name }}</td>
										<td>{{ $item -> location -> name }}</td>
										<td>
											@if ($item -> item -> name != "ALL")
											<button type="button" class="btn btn-primary" onclick="location.href='{{url('/eqpt_detail')}}/{{ $item -> id }}';"><i class="fa fa-eye"></i></button>
											@endif
										</td>
									</tr>
									@endforeach
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</section>
		</div>
	</section>
</section>
@stop