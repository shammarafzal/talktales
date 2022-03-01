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
                                    <th width="3%"><i class="flaticon2-edit"></i></th>
                                    <th width="3%"><i class="flaticon2-delete"></i></th>
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
                                <label>Mouth Video</label>
                                <div></div>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="mouthVideo" name="mouthVideo">
                                    <label class="custom-file-label" for="mouthVideo">Choose Mouth Video</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>Child Video</label>
                                <div></div>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="childVideo" name="childVideo">
                                    <label class="custom-file-label" for="childVideo">Choose Child Video</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>Image</label>
                                <div></div>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="image" name="image">
                                    <label class="custom-file-label" for="image">Choose Image</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="storyText" class="col-form-label text-right">Story Text</label>
                                <input class="form-control" type="text" name="storyText" id="storyText">
                                <span class="text-danger error-text storyText_error"></span>
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
<div class="modal fade" id="editBook" tabindex="-1" role="dialog" aria-labelledby="editBookLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editBookLabel">Book</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <form method="post" id="editBookForm" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                <div class="modal-body">
                    <div class="row">
                        <input type="hidden" name="id" id="id">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="edit_title" class="col-form-label text-right">Title</label>
                                <input class="form-control" type="text" name="title" id="edit_title">
                                <span class="text-danger error-text edit_title_error"></span>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>Mouth Video</label>
                                <div></div>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="edit_mouthVideo" name="mouthVideo">
                                    <label class="custom-file-label" for="edit_mouthVideo">Choose Mouth Video</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>Child Video</label>
                                <div></div>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="edit_childVideo" name="childVideo">
                                    <label class="custom-file-label" for="edit_childVideo">Choose Child Video</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>Image</label>
                                <div></div>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="edit_image" name="image">
                                    <label class="custom-file-label" for="edit_image">Choose Image</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="edit_storyText" class="col-form-label text-right">Story Text</label>
                                <input class="form-control" type="text" name="storyText" id="edit_storyText">
                                <span class="text-danger error-text edit_storyText_error"></span>
                            </div>
                        </div>
                    </div>
                    <!--end row-->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="deleteBook" tabindex="-1" role="dialog" aria-labelledby="deleteBookLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteBookLabel">Delete</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <form method="post" id="deleteBookForm">
                @csrf
                @method('DELETE')
                <div class="modal-body">
                    <input type="hidden" name="id" id="id">
                    <div class="kt-portlet__body">
                        <div class="form-group">
                            <label>Are you sure want to delete?</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Yes</button>
                </div>
            </form>
        </div>
    </div>
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
                            <td><video width="180" height="100" controls><source src="storage/' + book.mouthVideo + '"></video></td>\
                            <td><video width="180" height="100" controls><source src="storage/' + book.childVideo + '"></video></td>\
                            <td><img src="storage/' + book.image + '" alt="" width="180" height="100"></td>\
                            <td>' + book.storyText + '</td>\
                            <td><button value="' + book.id + '" style="border: none; background-color: #fff" class="edit_btn"><i class="fa fa-edit"></i></button></td>\
                            <td><button value="' + book.id + '" style="border: none; background-color: #fff" class="delete_btn"><i class="fa fa-trash"></i></button></td>\
                    </tr>');
                    });
                }
            });
        }
        $(document).on('click', '.delete_btn', function(e) {
            e.preventDefault();
            var id = $(this).val();
            $('#deleteBook').modal('show');
            $('#id').val(id)
        });

        $(document).on('submit', '#deleteBookForm', function(e) {
            e.preventDefault();
            var id = $('#id').val();

            $.ajax({
                type: 'delete',
                url: 'book/' + id,
                dataType: 'json',
                success: function(response) {
                    if (response.status == 0) {
                        $('#deleteBook').modal('hide');
                    } else {
                        fetchBooks();
                        $('#deleteBook').modal('hide');
                    }
                }
            });
        });

        $(document).on('click', '.edit_btn', function(e) {
            e.preventDefault();
            var id = $(this).val();
            $('#editBook').modal('show');
            $(document).find('span.error-text').text('');
            $.ajax({
                type: "GET",
                url: 'book/' + id + '/edit',
                success: function(response) {
                    if (response.status == 404) {
                        $('#editBook').modal('hide');
                    } else {
                        $('#id').val(response.book.id);
                        $('#edit_title').val(response.book.title);
                        $('#edit_childVideo').val(response.book.childVideo);
                        $('#edit_mouthVideo').val(response.book.mouthVideo);
                        $('#edit_image').val(response.book.image);
                        $('#edit_storyText').val(response.book.storyText);
                    }
                }
            });
        });

        $(document).on('submit', '#editBookForm', function(e) {
            e.preventDefault();
            var id = $('#id').val();
            let EditFormData = new FormData($('#editBookForm')[0]);

            $.ajax({
                type: "post",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content'),
                    '_method': 'patch'
                },
                url: "book/" + id,
                data: EditFormData,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    $(document).find('span.error-text').text('');
                },
                success: function(response) {
                    if (response.status == 0) {
                        $('#editBook').modal('show')
                        $.each(response.error, function(prefix, val) {
                            $('span.' + prefix + '_update_error').text(val[0]);
                        });
                    } else {
                        $('#editBookForm')[0].reset();
                        $('.custom-file-label').text('Choose File');
                        $('#editBook').modal('hide');
                        fetchMeditations();
                    }
                },
                error: function(error) {
                    console.log(error)
                    $('#editBook').modal('show');
                }
            });
        })
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