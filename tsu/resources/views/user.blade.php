@extends('layouts.master')

@section('title','後台管理系統-工作人員-泰達運動顧問有限公司')

@section('content')
<section id="main-content">
	<section class="wrapper main-wrapper row">
		<div class="col-xs-12">
			<div class="page-title">
				<div class="pull-left">
					<h1 class="title">工作人員</h1>
					@if (Auth::user() -> level == 1)
					<div class="row">
						<div class="col-xs-8 col-md-12">
							<button type="button" class="btn btn-success" data-target="#createUserModal" data-toggle="modal"><i class="fa fa-plus"></i> 新增工讀生</button>
							<button type="button" class="btn btn-success" data-target="#createAdminModal" data-toggle="modal"><i class="fa fa-plus"></i> 新增管理員</button>
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
										<th>姓名</th>
										<th>階級</th>
										<th>帳號</th>
										<th>行動電話</th>
										<th>Email</th>
										<th>操作</th>
									</tr>
								</thead>
								<tbody align="center">
									@foreach ($users as $u => $user)
									<tr>
										<td>{{ $u + 1 }}</td>
										<td>{{ $user -> name }}</td>
										<td>
											@if ($user -> level == 0)
											工讀生
											@else
											管理員
											@endif
										</td>
										<td>{{ $user -> username }}</td>
										<td>{{ $user -> tel }}</td>
										<td>{{ $user -> email }}</td>
										<td>
											@if (Auth::user() -> level == 1)
											<button type="button" class="btn btn-info" data-target="#editUserModal" data-toggle="modal" onclick="editUser('{{ $user -> id }}')"><i class="fa fa-pencil-square-o"></i></button>
											<button type="button" class="btn btn-primary" data-target="#editPasswordModal" data-toggle="modal" onclick="editUser('{{ $user -> id }}')"><i class="fa fa-key"></i></button>
											<button type="button" class="btn btn-danger" data-target="#removeUserModal" data-toggle="modal" onclick="editUser('{{ $user -> id }}')"><i class="fa fa-trash"></i></button>
											@endif
											<input type="hidden" name="hidden_view_detail" id="hidden_view_detail" value="{{url('/user/viewUser')}}">
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

<div class="modal fade col-xs-12" id="createUserModal" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">新增工讀生</h4>
			</div>
			<div class="modal-body">
				<form action="{{ url('/user/createUser') }}" method="post">
					{{ csrf_field() }}
					<div class="form-group">
						<label class="form-label" for="create_user_name">姓名</label>
						<div class="controls">
							<input class="form-control" id="create_user_name" name="name" required>
						</div>
					</div>
					<div class="form-group">
						<label class="form-label" for="create_user_username">帳號</label>
						<div class="controls">
							<input class="form-control" id="create_user_username" name="username" required>
						</div>
					</div>
					<div class="form-group">
						<label class="form-label" for="create_user_password">密碼</label>
						<div class="controls">
							<input class="form-control" id="create_user_password" name="password" required>
						</div>
					</div>
					<div class="form-group">
						<label class="form-label" for="create_user_email">Email</label>
						<div class="controls">
							<input class="form-control" id="create_user_email" name="email" required>
						</div>
					</div>
					<div class="form-group">
						<label class="form-label" for="create_user_tel">行動電話</label>
						<div class="controls">
							<input class="form-control" id="create_user_tel" name="tel" required>
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

<div class="modal fade col-xs-12" id="createAdminModal" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">新增管理者</h4>
			</div>
			<div class="modal-body">
				<form action="{{ url('/user/createAdmin') }}" method="post">
					{{ csrf_field() }}
					<div class="form-group">
						<label class="form-label" for="create_admin_name">姓名</label>
						<div class="controls">
							<input class="form-control" id="create_admin_name" name="name" required>
						</div>
					</div>
					<div class="form-group">
						<label class="form-label" for="create_admin_username">帳號</label>
						<div class="controls">
							<input class="form-control" id="create_admin_username" name="username" required>
						</div>
					</div>
					<div class="form-group">
						<label class="form-label" for="create_admin_password">密碼</label>
						<div class="controls">
							<input class="form-control" id="create_admin_password" name="password" required>
						</div>
					</div>
					<div class="form-group">
						<label class="form-label" for="create_admin_email">Email</label>
						<div class="controls">
							<input class="form-control" id="create_admin_email" name="email" required>
						</div>
					</div>
					<div class="form-group">
						<label class="form-label" for="create_admin_tel">行動電話</label>
						<div class="controls">
							<input class="form-control" id="create_admin_tel" name="tel" required>
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

<div class="modal fade col-xs-12" id="editUserModal" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">修改管理人員</h4>
			</div>
			<div class="modal-body">
				<form action="{{ url('/user/updateUser') }}" method="post">
					{{ csrf_field() }}
					<div class="form-group">
						<label class="form-label" for="edit_user_name">姓名</label>
						<div class="controls">
							<input class="form-control" id="edit_user_name" name="name" required>
						</div>
					</div>
					<div class="form-group">
						<label class="form-label" for="edit_user_username">帳號</label>
						<div class="controls">
							<input class="form-control" id="edit_user_username" name="username" required>
						</div>
					</div>
					<div class="form-group">
						<label class="form-label" for="edit_user_email">Email</label>
						<div class="controls">
							<input class="form-control" id="edit_user_email" name="email" required>
						</div>
					</div>
					<div class="form-group">
						<label class="form-label" for="edit_user_tel">行動電話</label>
						<div class="controls">
							<input class="form-control" id="edit_user_tel" name="tel" required>
						</div>
					</div>
					<input type="hidden" id="edit_user_id" name="id">
					<button type="submit" class="btn btn-success">修改</button>
				</form>
			</div>
			<div class="modal-footer">
				<button data-dismiss="modal" class="btn btn-default" type="button">取消</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade col-xs-12" id="editPasswordModal" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">修改密碼</h4>
			</div>
			<div class="modal-body">
				<form action="{{ url('/user/updatePassword') }}" method="post">
					{{ csrf_field() }}
					<div class="form-group">
						<label class="form-label" for="change_user_name">姓名</label>
						<div class="controls">
							<input class="form-control" id="change_user_name" readonly>
						</div>
					</div>
					<div class="form-group">
						<label class="form-label" for="change_user_username">帳號</label>
						<div class="controls">
							<input class="form-control" id="change_user_username" readonly>
						</div>
					</div>
					<div class="form-group">
						<label class="form-label" for="old_password">舊密碼</label>
						<div class="controls">
							<input class="form-control" id="old_password" name="old_password" required>
						</div>
					</div>
					<div class="form-group">
						<label class="form-label" for="new_password">新密碼</label>
						<div class="controls">
							<input class="form-control" id="new_password" name="new_password" required>
						</div>
					</div>
					<input type="hidden" id="change_user_id" name="id">
					<button type="submit" class="btn btn-success">修改</button>
				</form>
			</div>
			<div class="modal-footer">
				<button data-dismiss="modal" class="btn btn-default" type="button">取消</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade col-xs-12" id="removeUserModal" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">刪除工作人員</h4>
			</div>
			<div class="modal-body">
				<i class="fa fa-question-circle fa-lg"></i>  
				您確定要刪除此工作人員？
				<form action="{{ url('/user/removeUser') }}" method="post">
					{{ csrf_field() }}
					<input type="hidden" id="remove_user_id" name="id">
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
	function editUser(id) {
		var view_url = $("#hidden_view_detail").val();

		$.ajax({
			url: view_url,
			type:"GET",
			data: {"id":id},
			success: function(result) {
				$("#edit_user_id").val(result.id);
				$("#edit_user_name").val(result.name);
				$("#edit_user_username").val(result.username);
				$("#edit_user_email").val(result.email);
				$("#edit_user_tel").val(result.tel);
				$("#change_user_id").val(result.id);
				$("#change_user_name").val(result.name);
				$("#change_user_username").val(result.username);
				$("#remove_user_id").val(result.id);
			}
		});
	}
</script>
@stop