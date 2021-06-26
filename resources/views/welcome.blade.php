<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Employee Management</title>
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" >
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<link  href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet">
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>

</head>
<body>
<div class="container mt-2">
<div class="row">
<div class="col-lg-12 margin-tb">
<div class="pull-left">
<h2>Employee Management</h2>
</div>
<div class="pull-right mb-2">
<a class="btn btn-success" onClick="add()" href="javascript:void(0)"> Create Employee</a>
</div>
</div>
</div>
@if ($message = Session::get('success'))
<div class="alert alert-success">
<p>{{ $message }}</p>
</div>
@endif
<div class="card-body">
<table class="table table-bordered" id="ajax-crud-datatable">
<thead>
<tr>
<th>Name</th>
<th>Designation</th>
<th>Action</th>
</tr>
</thead>
</table>
</div>
</div>
<!-- boostrap  model -->
<div class="modal fade" id="employee-modal" aria-hidden="true">
<div class="modal-dialog modal-lg">
<div class="modal-content">
<div class="modal-header">
<h4 class="modal-title" id="EmployeeModal"></h4>
</div>
<div class="modal-body">
<form action="javascript:void(0)" id="EmployeeForm" name="EmployeeForm" class="form-horizontal" method="POST" enctype="multipart/form-data">
<input type="hidden" name="id" id="id">
<div class="form-group">
<label for="name" class="col-sm-2 control-label">Name</label>
<div class="col-sm-12">
<input type="text" class="form-control" id="name" name="name" placeholder="Enter Employee Name" maxlength="50" required="">
</div>
</div>
<div class="form-group">
<label for="name" class="col-sm-2 control-label">Designation</label>
<div class="col-sm-12">
<input type="text" class="form-control" id="designation" name="designation" placeholder="Enter Employee Designation" maxlength="50" required="">
</div>
</div>  
<div class="form-group">
<label for="name" class="col-sm-2 control-label">Email</label>
<div class="col-sm-12">
<input type="email" class="form-control" id="email" name="email" placeholder="Enter Employee Email" maxlength="50" required="">
</div>
</div>
<div class="form-group">
<label for="name" class="col-sm-2 control-label">Phone</label>
<div class="col-sm-12">
<input type="text" class="form-control" id="name" name="name" placeholder="Enter Employee Phone" maxlength="50" required="">
</div>
</div>
<div class="form-group">
<label class="col-sm-2 control-label">Address</label>
<div class="col-sm-12">
<input type="text" class="form-control" id="address" name="address" placeholder="Enter Employee Address" required="">
</div>
</div>
<div class="col-sm-offset-2 col-sm-10">
<button type="submit" class="btn btn-primary" id="btn-save">Submit
</button>
</div>
</form>
</div>
<div class="modal-footer">
</div>
</div>
</div>
</div>
<!-- end bootstrap model -->
</body>
<script type="text/javascript">
$(document).ready( function () {
$.ajaxSetup({
headers: {
'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
}
});
$('#ajax-crud-datatable').DataTable({
processing: true,
serverSide: true,
ajax: "{{ url('ajax-crud-datatable') }}",
columns: [
{ data: 'name', name: 'name' },
{ data: 'designation', name: 'designation' },
{ data: 'email', name: 'email' },
{ data: 'address', name: 'address' },
{ data: 'phone', name: 'phone' },
{data: 'action', name: 'action', orderable: false},
],
order: [[0, 'desc']]
});
});
function add(){
$('#EmployeeForm').trigger("reset");
$('#EmployeeModal').html("Add Employee");
$('#employee-modal').modal('show');
$('#id').val('');
}   
function editFunc(id){
$.ajax({
type:"POST",
url: "{{ url('edit-employee') }}",
data: { id: id },
dataType: 'json',
success: function(res){
$('#EmployeeModal').html("Edit Employee");
$('#employee-modal').modal('show');
$('#id').val(res.id);
$('#name').val(res.name);
$('#address').val(res.address);
$('#email').val(res.email);
}
});
}  
function deleteFunc(id){
if (confirm("Delete Record?") == true) {
var id = id;
// ajax
$.ajax({
type:"POST",
url: "{{ url('delete-employee') }}",
data: { id: id },
dataType: 'json',
success: function(res){
var oTable = $('#ajax-crud-datatable').dataTable();
oTable.fnDraw(false);
}
});
}
}
$('#EmployeeForm').submit(function(e) {
e.preventDefault();
var formData = new FormData(this);
$.ajax({
type:'POST',
url: "{{ url('store-employee')}}",
data: formData,
cache:false,
contentType: false,
processData: false,
success: (data) => {
$("#employee-modal").modal('hide');
var oTable = $('#ajax-crud-datatable').dataTable();
oTable.fnDraw(false);
$("#btn-save").html('Submit');
$("#btn-save"). attr("disabled", false);
},
error: function(data){
console.log(data);
}
});
});
</script>
</html>