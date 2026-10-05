<div>
    <!-- He who is contented is rich. - Laozi -->
</div>
<form action="{{ $action }}" method="POST" enctype="multipart/form-data">
    @csrf
    @if($method !== 'POST')
        @method($method)
    @endif

    <div class="row g-3">
        <div class="col-md-6">
            <label for="role" class="form-label fw-bold small">Leadership role *</label>
            <select id="role" name="role" class="form-select @error('role') is-invalid @enderror" required>
                <option value="">Choose a role</option>
                <option value="director" @selected(old('role', $leadershipMessage?->role ?? request('role')) === 'director')>Director</option>
                <option value="ceo" @selected(old('role', $leadershipMessage?->role ?? request('role')) === 'ceo')>CEO</option>
            </select>
            @error('role')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="col-md-6">
            <label for="name" class="form-label fw-bold small">Full name *</label>
            <input id="name" type="text" name="name" value="{{ old('name', $leadershipMessage?->name) }}" class="form-control @error('name') is-invalid @enderror" maxlength="150" required>
            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="col-md-6">
            <label for="designation" class="form-label fw-bold small">Designation *</label>
            <input id="designation" type="text" name="designation" value="{{ old('designation', $leadershipMessage?->designation) }}" class="form-control @error('designation') is-invalid @enderror" maxlength="150" placeholder="e.g. Director, GrowPec Education" required>
            @error('designation')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="col-md-6">
            <label for="photo" class="form-label fw-bold small">Profile photo</label>
            <input id="photo" type="file" name="photo" class="form-control @error('photo') is-invalid @enderror" accept="image/jpeg,image/png,image/webp">
            <div class="form-text">JPG, PNG or WebP. Maximum 2 MB. A generated initial is shown when no photo is uploaded.</div>
            @error('photo')<div class="invalid-feedback">{{ $message }}</div>@enderror
            @if($leadershipMessage?->photo_url)
                <img src="{{ $leadershipMessage->photo_url }}" alt="Current profile photo" class="mt-2 rounded-circle" style="width:64px;height:64px;object-fit:cover;">
            @endif
        </div>

        <div class="col-12">
            <label for="message" class="form-label fw-bold small">Message *</label>
            <textarea id="message" name="message" rows="8" maxlength="5000" class="form-control @error('message') is-invalid @enderror" placeholder="Write a personal message for students and families..." required>{{ old('message', $leadershipMessage?->message) }}</textarea>
            <div class="form-text">Up to 5,000 characters. Line breaks are preserved on the public site.</div>
            @error('message')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="col-12">
            <input type="hidden" name="status" value="0">
            <div class="form-check form-switch">
                <input id="status" type="checkbox" name="status" value="1" class="form-check-input" @checked(old('status', $leadershipMessage?->status ?? false))>
                <label for="status" class="form-check-label fw-semibold">Publish this message on the public website</label>
            </div>
        </div>
    </div>

    <div class="d-flex flex-wrap justify-content-end gap-2 mt-4 pt-3 border-top">
        <a href="{{ route('admin.leadership-messages.index') }}" class="btn btn-light">Cancel</a>
        <button type="submit" class="btn btn-primary px-4"><i class="bi bi-check2-circle me-1"></i> Save message</button>
    </div>
</form>
