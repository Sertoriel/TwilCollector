{{-- Aletras Register --}}
@if (session('message'))
    <div class="d-flex alert alert-success alert-dismissable fade show" role="alert">
        <i class="bi bi-check-square-fill me-2"></i>
        {{ session('message') }}
        <button type="button" class="btn-close me-2" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if (session('error'))
    <div class="d-flex alert alert-danger alert-dismissable fade show" role="alert">
        <i class="bi bi-exclamation-triangle-fill me-2"></i>
        {{ session('error') }}
        <button type="button" class="btn-close me-2" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
{{-- Aletras Log_in --}}
@if (session('profile'))
    <div class="d-flex alert alert-warning alert-dismissable fade show" role="alert">
        <i class="bi bi-chat-right-text-fill me-2"></i>
        {{ session('profile') }}
        <button type="button" class="btn-close me-2" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
{{-- Aletras Log_out --}}
