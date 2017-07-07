@extends('layouts.master')

@section('title','後台管理系統-注意事項-泰達運動顧問有限公司')

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
							<button type="button" class="btn btn-success" data-target="#createNoteModal" data-toggle="modal"><i class="fa fa-plus"></i> 新增</button>
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
										<th>內容</th>
										<th>新增時間</th>
										<th>修改時間</th>
										<th>操作</th>
									</tr>
								</thead>
								<tbody align="center">
									@foreach ($notes as $n => $note)
									<tr>
										<td>{{ $n + 1 }}</td>
										<td>{{ $note -> remark }}</td>
										<td>{{ $note -> created_time }}</td>
										<td>{{ $note -> updated_time }}</td>
										<td>
											@if (Auth::user() -> level == 1)
											<button type="button" class="btn btn-info" data-target="#editNoteModal" data-toggle="modal" onclick="editNotification('{{ $note -> id }}')"><i class="fa fa-pencil-square-o"></i></button>
											<button type="button" class="btn btn-danger" data-target="#removeNoteModal" data-toggle="modal" onclick="editNotification('{{ $note -> id }}')"><i class="fa fa-trash"></i></button>
											@endif
											<input type="hidden" name="hidden_view_detail" id="hidden_view_detail" value="{{url('/note/viewNote')}}">
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

<div class="modal fade col-xs-12" id="createNoteModal" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">新增注意事項</h4>
			</div>
			<div class="modal-body">
				<form action="{{ url('/note/createNote') }}" method="post">
					{{ csrf_field() }}
					<div class="form-group">
						<label class="form-label" for="create_eqpt_remark">內容</label>
						<div class="controls">
							<input type="text" id="create_eqpt_remark" class="form-control" name="remark" required>
						</div>
					</div>
					<input type="hidden" name="item_detail_id" value="{{ $item -> id }}">
					<button type="submit" class="btn btn-success">新增</button>
				</form>
			</div>
			<div class="modal-footer">
				<button data-dismiss="modal" class="btn btn-default" type="button">取消</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade col-xs-12" id="editNoteModal" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">修改注意事項</h4>
			</div>
			<div class="modal-body">
				<form action="{{ url('/note/updateNote') }}" method="post">
					{{ csrf_field() }}
					<div class="form-group">
						<label class="form-label" for="edit_eqpt_remark">內容</label>
						<div class="controls">
							<input type="text" id="edit_eqpt_remark" class="form-control" name="remark" required>
						</div>
					</div>
					<input type="hidden" id="edit_note_id" name="id">
					<button type="submit" class="btn btn-success">修改</button>
				</form>
			</div>
			<div class="modal-footer">
				<button data-dismiss="modal" class="btn btn-default" type="button">取消</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade col-xs-12" id="removeNoteModal" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">刪除注意事項</h4>
			</div>
			<div class="modal-body">
				<i class="fa fa-question-circle fa-lg"></i>  
				您確定要刪除此注意事項？
				<form action="{{ url('/note/removeNote') }}" method="post">
					{{ csrf_field() }}
					<input type="hidden" id="remove_note_id" name="id">
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
	function editNotification(id) {
		var view_url = $("#hidden_view_detail").val();

		$.ajax({
			url: view_url,
			type:"GET",
			data: {"id":id},
			success: function(result) {
				$("#edit_note_id").val(result.id);
				$("#edit_eqpt_remark").val(result.remark);
				$("#remove_note_id").val(result.id);
			}
		});
	}
</script>
@stop