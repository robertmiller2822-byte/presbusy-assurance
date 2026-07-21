@extends('layouts.app')

@section('title', 'Practice Areas - Prestbury Assurance Partners')

@section('content')
<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <h1 class="fw-bold mb-4" style="color: var(--primary);">Our Practice Areas</h1>
                <p class="lead" style="color: var(--gold);">
                    We provide expert guidance across a wide range of insurance and estate claims.
                </p>
                <div class="row g-4 mt-4">
                    @php
                        $areas = [
                            ['Inheritance and Estate Claims', 'fa-balance-scale', 'Expert guidance on inheritance and estate claims.'],
                            ['Beneficiary Representation', 'fa-users', 'Protecting the rights of beneficiaries.'],
                            ['Probate and Insurance Administration Support', 'fa-file-signature', 'Support through probate and insurance processes.'],
                            ['Unclaimed Asset Recovery', 'fa-search-dollar', 'Recovering unclaimed assets on your behalf.'],
                            ['Cross-Border Inheritance Claims', 'fa-globe', 'Handling inheritance claims across borders.'],
                            ['Insurance Claim Assessment and Processing', 'fa-clipboard-check', 'Assessing and processing insurance claims.'],
                            ['Legal Expenses Insurance', 'fa-gavel', 'Coverage for legal expenses.'],
                            ['Dispute Resolution and Claims Negotiation', 'fa-handshake', 'Negotiating and resolving disputes.'],
                            ['Fraud Prevention and Compliance', 'fa-shield-alt', 'Preventing fraud and ensuring compliance.'],
                            ['Client Advisory and Claims Management', 'fa-chart-line', 'Advisory and management services.'],
                        ];
                    @endphp
                    @foreach ($areas as $area)
                        <div class="col-md-6">
                            <div class="card h-100 border-0 shadow-sm p-3">
                                <div class="card-body">
                                    <i class="fas {{ $area[1] }} fa-2x gold-text mb-3"></i>
                                    <h5 class="card-title">{{ $area[0] }}</h5>
                                    <p class="card-text text-muted">{{ $area[2] }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="mt-5 text-center">
                    <a href="/contact" class="btn btn-gold">Contact Us for More Information</a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection