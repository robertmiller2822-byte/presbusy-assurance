@extends('layouts.app')

@section('title', 'Our Team - Prestbury Assurance Partners')

@section('content')
<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto text-center">
                <h1 class="fw-bold mb-4" style="color: var(--primary);">Meet Our Team</h1>
                <p class="lead" style="color: var(--gold);">
                    Dedicated professionals committed to your success.
                </p>
            </div>
        </div>
        <div class="row g-4 mt-4">
            @php
                $team = [
                    ['James Bellwood', 'CEO / Founder', 'james-bellwood', 'Leading the team with decades of experience in insurance and estate claims.'],
                    ['Andrew Bellwood', 'Lawyer', 'andrew-bellwood', 'Expert legal representation for complex claims.'],
                    ['Marylin Sheppard', 'General Counsel / Chief Legal', 'marylin-sheppard', 'Overseeing all legal and compliance matters.'],
                    ['Sarah Cannellini', 'Head of Customer Service', 'sarah-cannellini', 'Ensuring exceptional client support and satisfaction.'],
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
                            <p class="card-text small">{{ $member[3] }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endsection