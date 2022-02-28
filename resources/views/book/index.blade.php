@extends('layouts.base')

@section('content')
<div class="container-fluid">
    <!-- Page-Title -->
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="row">
                    <div class="col">
                        <h4 class="page-title">Books</h4>
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
                    <div class="card-title mt-4">Books
                        <a href="" data-toggle="modal" data-target="#addBook" id="addBookButton" class="btn btn-primary" style="float:right;margin-left: 10px"><i class="fa fa-plus"></i> New Book </a>
                    </div>
                </div>
                <!--end card-header-->
                <div class="card-body">
                    <div class="alert alert-success border-0" style="display: none" role="alert" id="success_alert"></div>
                    <div class="alert alert-danger border-0" style="display: none" role="alert" id="warning_alert"></div>
                    <div class="table-responsive">
                        <table class="table table-bordered mb-0 table-centered">
                            <thead>
                                <tr>
                                    <th width="5%">#</th>
                                    <th width="20%">Title</th>
                                    <th>Child Video</th>
                                    <th>Mouth Video</th>
                                    <th>Image</th>
                                    <th>Story Text</th>
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
<div class="modal fade" id="addBook" tabindex="-1" role="dialog" aria-labelledby="addBookLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title m-0" id="addBookLabel">Book Detail</h6>
                <button type="button" class="close " data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="la la-times"></i></span>
                </button>
            </div>
            <!--end modal-header-->
            <form method="post" id="addBookForm">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="title" class="col-form-label text-right">Title</label>
                                <input class="form-control" type="text" name="title" id="title">
                                <span class="text-danger error-text title_error"></span>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="body" class="col-form-label text-right">Child Video</label>
                                <input class="form-control" type="text" name="body" id="body">
                                <span class="text-danger error-text body_error"></span>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="body" class="col-form-label text-right">Mouth Video</label>
                                <input class="form-control" type="text" name="body" id="body">
                                <span class="text-danger error-text body_error"></span>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="body" class="col-form-label text-right">Image</label>
                                <input class="form-control" type="text" name="body" id="body">
                                <span class="text-danger error-text body_error"></span>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="body" class="col-form-label text-right">Story Text</label>
                                <input class="form-control" type="text" name="body" id="body">
                                <span class="text-danger error-text body_error"></span>
                            </div>
                        </div>
                    </div>
                    <!--end row-->
                </div>
                <!--end modal-body-->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary btn-sm">Save</button>
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

        fetchBooks();

        function fetchBooks() {
            $.ajax({
                type: "GET",
                url: "fetchBooks",
                dataType: "json",
                success: function(response) {
                    $('tbody').html("");
                    $.each(response.books, function(key, book) {
                        $('tbody').append('<tr>\
                            <td>' + book.id + '</td>\
                            <td>' + book.title + '</td>\
                            <td>' + book.childVideo + '</td>\
                            <td>' + book.mouthVideo + '</td>\
                            <td>' + book.image + '</td>\
                            <td>' + book.storyText + '</td>\
                    </tr>');
                    });
                }
            });
        }

        $(document).on('submit', '#addBookForm', function(e) {
            e.preventDefault();
            let formDate = new FormData($('#addBookForm')[0]);
            $.ajax({
                type: "post",
                url: "book",
                data: formDate,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    $(document).find('span.error-text').text('');
                },
                success: function(response) {
                    if (response.status == 0) {
                        $('#addBook').modal('show')
                        $.each(response.error, function(prefix, val) {
                            $('span.' + prefix + '_error').text(val[0]);
                        });
                    } else {
                        $('#addBookForm')[0].reset();
                        $('#addBook').modal('hide');
                        fetchNotifications();
                        $('#success_alert').html('<strong>Success! </strong>' + response.message)
                        $('#success_alert').css('display', 'block')
                        setTimeout(function() {
                            $('#success_alert').css('display', 'none')
                        }, 5000)
                    }
                },
                error: function(error) {
                    $('#addBook').modal('show');
                    $('#warning_alert').html('<strong>Warning! </strong>' + error.message)
                    $('#warning_alert').css('display', 'block')
                    setTimeout(function() {
                        $('#warning_alert').css('display', 'none')
                    }, 5000)
                }
            });
        });
    });
</script>
@endsection