@extends('front.layout.pages-layout')
@section('title', isset($pageTitle) ? $pageTitle : 'Contact')
@section('content')
    <section class="section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumbs mb-4"> <a href="index.html">Home</a>
                        <span class="mx-1">/</span> <a href="#!">Contact</a>
                    </div>
                    @if (Session::has('success'))
                        <div class="alert alert-success">
                            {{ Session::get('success') }}
                        </div>
                    @elseif(Session::has('error'))
                        <div class="alert alert-danger">
                            {{ Session::get('success') }}
                        </div>
                    @endif
                </div>
                <div class="col-lg-4">
                    <div class="pr-0 pr-lg-4">
                        <div class="content">Hi, dont hesiate to send a message with contructive feedback, all yours
                            wondering put on the message form.
                            <div class="mt-5">
                                <p class="h3 mb-3 font-weight-normal"><a class="text-dark"
                                        href="mailto:hello@reporter.com">ersalomo2002@gmail.com</a>
                                </p>
                                <p class="mb-3"><a class="text-dark" href="tel:+211234565523">+6285270430926</a>
                                </p>
                                <p class="mb-2">Kalideres, DKI Jakarta Barat.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 mt-4 mt-lg-0">
                    <form method="POST" action="{{ route('send_msg') }}" class="row" id="form-contact">
                        @csrf
                        <div class="col-md-6">
                            <label for="" class="form-label">
                                <input type="text" class="form-control mb-4" placeholder="Name" name="name"
                                    id="name">
                                @error('name')
                                    <em class="text-danger">{{ $message }}</em>
                                @enderror
                            </label>
                        </div>
                        <div class="col-md-6">
                            <input type="email" class="form-control mb-4" placeholder="Email" name="email"
                                id="email">
                            @error('email')
                                <em class="text-danger">{{ $message }}</em>
                            @enderror
                        </div>
                        <div class="col-12">
                            <input type="text" class="form-control mb-4" placeholder="Subject" name="subject"
                                id="subject">
                            @error('subject')
                                <em class="text-danger">{{ $message }}</em>
                            @enderror
                        </div>
                        <div class="col-12">
                            <textarea name="message" id="message" class="form-control mb-4" placeholder="Type You Message Here" rows="5"></textarea>
                            @error('message')
                                <em class="text-danger">{{ $message }}</em>
                            @enderror
                        </div>
                        <div class="col-12">
                            <button class="btn btn-outline-primary" type="submit">Send Message</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@stop
@push('scripts')
    {{-- <script>
        document.querySelector('form#form-contact').addEventListener('submit', (e) => {
            e.preventDefault();
            if (!navigator.onLine) {
                alert('You lost your connection')
            }
            alert('sucess')
        })
    </script> --}}
@endpush
