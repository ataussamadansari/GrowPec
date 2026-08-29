@extends('admin.layout')
@section('title', 'Admin Dashboard - GrowPec')
@section('header', 'Dashboard Overview')

@section('content')
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="stat-card shadow-sm border-start border-primary border-4">
            <small class="text-muted fw-bold">TOTAL COLLEGES</small>
            <h2 class="fw-bold text-dark mt-1 mb-0">{{ $stats['total_colleges'] }}</h2>
            <small class="text-primary">{{ $stats['regular_colleges'] }} Regular • {{ $stats['online_colleges'] }} Online</small>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card shadow-sm border-start border-warning border-4">
            <small class="text-muted fw-bold">TOTAL LEADS</small>
            <h2 class="fw-bold text-dark mt-1 mb-0">{{ $stats['total_leads'] }}</h2>
            <small class="text-success">+{{ $stats['new_leads_today'] }} Today</small>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card shadow-sm border-start border-success border-4">
            <small class="text-muted fw-bold">TOTAL COURSES</small>
            <h2 class="fw-bold text-dark mt-1 mb-0">{{ $stats['total_courses'] }}</h2>
            <small class="text-muted">UG, PG, Diplomas</small>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card shadow-sm border-start border-info border-4">
            <small class="text-muted fw-bold">QUICK ACTIONS</small>
            <div class="mt-2">
                <a href="{{ route('admin.colleges.create') }}" class="btn btn-warning btn-sm fw-bold w-100 mb-1">+ Add New College</a>
                <a href="{{ route('admin.leads.export') }}" class="btn btn-outline-dark btn-sm fw-bold w-100">📥 Export Leads CSV</a>
            </div>
        </div>
    </div>
</div>

<!-- Recent Leads Table -->
<div class="bg-white p-4 rounded-4 shadow-sm border">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="fw-bold mb-0">🔥 Recent Student Inquiries</h5>
        <a href="{{ route('admin.leads.index') }}" class="btn btn-sm btn-outline-primary">View All Leads</a>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Student Name</th>
                    <th>Phone / WhatsApp</th>
                    <th>College / Course</th>
                    <th>City</th>
                    <th>Status</th>
                    <th>Received</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentLeads as $lead)
                    <tr>
                        <td class="fw-bold">{{ $lead->name }}</td>
                        <td><a href="https://wa.me/91{{ preg_replace('/[^0-9]/', '', $lead->phone) }}" target="_blank" class="text-success text-decoration-none"><i class="bi bi-whatsapp me-1"></i>{{ $lead->phone }}</a></td>
                        <td>{{ $lead->college->name ?? 'General' }} <small class="text-muted d-block">{{ $lead->course->name ?? '' }}</small></td>
                        <td>{{ $lead->city ?? 'N/A' }}</td>
                        <td>
                            <span class="badge bg-{{ $lead->status == 'new' ? 'danger' : ($lead->status == 'admitted' ? 'success' : 'warning') }}-subtle text-dark">
                                {{ strtoupper($lead->status) }}
                            </span>
                        </td>
                        <td><small class="text-muted">{{ $lead->created_at->diffForHumans() }}</small></td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-3 text-muted">No student inquiries received yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection