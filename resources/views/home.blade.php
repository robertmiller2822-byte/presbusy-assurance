@extends('layouts.app')

@section('title', 'Home - Presbusy Assurance Partners')

@section('content')
    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <h1>
                        Claim Your <span class="gold-text">Legacy</span>.<br>
                        Secure Your <span class="gold-text">Future</span>.
                    </h1>
                    <p>
                        Professional insurance and estate claims specialists.
                        We handle the complex so you can focus on what matters.
                    </p>
                    <div class="d-flex flex-wrap gap-3">
                        <a href="/contact" class="btn btn-gold">Book Consultation</a>
                        <a href="/about" class="btn btn-outline-gold">Learn More</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section (Exact text from your PDF) -->
    <section class="py-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h2 class="fw-bold">About Us</h2>
                    <p class="lead" style="color: var(--primary);">
                        Presbusy commitment is to stand by your side, protect your rights, and pursue every inheritance claim with the highest standards of integrity, professionalism, and dedication.
                    </p>
                    <p>
                        We are committed to guiding you through every stage of the claims process while working diligently to achieve a fair and successful resolution.
                    </p>
                    <a href="/about" class="btn btn-gold mt-3">Read More</a>
                </div>
                <div class="col-lg-6">
                    <img src="https://via.placeholder.com/600x400/0B1F3A/D4AF37?text=Presbusy+Assurance" class="img-fluid rounded shadow" alt="About Us">
                </div>
            </div>
        </div>
    </section>

    <!-- Practice Areas (All 10 from your PDF) -->
    <section class="py-5 bg-light">
        <div class="container">
            <h2 class="text-center fw-bold mb-5">Our Practice Areas</h2>
            <div class="row g-4">
                @php
                    $areas = [
                        ['Inheritance and Estate Claims', 'fa-balance-scale'],
                        ['Beneficiary Representation', 'fa-users'],
                        ['Probate and Insurance Administration Support', 'fa-file-signature'],
                        ['Unclaimed Asset Recovery', 'fa-search-dollar'],
                        ['Cross-Border Inheritance Claims', 'fa-globe'],
                        ['Insurance Claim Assessment and Processing', 'fa-clipboard-check'],
                        ['Legal Expenses Insurance', 'fa-gavel'],
                        ['Dispute Resolution and Claims Negotiation', 'fa-handshake'],
                        ['Fraud Prevention and Compliance', 'fa-shield-alt'],
                        ['Client Advisory and Claims Management', 'fa-chart-line'],
                    ];
                @endphp
                @foreach ($areas as $area)
                    <div class="col-md-6 col-lg-4">
                        <div class="card h-100 border-0 shadow-sm text-center p-3">
                            <div class="card-body">
                                <i class="fas {{ $area[1] }} fa-3x gold-text mb-3"></i>
                                <h5 class="card-title">{{ $area[0] }}</h5>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Meet Our Team (4 members) – WITH LOCAL IMAGES -->
    <section class="py-5">
        <div class="container">
            <h2 class="text-center fw-bold mb-5">Meet Our Team</h2>
            <div class="row g-4">
                @php
                    $team = [
                        ['James Bellwood', 'CEO / Founder', 'james-bellwood'],
                        ['Andrew Bellwood', 'Lawyer', 'andrew-bellwood'],
                        ['Marylin Sheppard', 'General Counsel / Chief Legal', 'marylin-sheppard'],
                        ['Sarah Cannellini', 'Head of Customer Service', 'sarah-cannellini'],
                    ];
                @endphp
                @foreach ($team as $member)
                    <div class="col-md-3 col-sm-6">
                        <div class="card border-0 shadow-sm text-center h-100">
                            <div class="card-body">
                                <img src="{{ asset('storage/images/team/' . strtolower(str_replace(' ', '-', $member[0])) . '.jpg') }}"
                                     alt="{{ $member[0] }}"
                                     class="rounded-circle mb-3"
                                     style="width: 120px; height: 120px; object-fit: cover; border: 3px solid var(--gold);"
                                     onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($member[0]) }}&background=0B1F3A&color=D4AF37&size=128&rounded=true&bold=true'">
                                <h5 class="card-title">{{ $member[0] }}</h5>
                                <p class="card-text text-muted small">{{ $member[1] }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section class="py-5" style="background: var(--primary); color: #fff;">
        <div class="container text-center">
            <h2 class="fw-bold">Ready to secure your future?</h2>
            <p class="lead">Contact us today for a free, no‑obligation consultation.</p>
            <a href="/contact" class="btn btn-gold mt-3">Get in Touch</a>
        </div>
    </section>
@endsection