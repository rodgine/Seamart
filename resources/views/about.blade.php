@extends('layouts.app')

@section('content')
    <section>
        <div class="container">
            <div class="d-flex flex-column justify-content-center align-items-center">
                <h2 class="roboto-slab-hero-title mt-4">
                    SEAMART: GONZAGA'S ONLINE FISH MARKET
                </h2>
                <p>Posted by CSU Gonzaga IT Student | May 2025</p>
            </div>
            <hr />

            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12 py-4">
                    <img src="{{ asset('admin-assets/assets/images/logos/about.jpg') }}" {{-- Update this path as needed --}}
                        class="d-block w-100" alt="Seamart Banner" style="height: 800px;" />
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <p class="py-4 about-text text-justify">
                        Seamart is an innovative e-commerce platform developed as part of the
                        academic requirements of the
                        Bachelor of Science in Information Technology students at Cagayan State University – Gonzaga Campus.
                        This system serves as an online marketplace for fresh, dried, and preserved fish products,
                        connecting
                        local fishermen and vendors with consumers in a convenient and accessible digital environment.
                        <br><br>
                        Designed with user experience in mind, Seamart allows buyers to explore
                        categories, view detailed
                        product information, and complete secure checkouts—all from the comfort of their homes.
                        <br><br>
                        The project embodies the spirit of technological innovation while supporting
                        the local fishing
                        industry
                        of Gonzaga and nearby coastal communities.
                        As a student-led initiative, Seamart demonstrates the practical application of web development,
                        database
                        design, and user-centered systems analysis taught at CSU Gonzaga.
                    </p>
                    <div class="all-products-description mb-4">
                        <p>
                            Seamart is more than just a school project—it's a vision for digital transformation in local
                            markets.
                            Whether you're a local buyer, business owner, or simply exploring fresh seafood options, Seamart
                            brings Gonzaga’s finest fish to your fingertips.
                            Seamart gives local fish vendors a platform to reach more customers online, increasing
                            visibility and sales while reducing the need for physical stalls.
                            Customers enjoy a smooth and secure shopping experience, complete with real-time product
                            listings, stock updates, and promo discounts.
                        </p>

                        <div class="collapse" id="readMoreContent">
                            <p>
                                <b>Built for the Community</b><br>
                                The system was designed with Gonzaga’s fishing community in mind. It highlights local
                                products
                                and ensures every sale supports the livelihood of hardworking vendors and fishers.
                                <br>
                                <b>Academic Excellence in Action</b><br>
                                Seamart showcases the knowledge and technical skills of IT students from CSU Gonzaga. It is
                                a
                                testament to what young minds can build when guided by innovation, purpose, and passion.
                            </p>
                        </div>

                        <div class="read-more-link text-start">
                            <a href="#" data-bs-toggle="collapse" data-bs-target="#readMoreContent"
                                aria-expanded="false" aria-controls="readMoreContent">
                                Read More
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
