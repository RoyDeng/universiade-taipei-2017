@extends('layouts.master')

@section('title','後台管理系統-項目-泰達運動顧問有限公司')

@section('content')

<section id="main-content">
	<section class="wrapper main-wrapper row">
		<div class="col-xs-12">
			<div class="page-title">
				<div class="pull-left">
					<h1 class="title">項目</h1>
					@if (Auth::user() -> level == 1)
					<div class="row">
						<div class="col-xs-8 col-md-12">
							<button type="button" class="btn btn-success" data-target="#createItemModal" data-toggle="modal"><i class="fa fa-plus"></i> 新增</button>
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
										<th>新增時間</th>
										<th>修改時間</th>
										<th>操作</th>
									</tr>
								</thead>
								<tbody align="center">
									@foreach ($items as $i => $item)
									<tr>
										<td>{{ $i + 1 }}</td>
										<td>{{ $item -> name }}</td>
										<td>{{ $item -> created_time }}</td>
										<td>{{ $item -> updated_time }}</td>
										<td>
											<button type="button" class="btn btn-primary" onclick="location.href='{{url('/item_detail')}}/{{ $item -> id }}';"><i class="fa fa-eye"></i></button>
											@if (Auth::user() -> level == 1)
											<button type="button" class="btn btn-info" data-target="#editItemModal" data-toggle="modal" onclick="editItem('{{ $item -> id }}')"><i class="fa fa-pencil-square-o"></i></button>
											@if ($item -> name != "ALL")
											<button type="button" class="btn btn-danger" data-target="#removeItemModal" data-toggle="modal" onclick="editItem('{{ $item -> id }}')"><i class="fa fa-trash"></i></button>
											@endif
											@endif
											<input type="hidden" name="hidden_view" id="hidden_view" value="{{url('/item/viewItem')}}">
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

<div class="modal fade col-xs-12" id="createItemModal" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">新增項目</h4>
			</div>
			<div class="modal-body">
				<form action="{{ url('/item/createItem') }}" method="post">
					{{ csrf_field() }}
					<div class="form-group">
						<label class="form-label" for="create_name">名稱</label>
						<div class="controls">
							<input type="text" id="create_name" class="form-control" name="name" required>
						</div>
					</div>
					<button type="submit" class="btn btn-success">新增</button>
				</form>
			</div>
			<div class="modal-footer">
				<button data-dismiss="modal" class="btn btn-default" type="button">取消</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade col-xs-12" id="editItemModal" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">修改項目</h4>
			</div>
			<div class="modal-body">
				<form action="{{ url('/item/updateItem') }}" method="post">
					{{ csrf_field() }}
					<div class="form-group">
						<label class="form-label" for="edit_item_name">名稱</label>
						<div class="controls">
							<input type="text" id="edit_item_name" class="form-control" name="name" required>
						</div>
					</div>
					<input type="hidden" id="edit_item_id" name="id">
					<button type="submit" class="btn btn-success">修改</button>
				</form>
			</div>
			<div class="modal-footer">
				<button data-dismiss="modal" class="btn btn-default" type="button">取消</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade col-xs-12" id="removeItemModal" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">刪除項目</h4>
			</div>
			<div class="modal-body">
				<i class="fa fa-question-circle fa-lg"></i>  
				您確定要刪除此項目？
				<form action="{{ url('/item/romoveItem') }}" method="post">
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

<script type="text/javascript">
	function editItem(id) {
		var view_url = $("#hidden_view").val();

		$.ajax({
			url: view_url,
			type:"GET",
			data: {"id":id},
			success: function(result) {
				$("#edit_item_id").val(result.id);
				$("#edit_item_name").val(result.name);
				$("#remove_id").val(result.id);
			}
		});
	}
</script>
@stop