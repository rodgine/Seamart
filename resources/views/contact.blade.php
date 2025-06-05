@extends('layouts.app')

@section('content')
    <section class="container py-5">
        <div class="text-center mb-4">
            <h2 class="fw-bold">TALK TO US</h2>
            <p>For any inquiries, feedback, or anything you’d like us to know, please email us using the form below.</p>
            <p>We’ll get in touch the soonest we can.</p>
        </div>

        <form action="#" method="POST">
            @csrf

            <div class="mb-3">
                <input type="text" name="name" class="form-control rounded-pill" placeholder="Name (required)" required>
            </div>

            <div class="mb-3">
                <input type="email" name="email" class="form-control rounded-pill" placeholder="Email (required)"
                    required>
            </div>

            <div class="mb-3">
                <input type="text" name="subject" class="form-control rounded-pill" placeholder="Subject (required)"
                    required>
            </div>

            <div class="mb-3">
                <input type="text" name="order_number" class="form-control rounded-pill"
                    placeholder="Order Number (optional)">
            </div>

            <div class="mb-3">
                <textarea name="message" class="form-control rounded-4" placeholder="Message (required)" rows="6" required></textarea>
            </div>

            <button type="submit" class="btn btn-dark border rounded-1">SUBMIT</button>
        </form>
    </section>
@endsection
