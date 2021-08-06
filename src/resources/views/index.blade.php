@extends('Layouts.master')

@section('content')
    <!-- ======= Hero Section ======= -->
    <section id="hero">
        <div class="hero-container">
            <h3>Welcome to <strong>Ali Zahedi Test</strong></h3>
            <h1>Ali Zahedi Test</h1>
            <h2>This test is for Yaraku Company</h2>
            <a href="#test" class="btn-get-started scrollto">Get Started</a>
        </div>
    </section><!-- End Hero -->

    <main id="main">
        <!-- ======= Test Section ======= -->
        <section id="test" class="contact">
            <div class="container">
                <div class="section-title">
                    <h2>Test</h2>
                    <p>You can control books from here</p>
                </div>
                <div class="row mt-5">
                    <div class="col-lg-2">
                    </div>
                    <div class="col-lg-8 mt-5 mt-lg-0">
                        <form role="form" class="php-email-form">
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <input type="text" name="title" class="form-control" id="title"
                                           placeholder="Book title">
                                </div>
                                <div class="col-md-6 form-group mt-3 mt-md-0">
                                    <input type="text" class="form-control" name="author" id="author"
                                           placeholder="Book author">
                                </div>
                            </div>
                            <div class="form-group mt-3">
                            </div>
                            <div class="my-2">
                                <div class="error-message"></div>
                            </div>
                            <div class="text-center">
                                <button type="button" onclick="createBook()">Create new book</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="row mt-5">
                    <div class="col-lg-2">
                    </div>
                    <div class="col-lg-8 mt-5 mt-lg-0">
                        <table id="books" class="display" style="width:100%">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Title</th>
                                <th>Author</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </section><!-- End Test Section -->
    </main><!-- End #main -->

    @component('components.editModal')
    @endcomponent

    @component('components.deleteModal')
    @endcomponent

@endsection

@section('scripts')
    <script>
        $.ajaxSetup({
            headers:
                {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
        });

        var table = $('#books').DataTable({
            bLengthChange: false,
            order: [[0, "desc"]],
            ajax: {
                "url": '{{ route('books.index') }}',
                "type": "GET"
            },
            columns: [
                {data: 'id'},
                {data: 'title'},
                {data: 'author'},
                {data: 'buttons'}
            ],
            columnDefs: [{
                targets: [-1], render: function (data, type, row) {
                    return '<button type="button" class="btn btn-primary btn-xs" onclick="editModal(\'' + row.title + '\', \'' + row.author + '\', ' + row.id + ')">Edit</button> '
                        + '<button type="button" class="btn btn-danger btn-xs" onclick="deleteModal(' + row.id + ')">Delete</button>';
                }
            }],
        });

        function createBook() {
            $('.error-message').html(null).hide();
            let title = $('#title').val();
            let author = $('#author').val();
            $.post('{{ route('books.store') }}', {title: title, author: author}, function () {
                swal("Good job!", "Successfully created.", "success");
                table.ajax.reload();
            }).fail(function (e) {
                $('.error-message').append(createErrorMessage(e.responseJSON)).show();
            });
        }

        function updateBook() {
            $('.edit-error-message').html(null).hide();
            let title = $('#edit-book-title').val();
            let author = $('#edit-book-author').val();
            let id = $('#edit-book-id').val();
            $.post('{{ url('books') }}/' + id, {title: title, author: author, _method: 'PATCH'}, function () {
                swal("Good job!", "Successfully updated.", "success");
                $('#editBookModal').modal('hide');
                table.ajax.reload(null, false);
            }).fail(function (e) {
                $('.edit-error-message').append(createErrorMessage(e.responseJSON)).show();
            });
        }

        function deleteBook() {
            $('.delete-error-message').html(null).hide();
            let id = $('#delete-book-id').val();
            $.post('{{ url('books') }}/' + id, {_method: 'DELETE'}, function () {
                swal("Good job!", "Successfully deleted.", "success");
                $('#deleteBookModal').modal('hide');
                table.ajax.reload(null, false);
            }).fail(function (e) {
                $('.delete-error-message').append(createErrorMessage(e.responseJSON)).show();
            });
        }

        function createErrorMessage(e) {
            let errormessage = `<ul>`;
            if (typeof e === 'object') {
                for (const property in e.error) {
                    errormessage += `<li>`;
                    errormessage += `${e.error[property]}`;
                    errormessage += `</li>`;
                }
            }
            errormessage += `</ul>`;
            return errormessage;
        }

        function editModal(title, author, id) {
            $('.edit-error-message').html(null).hide();
            $('#edit-book-title').val(title);
            $('#edit-book-author').val(author);
            $('#edit-book-id').val(id);
            $('#editBookModal').modal('show');
        }

        function deleteModal(id) {
            $('.delete-error-message').html(null).hide();
            $('#delete-book-id').val(id);
            $('#deleteBookModal').modal('show');
        }

    </script>
@endsection
