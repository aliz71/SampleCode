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
                                           placeholder="Book title"
                                           required>
                                </div>
                                <div class="col-md-6 form-group mt-3 mt-md-0">
                                    <input type="text" class="form-control" name="author" id="author"
                                           placeholder="Book author" required>
                                </div>
                            </div>
                            <div class="form-group mt-3">
                            </div>
                            <div class="my-3">
                                <div class="loading">Loading</div>
                                <div class="error-message"></div>
                                <div class="sent-message">Your message has been sent. Thank you!</div>
                            </div>
                            <div class="text-center">
                                <button type="submit" onclick="createBook()">Send</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section><!-- End Test Section -->
    </main><!-- End #main -->

@endsection

@section('scripts')
    <script>
        $.ajaxSetup({
            headers:
                {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
        });

        function createBook() {
            let title = $('#title').val();
            let author = $('#author').val();
            $.post('{{ route('books.store') }}', {title: title, author: author}, function (data) {
                console.log(data);
            }).fail(function (e) {
                console.log(e.responseJSON);
            });
        }
    </script>
@endsection
