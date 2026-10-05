@extends('admin.layout')

@section('title', 'Director & CEO Messages - GrowPec Admin')
@section('header', 'Director & CEO Messages')

@section('content')
<style>
    .leadership-admin { --la-navy: #002B67; --la-green: #008A43; --la-muted: #718096; }
    .leadership-admin-head { display:flex; align-items:flex-end; justify-content:space-between; gap:16px; margin-bottom:22px; }
    .leadership-admin-head h2 { margin:0 0 6px; color:var(--la-navy); font-size:1.35rem; font-weight:850; }
    .leadership-admin-head p { margin:0; color:var(--la-muted); font-size:.84rem; }
    .leadership-admin-adds { display:flex; flex-wrap:wrap; justify-content:flex-end; gap:8px; }
    .leadership-add { display:inline-flex; align-items:center; gap:8px; padding:11px 16px; border-radius:11px; background:var(--la-navy); color:#fff; font-size:.8rem; font-weight:800; text-decoration:none; }
    .leadership-add:hover { background:var(--la-green); color:#fff; }
    .leadership-admin-card { display:grid; grid-template-columns:96px minmax(0,1fr) auto; align-items:center; gap:20px; margin-bottom:14px; padding:20px; border:1px solid #DCE5EF; border-radius:16px; background:#fff; box-shadow:0 8px 22px rgba(0,43,103,.05); }
    .leadership-admin-photo { width:88px; height:88px; display:grid; place-items:center; overflow:hidden; border-radius:50%; background:linear-gradient(145deg,#E7EEF7,#D8EEE4); color:var(--la-navy); font-size:1.7rem; font-weight:850; }
    .leadership-admin-photo img { width:100%; height:100%; object-fit:cover; }
    .leadership-admin-role { display:inline-flex; padding:5px 10px; border-radius:999px; background:#EAF5EF; color:#087545; font-size:.66rem; font-weight:850; text-transform:uppercase; letter-spacing:.06em; }
    .leadership-admin-copy h3 { margin:8px 0 2px; color:#172033; font-size:1rem; font-weight:850; }
    .leadership-admin-copy .designation { margin:0 0 8px; color:#536177; font-size:.77rem; font-weight:700; }
    .leadership-admin-copy .message { display:-webkit-box; overflow:hidden; margin:0; color:#718096; font-size:.75rem; line-height:1.55; -webkit-box-orient:vertical; -webkit-line-clamp:2; }
    .leadership-admin-actions { display:flex; flex-wrap:wrap; justify-content:flex-end; gap:8px; }
    .leadership-admin-actions a,.leadership-admin-actions button { min-height:38px; display:inline-flex; align-items:center; justify-content:center; gap:6px; padding:8px 12px; border:1px solid #DCE5EF; border-radius:9px; background:#fff; color:var(--la-navy); font-size:.72rem; font-weight:800; text-decoration:none; }
    .leadership-admin-actions .delete { color:#B42318; }
    .leadership-admin-state { margin-top:8px; color:#64748B; font-size:.68rem; font-weight:750; }
    .leadership-empty { padding:28px; border:1px dashed #BDCAD9; border-radius:14px; color:#718096; text-align:center; background:#F8FAFC; }
    @media (max-width:767.98px) { .leadership-admin-head { align-items:stretch; flex-direction:column; } .leadership-admin-adds { justify-content:flex-start; } .leadership-admin-card { grid-template-columns:64px minmax(0,1fr); gap:13px; padding:15px; } .leadership-admin-photo { width:62px; height:62px; font-size:1.25rem; } .leadership-admin-actions { grid-column:1/-1; justify-content:flex-start; } }
</style>

<div class="leadership-admin">
    <div class="leadership-admin-head">
        <div>
            <h2>Leadership messages</h2>
            <p>Manage one Director and one CEO profile. Active messages appear on the homepage and About page.</p>
        </div>
        <div class="leadership-admin-adds">
            @foreach(['director' => 'Director', 'ceo' => 'CEO'] as $role => $label)
                @if(!$messages->contains('role', $role))
                <a href="{{ route('admin.leadership-messages.create', ['role' => $role]) }}" class="leadership-add">
                    <i class="bi bi-plus-lg"></i> Add {{ $label }} message
                </a>
                @endif
            @endforeach
        </div>
    </div>

    @forelse($messages as $message)
    <article class="leadership-admin-card">
        <div class="leadership-admin-photo">
            @if($message->photo_url)
                <img src="{{ $message->photo_url }}" alt="{{ $message->name }}">
            @else
                {{ mb_strtoupper(mb_substr($message->name, 0, 1)) }}
            @endif
        </div>
        <div class="leadership-admin-copy">
            <span class="leadership-admin-role">{{ ucfirst($message->role) }}</span>
            <h3>{{ $message->name }}</h3>
            <p class="designation">{{ $message->designation }}</p>
            <p class="message">{{ $message->message }}</p>
            <div class="leadership-admin-state">
                <i class="bi {{ $message->status ? 'bi-eye-fill text-success' : 'bi-eye-slash-fill text-secondary' }}"></i>
                {{ $message->status ? 'Published on website' : 'Hidden from website' }}
            </div>
        </div>
        <div class="leadership-admin-actions">
            <a href="{{ route('admin.leadership-messages.edit', $message) }}"><i class="bi bi-pencil-square"></i> Edit</a>
            <form action="{{ route('admin.leadership-messages.destroy', $message) }}" method="POST" onsubmit="return confirm('Remove this leadership message?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="delete"><i class="bi bi-trash3"></i> Remove</button>
            </form>
        </div>
    </article>
    @empty
    <div class="leadership-empty">
        <i class="bi bi-chat-quote fs-3 d-block mb-2"></i>
        <strong>No leadership messages added yet.</strong>
        <p class="mb-0 mt-1">Add the Director and CEO profiles to introduce your leadership team.</p>
    </div>
    @endforelse
</div>
@endsection
