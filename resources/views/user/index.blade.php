@extends('layouts.base')

@section('content')
<div class="container-fluid">
    <!-- Page-Title -->
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="row">
                    <div class="col">
                        <h4 class="page-title">Users</h4>
                    </div>
                    <!--end col-->
                </div>
                <!--end row-->
            </div>
            <!--end page-title-box-->
        </div>
        <!--end col-->
    </div>
    <!--end row-->
    <!-- end page title end breadcrumb -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title mt-4">Users
                    </div>
                </div>
                <!--end card-header-->
                <div class="card-body">
                    <div class="alert alert-danger border-0" style="display: none" role="alert" id="warning_alert"></div>
                    <div class="table-responsive">
                        <table class="table table-bordered mb-0 table-centered">
                            <thead>
                                <tr>
                                    <th width="5%">#</th>
                                    <th width="20%">Name</th>
                                    <th>Email</th>
                                    <th width="20%">Age</th>
                                    <th width="3%"><i class="fa fa-trash"></i></th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                        <!--end /table-->
                    </div>
                    <!--end /tableresponsive-->
                </div>
                <!--end card-body-->
            </div>
            <!--end card-->
        </div> <!-- end col -->
    </div> <!-- end row -->
</div>
<!-- Modal -->
<div class="modal fade" id="deleteUser" tabindex="-1" role="dialog" aria-labelledby="deleteUserLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title m-0" id="deleteUserLabel">Delete</h6>
                <button type="button" class="close " data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="la la-times"></i></span>
                </button>
            </div>
            <!--end modal-header-->
            <form method="post" id="deleteUserForm">
                @csrf
                @method('DELETE')
                <div class="modal-body">
                    <div class="row">
                        <input type="hidden" id="user_id" name="user_id">
                        <p class="mb-4">Are you sure want to delete?</p>
                    </div>
                    <!--end row-->
                </div>
                <!--end modal-body-->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary btn-sm">Yes</button>
                </div>
                <!--end modal-footer-->
            </form>
        </div>
        <!--end modal-content-->
    </div>
    <!--end modal-dialog-->
</div>

<script>
    $(document).ready(function() {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        fetchUsers();

        function fetchUsers() {
            $.ajax({
                type: "GET",
                url: "fetchUsers",
                dataType: "json",
                success: function(response) {
                    $('tbody').html("");
                    $.each(response.users, function(key, user) {
                        $('tbody').append('<tr>\
                            <td>' + user.id + '</td>\
                            <td>' + user.name + '</td>\
                            <td>' + user.email + '</td>\
                            <td>' + user.age + '</td>\
                            <td><button value="' + user.id + '" style="border: none; background-color: #fff" class="delete_btn"><i class="fa fa-trash"></i></button></td>\
                    </tr>');
                    });
                }
            });
        }

        $(document).on('click', '.delete_btn', function(e) {
            e.preventDefault();
            var user_id = $(this).val();
            $('#deleteUser').modal('show');
            $('#user_id').val(user_id)
        });

        $(document).on('submit', '#deleteUserForm', function(e) {
            e.preventDefault();
            var user_id = $('#user_id').val();

            $.ajax({
                type: 'delete',
                url: 'user/' + user_id,
                dataType: 'json',
                success: function(response) {
                    if (response.status == 0) {
                        $('#deleteUser').modal('hide');
                        $('#warning_alert').html('<strong>Warning! </strong>' + response.message)
                        $('#warning_alert').css('display', 'block')
                        setTimeout(function() {
                            $('#warning_alert').css('display', 'none')
                        }, 5000)
                    } else {
                        fetchUsers();
                        $('#deleteUser').modal('hide');
                        $('#warning_alert').html('<strong>Warning! </strong>' + response.message)
                        $('#warning_alert').css('display', 'block')
                        setTimeout(function() {
                            $('#warning_alert').css('display', 'none')
                        }, 5000)
                    }
                }
            });
        });
    });
</script>
@endsection