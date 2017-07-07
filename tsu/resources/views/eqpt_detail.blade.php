@extends('layouts.master')

@section('title','後台管理系統-器材-泰達運動顧問有限公司')

@section('content')

<section id="main-content">
	<section class="wrapper main-wrapper row">
		<div class="col-xs-12">
			<div class="page-title">
				<div class="pull-left">
					<h1 class="title">{{ $item -> item -> name }}</h1>
					@if (Auth::user() -> level == 1)
					<div class="row">
						<div class="col-xs-8 col-md-12">
							<button type="button" class="btn btn-success" data-target="#createEqptModal" data-toggle="modal"><i class="fa fa-plus"></i> 新增</button>
						</div>
					</div>
					@endif
					@if ($msg = Session::get('success'))
						<div class="alert alert-success alert-dismissible fade in">
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
					<h2 class="title pull-left">{{ $item -> location -> name }}</h2>
				</header>
				<div class="content-body">
					<div class="row">
						<div class="col-xs-12">
							<table id="example-1" class="table table-striped dt-responsive display">
								<thead>
									<tr>
										<th>編號</th>
										<th>名稱</th>
										<th>單位</th>
										<th>應有數量</th>
										<th>操作</th>
									</tr>
								</thead>
								<tbody align="center">
									@foreach ($form -> eqpt as $e => $eqpt)
									<tr>
										<td>{{ $e + 1 }}</td>
										<td>{{ $eqpt -> name }}</td>
										<td>{{ $eqpt -> unit }}</td>
										<td>{{ $eqpt -> quantity }}</td>
										<td>
											@if (Auth::user() -> level == 1)
											<button type="button" class="btn btn-info" data-target="#editItemDetailModal" data-toggle="modal" onclick="editItemDetail('{{ $eqpt -> id }}')"><i class="fa fa-pencil-square-o"></i></button>
											<button type="button" class="btn btn-danger" data-target="#removeItemDetailModal" data-toggle="modal" onclick="editItemDetail('{{ $eqpt -> id }}')"><i class="fa fa-trash"></i></button>
											@endif
											<input type="hidden" name="hidden_view_detail" id="hidden_view_detail" value="{{url('/eqpt/viewEqpt')}}">
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

<div class="modal fade col-xs-12" id="createEqptModal" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">新增運動器材</h4>
			</div>
			<div class="modal-body">
				<form action="{{ url('/eqpt/createEqpt') }}" method="post">
					{{ csrf_field() }}
					<div class="form-group">
						<label class="form-label" for="create_eqpt_name">名稱</label>
						<div class="controls">
							<input type="text" id="create_eqpt_name" class="form-control" name="name" required>
						</div>
					</div>
					<div class="form-group">
						<label class="form-label" for="create_eqpt_unit">單位</label>
						<div class="controls">
							<input type="text" id="create_eqpt_unit" class="form-control" name="unit" required>
						</div>
					</div>
					<div class="form-group">
						<label class="form-label" for="create_eqpt_quantity">應有數量</label>
						<div class="controls">
							<input type="text" id="create_eqpt_quantity" class="form-control" name="quantity" required>
						</div>
					</div>
					<input type="hidden" name="form_id" value="{{ $form -> id }}">
					<button type="submit" class="btn btn-success">新增</button>
				</form>
			</div>
			<div class="modal-footer">
				<button data-dismiss="modal" class="btn btn-default" type="button">取消</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade col-xs-12" id="editItemDetailModal" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">修改運動器材</h4>
			</div>
			<div class="modal-body">
				<form action="{{ url('/eqpt/updateEqpt') }}" method="post">
					{{ csrf_field() }}
					<div class="form-group">
						<label class="form-label" for="edit_eqpt_name">名稱</label>
						<div class="controls">
							<input type="text" id="edit_eqpt_name" class="form-control" name="name" required>
						</div>
					</div>
					<div class="form-group">
						<label class="form-label" for="edit_eqpt_unit">單位</label>
						<div class="controls">
							<input type="text" id="edit_eqpt_unit" class="form-control" name="unit" required>
						</div>
					</div>
					<div class="form-group">
						<label class="form-label" for="edit_eqpt_quantity">應有數量</label>
						<div class="controls">
							<input type="text" id="edit_eqpt_quantity" class="form-control" name="quantity" required>
						</div>
					</div>
					<input type="hidden" id="edit_eqpt_id" name="id">
					<button type="submit" class="btn btn-success">修改</button>
				</form>
			</div>
			<div class="modal-footer">
				<button data-dismiss="modal" class="btn btn-default" type="button">取消</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade col-xs-12" id="removeItemDetailModal" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">刪除運動器材</h4>
			</div>
			<div class="modal-body">
				<i class="fa fa-question-circle fa-lg"></i>  
				您確定要刪除此運動器材？
				<form action="{{ url('/eqpt/removeEqpt') }}" method="post">
					{{ csrf_field() }}
					<input type="hidden" id="remove_eqpt_id" name="id">
					<button type="submit" class="btn btn-danger">刪除</button>
				</form>
			</div>
			<div class="modal-footer">
				<button data-dismiss="modal" class="btn btn-default" type="button">取消</button>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	function editItemDetail(id) {
		var view_url = $("#hidden_view_detail").val();

		$.ajax({
			url: view_url,
			type:"GET",
			data: {"id":id},
			success: function(result) {
				$("#edit_eqpt_id").val(result.id);
				$("#edit_eqpt_name").val(result.name);
				$("#edit_eqpt_unit").val(result.unit);
				$("#edit_eqpt_quantity").val(result.quantity);
				$("#remove_eqpt_id").val(result.id);
			}
		});
	}
</script>
@stop