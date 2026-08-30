@extends('admin.layout')
@section('title', 'Manage Locations - GrowPec Admin')
@section('header', 'Location Directory (States & Cities)')

@section('content')
<div class="row g-4">
    <!-- 1. Left Side: States Management (col-lg-5) -->
    <div class="col-lg-5">
        <div class="bg-white p-4 rounded-4 shadow-sm border h-100">
            <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom">
                <div>
                    <h5 class="fw-bold mb-0 text-primary"><i class="bi bi-map me-1"></i> States</h5>
                    <small class="text-muted">{{ $states->count() }} States registered</small>
                </div>
                <button type="button" class="btn btn-sm btn-warning fw-bold shadow-sm" data-bs-toggle="modal" data-bs-target="#addStateModal">
                    <i class="bi bi-plus-circle me-1"></i> + Add State
                </button>
            </div>

            <div class="table-responsive" style="max-height: 600px; overflow-y: auto;">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light sticky-top">
                        <tr>
                            <th>State Name</th>
                            <th>Cities</th>
                            <th>Status</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($states as $st)
                        <tr>
                            <td class="fw-bold text-dark">{{ $st->name }}</td>
                            <td>
                                <a href="{{ route('admin.locations.index', ['state_id' => $st->id]) }}" 
                                   class="badge bg-primary-subtle text-primary border text-decoration-none" 
                                   title="Filter cities by {{ $st->name }}">
                                    {{ $st->cities_count }} Cities <i class="bi bi-arrow-right-short"></i>
                                </a>
                            </td>
                            <td>
                                <span class="badge bg-{{ $st->status ? 'success' : 'secondary' }}-subtle text-dark">
                                    {{ $st->status ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td class="text-end">
                                <button class="btn btn-sm btn-outline-primary py-0 px-2 edit-state-btn" 
                                        data-id="{{ $st->id }}" 
                                        data-name="{{ $st->name }}" 
                                        data-status="{{ $st->status ? '1' : '0' }}" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#editStateModal" 
                                        title="Edit State">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <form action="{{ route('admin.locations.state.destroy', $st->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete state {{ $st->name }}?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger py-0 px-2" title="Delete State">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-4 text-muted">No states added yet.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- 2. Right Side: Cities Management (col-lg-7) -->
    <div class="col-lg-7">
        <div class="bg-white p-4 rounded-4 shadow-sm border h-100">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3 pb-2 border-bottom">
                <div>
                    <h5 class="fw-bold mb-0 text-primary"><i class="bi bi-buildings me-1"></i> Cities</h5>
                    <small class="text-muted">{{ $cities->total() }} Total Cities</small>
                </div>
                <button type="button" class="btn btn-sm btn-warning fw-bold shadow-sm" data-bs-toggle="modal" data-bs-target="#addCityModal">
                    <i class="bi bi-plus-circle me-1"></i> + Add City
                </button>
            </div>

            <!-- Search & State Filter Bar -->
            <form action="{{ route('admin.locations.index') }}" method="GET" class="row g-2 mb-3">
                <div class="col-md-6">
                    <div class="input-group input-group-sm">
                        <span class="input-group-text bg-light"><i class="bi bi-search text-muted"></i></span>
                        <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Search city name...">
                    </div>
                </div>
                <div class="col-md-4">
                    <select name="state_id" class="form-select form-select-sm" onchange="this.form.submit()">
                        <option value="">-- All States --</option>
                        @foreach($states as $st)
                        <option value="{{ $st->id }}" {{ request('state_id') == $st->id ? 'selected' : '' }}>{{ $st->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2 d-flex gap-1">
                    <button type="submit" class="btn btn-sm btn-dark w-100">Filter</button>
                    @if(request('search') || request('state_id'))
                    <a href="{{ route('admin.locations.index') }}" class="btn btn-sm btn-outline-secondary" title="Reset Filters"><i class="bi bi-x"></i></a>
                    @endif
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>City Name</th>
                            <th>State</th>
                            <th>Popular</th>
                            <th>Status</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($cities as $ct)
                        <tr>
                            <td class="fw-bold text-dark">{{ $ct->name }}</td>
                            <td>
                                <span class="badge bg-light text-secondary border">
                                    {{ $ct->state->name ?? 'N/A' }}
                                </span>
                            </td>
                            <td>
                                @if($ct->is_popular)
                                <span class="badge bg-warning-subtle text-dark border">⭐ Popular</span>
                                @else
                                <span class="text-muted small">-</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-{{ $ct->status ? 'success' : 'secondary' }}-subtle text-dark">
                                    {{ $ct->status ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td class="text-end">
                                <button class="btn btn-sm btn-outline-primary py-0 px-2 edit-city-btn" 
                                        data-id="{{ $ct->id }}" 
                                        data-name="{{ $ct->name }}" 
                                        data-state-id="{{ $ct->state_id }}" 
                                        data-popular="{{ $ct->is_popular ? '1' : '0' }}" 
                                        data-status="{{ $ct->status ? '1' : '0' }}" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#editCityModal" 
                                        title="Edit City">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <form action="{{ route('admin.locations.city.destroy', $ct->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete city {{ $ct->name }}?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger py-0 px-2" title="Delete City">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">No cities found matching your criteria.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-3">
                {{ $cities->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>

<!-- ========================================== -->
<!-- MODALS SECTION                             -->
<!-- ========================================== -->

<!-- 1. Add State Modal -->
<div class="modal fade" id="addStateModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="modal-header bg-primary text-white">
                <h6 class="modal-title fw-bold"><i class="bi bi-plus-circle me-1"></i> Add New State</h6>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.locations.state.store') }}" method="POST">
                @csrf
                <div class="modal-body p-3">
                    <label class="form-label small fw-bold">State Name *</label>
                    <input type="text" name="name" class="form-control form-control-sm" placeholder="e.g. Uttar Pradesh, Bihar" required>
                </div>
                <div class="modal-footer p-2 bg-light">
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-sm btn-warning fw-bold">Save State</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- 2. Edit State Modal -->
<div class="modal fade" id="editStateModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="modal-header bg-dark text-white">
                <h6 class="modal-title fw-bold"><i class="bi bi-pencil-square me-1"></i> Edit State</h6>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="editStateForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body p-3">
                    <div class="mb-3">
                        <label class="form-label small fw-bold">State Name *</label>
                        <input type="text" name="name" id="editStateName" class="form-control form-control-sm" required>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="status" value="1" id="editStateStatus">
                        <label class="form-check-label small" for="editStateStatus">Active State</label>
                    </div>
                </div>
                <div class="modal-footer p-2 bg-light">
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-sm btn-warning fw-bold">Update State</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- 3. Add City Modal -->
<div class="modal fade" id="addCityModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="modal-header bg-primary text-white">
                <h6 class="modal-title fw-bold"><i class="bi bi-plus-circle me-1"></i> Add New City</h6>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.locations.city.store') }}" method="POST">
                @csrf
                <div class="modal-body p-3">
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Select State *</label>
                        <select name="state_id" class="form-select form-select-sm" required>
                            <option value="">-- Choose State --</option>
                            @foreach($states as $st)
                            <option value="{{ $st->id }}" {{ request('state_id') == $st->id ? 'selected' : '' }}>{{ $st->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">City Name *</label>
                        <input type="text" name="name" class="form-control form-control-sm" placeholder="e.g. Lucknow, Varanasi, Noida" required>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="is_popular" value="1" id="addCityPopular">
                        <label class="form-check-label small" for="addCityPopular">
                            ⭐ Mark as Popular City (Feature in quick filters & home badges)
                        </label>
                    </div>
                </div>
                <div class="modal-footer p-2 bg-light">
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-sm btn-warning fw-bold">Save City</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- 4. Edit City Modal -->
<div class="modal fade" id="editCityModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="modal-header bg-dark text-white">
                <h6 class="modal-title fw-bold"><i class="bi bi-pencil-square me-1"></i> Edit City</h6>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="editCityForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body p-3">
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Select State *</label>
                        <select name="state_id" id="editCityStateId" class="form-select form-select-sm" required>
                            @foreach($states as $st)
                            <option value="{{ $st->id }}">{{ $st->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">City Name *</label>
                        <input type="text" name="name" id="editCityName" class="form-control form-control-sm" required>
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" name="is_popular" value="1" id="editCityPopular">
                        <label class="form-check-label small" for="editCityPopular">⭐ Mark as Popular City</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="status" value="1" id="editCityStatus">
                        <label class="form-check-label small" for="editCityStatus">Active City</label>
                    </div>
                </div>
                <div class="modal-footer p-2 bg-light">
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-sm btn-warning fw-bold">Update City</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // 1. Setup Edit State Modal Pre-fill
    document.querySelectorAll('.edit-state-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            const name = this.getAttribute('data-name');
            const status = this.getAttribute('data-status') === '1';

            document.getElementById('editStateForm').action = `/admin/locations/states/${id}`;
            document.getElementById('editStateName').value = name;
            document.getElementById('editStateStatus').checked = status;
        });
    });

    // 2. Setup Edit City Modal Pre-fill
    document.querySelectorAll('.edit-city-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            const name = this.getAttribute('data-name');
            const stateId = this.getAttribute('data-state-id');
            const popular = this.getAttribute('data-popular') === '1';
            const status = this.getAttribute('data-status') === '1';

            document.getElementById('editCityForm').action = `/admin/locations/cities/${id}`;
            document.getElementById('editCityName').value = name;
            document.getElementById('editCityStateId').value = stateId;
            document.getElementById('editCityPopular').checked = popular;
            document.getElementById('editCityStatus').checked = status;
        });
    });
});
</script>
@endpush
@endsection