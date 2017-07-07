@extends('layouts.master')

@section('title','後台管理系統-場館-泰達運動顧問有限公司')

@section('content')
<script>
	$(document).ready(function(){
		$('#removelocationModal').on('show', function(e) {
			var link = e.relatedTarget();

			var id = link.data("id");
			
			var modal = $(this);
			modal.find("#locationId").val(id);
		});
	});
</script>

<section id="main-content">
	<section class="wrapper main-wrapper row">
		<div class="col-xs-12">
			<div class="page-title">
				<div class="pull-left">
					<h1 class="title">場館</h1>
					@if (Auth::user() -> level == 1)
					<div class="row">
						<div class="col-xs-8 col-md-12">
							<button type="button" class="btn btn-success" data-target="#createLocationModal" data-toggle="modal"><i class="fa fa-plus"></i> 新增</button>
						</div>
					</div>
					@endif
					@if ($msg = Session::get('success'))
						<div class="alert alert-success alert-dismissible fade in">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
							<strong>{{ $msg }}</strong>
						</div>
					@endif
					@if ($msg = Session::get('warning'))
						<div class="alert alert-warning alert-dismissible fade in">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
							<strong>{{ $msg }}</strong>
						</div>
					@endif
				</div>
			</div>
		</div>
		<div class="clearfix"></div>
		<div class="col-lg-12">
			<section class="box ">
				<header class="panel_header">
				</header>
				<div class="content-body">
					<div class="row">
						<div class="col-xs-12">
							<table id="example-1" class="table table-striped dt-responsive display">
								<thead>
									<tr>
										<th>編號</th>
										<th>名稱</th>
										<th>地址</th>
										<th>經緯度</th>
										<th>新增時間</th>
										<th>修改時間</th>
										<th>操作</th>
									</tr>
								</thead>
								<tbody align="center">
									@foreach ($locations as $l => $location)
									<tr>
										<td>{{ $location -> id }}</td>
										<td>{{ $location -> name }}</td>
										<td>{{ $location -> address }}</td>
										<td>{{ $location -> latitude }}, {{ $location -> longitude }}</td>
										<td>{{ $location -> created_time }}</td>
										<td>{{ $location -> updated_time }}</td>
										<td>
											@if (Auth::user() -> level == 1)
											<button type="button" class="btn btn-info" data-target="#editLocationModal" data-toggle="modal" onclick="editLocation('{{ $location -> id }}')"><i class="fa fa-pencil-square-o"></i></button>
											@if ($location -> name != "ALL")
											<button type="button" class="btn btn-danger" data-target="#removeLocationModal" data-toggle="modal" onclick="editLocation('{{ $location -> id }}')"><i class="fa fa-trash"></i></button>
											@endif
											@endif
											<input type="hidden" name="hidden_view" id="hidden_view" value="{{url('/location/viewLocation')}}">
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

<div class="modal fade col-xs-12" id="createLocationModal" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">新增場館</h4>
			</div>
			<div class="modal-body">
				<form action="{{ url('/location/createLocation') }}" method="post">
					{{ csrf_field() }}
					<div class="form-group">
						<label class="form-label" for="create_name">名稱</label>
						<div class="controls">
							<input type="text" id="create_name" class="form-control" name="name" required>
						</div>
					</div>
					<div class="form-group">
						<label class="form-label" for="create_address">地址</label>
						<div class="controls">
							<input type="text" id="create_address" class="form-control" name="address" required>
						</div>
					</div>
					<div class="form-group">
						<label class="form-label" for="create_latitude">經度</label>
						<div class="controls">
							<input type="text" id="create_latitude" class="form-control" name="latitude" readonly="readonly">
						</div>
					</div>
					<div class="form-group">
						<label class="form-label" for="create_longitude">緯度</label>
						<div class="controls">
							<input type="text" id="create_longitude" class="form-control" name="longitude" readonly="readonly">
						</div>
					</div>
					<input type="hidden" id="edit_id" name="id">
					<button type="submit" class="btn btn-success">新增</button>
				</form>
			</div>
			<div class="modal-footer">
				<button data-dismiss="modal" class="btn btn-default" type="button">取消</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade col-xs-12" id="editLocationModal" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">修改場館</h4>
			</div>
			<div class="modal-body">
				<form action="{{ url('/location/updateLocation') }}" method="post">
					{{ csrf_field() }}
					<div class="form-group">
						<label class="form-label" for="edit_name">名稱</label>
						<div class="controls">
							<input type="text" id="edit_name" class="form-control" name="name" required>
						</div>
					</div>
					<div class="form-group">
						<label class="form-label" for="edit_address">地址</label>
						<div class="controls">
							<input type="text" id="edit_address" class="form-control" name="address" required>
						</div>
					</div>
					<div class="form-group">
						<label class="form-label" for="edit_latitude">經度</label>
						<div class="controls">
							<input type="text" id="edit_latitude" class="form-control" name="latitude" readonly="readonly">
						</div>
					</div>
					<div class="form-group">
						<label class="form-label" for="edit_longitude">緯度</label>
						<div class="controls">
							<input type="text" id="edit_longitude" class="form-control" name="longitude" readonly="readonly">
						</div>
					</div>
					<input type="hidden" id="edit_location_id" name="id">
					<button type="submit" class="btn btn-success">修改</button>
				</form>
			</div>
			<div class="modal-footer">
				<button data-dismiss="modal" class="btn btn-default" type="button">取消</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade col-xs-12" id="removeLocationModal" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">刪除場館</h4>
			</div>
			<div class="modal-body">
				<i class="fa fa-question-circle fa-lg"></i>  
				您確定要刪除此場館？
				<form action="{{ url('/location/removeLocation') }}" method="post">
					{{ csrf_field() }}
					<input type="hidden" id="remove_id" name="id">
					<button type="submit" class="btn btn-danger">刪除</button>
				</form>
			</div>
			<div class="modal-footer">
				<button data-dismiss="modal" class="btn btn-default" type="button">取消</button>
			</div>
		</div>
	</div>
</div>

<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&key=AIzaSyC3HuRhRJ_rcvAJdfbwdgFkuk5iZu4rMtc&sensor=false"></script>
<script type="text/javascript">
	function editLocation(id) {
		var view_url = $("#hidden_view").val();

		$.ajax({
			url: view_url,
			type:"GET",
			data: {"id":id},
			success: function(result) {
				$("#edit_location_id").val(result.id);
				$("#edit_name").val(result.name);
				$("#edit_address").val(result.address);
				$("#edit_latitude").val(result.latitude);
				$("#edit_longitude").val(result.longitude);
				$("#remove_id").val(result.id);
			}
		});
	}

	$(document).ready(function() {
		$('#create_address').bind('keyup', function(){	
			GetCreateAddressMarker();
		});
		$('#edit_address').bind('keyup', function(){	
			GetEditAddressMarker();
		});
	});

	function GetCreateAddressMarker() {
		address = $('#create_address').val();
		geocoder = new google.maps.Geocoder();
		geocoder.geocode(
			{
				'address':address
			},function (results,status) {
				if(status==google.maps.GeocoderStatus.OK) {
					LatLng = results[0].geometry.location;
					$('#create_latitude').val(LatLng.lat());
					$('#create_longitude').val(LatLng.lng());
				}
			}
		);
	}

	function GetEditAddressMarker() {
		address = $('#edit_address').val();
		geocoder = new google.maps.Geocoder();
		geocoder.geocode(
			{
				'address':address
			},function (results,status) {
				if(status==google.maps.GeocoderStatus.OK) {
					LatLng = results[0].geometry.location;
					$('#edit_latitude').val(LatLng.lat());
					$('#edit_longitude').val(LatLng.lng());
				}
			}
		);
	}
</script>
@stop