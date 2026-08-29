@extends('admin.layout')
@section('title', 'Leads CRM - GrowPec')
@section('header', 'Student Leads Management')

@section('content')
<div class="bg-white p-4 rounded-4 shadow-sm border">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
        <form action="{{ route('admin.leads.index') }}" method="GET" class="d-flex gap-2">
            <input type="text" name="search" value="{{ request('search') }}" class="form-control form-control-sm" placeholder="Search by name, phone, city...">
            <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                <option value="">All Statuses</option>
                @foreach(['new', 'contacted', 'counseling', 'admitted', 'closed'] as $st)
                    <option value="{{ $st }}" {{ request('status') == $st ? 'selected' : '' }}>{{ ucfirst($st) }}</option>
                @endforeach
            </select>
            <button type="submit" class="btn btn-sm btn-dark">Filter</button>
        </form>

        <a href="{{ route('admin.leads.export') }}" class="btn btn-sm btn-success fw-bold">
            <i class="bi bi-file-earmark-spreadsheet me-1"></i> Export to Excel (CSV)
        </a>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Student Name</th>
                    <th>Phone / WhatsApp</th>
                    <th>City</th>
                    <th>Target College</th>
                    <th>Status</th>
                    <th>Update Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($leads as $lead)
                    <tr>
                        <td>{{ $lead->id }}</td>
                        <td class="fw-bold">{{ $lead->name }} <small class="text-muted d-block">{{ $lead->email }}</small></td>
                        <td>
                            <a href="https://wa.me/91{{ preg_replace('/[^0-9]/', '', $lead->phone) }}" target="_blank" class="btn btn-sm btn-outline-success py-0 px-2">
                                <i class="bi bi-whatsapp me-1"></i>{{ $lead->phone }}
                            </a>
                        </td>
                        <td>{{ $lead->city ?? 'N/A' }}</td>
                        <td>{{ $lead->college->name ?? 'General Inquiry' }}</td>
                        <td>
                            <span class="badge bg-{{ $lead->status == 'new' ? 'danger' : ($lead->status == 'admitted' ? 'success' : 'warning') }}">
                                {{ strtoupper($lead->status) }}
                            </span>
                        </td>
                        <td>
                            <form action="{{ route('admin.leads.updateStatus', $lead->id) }}" method="POST" class="d-flex gap-1">
                                @csrf
                                <select name="status" class="form-select form-select-sm" style="width: 120px;" onchange="this.form.submit()">
                                    @foreach(['new', 'contacted', 'counseling', 'admitted', 'closed'] as $st)
                                        <option value="{{ $st }}" {{ $lead->status == $st ? 'selected' : '' }}>{{ ucfirst($st) }}</option>
                                    @endforeach
                                </select>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-4 text-muted">No leads found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-center mt-3">
        {{ $leads->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection