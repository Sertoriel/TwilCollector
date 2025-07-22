{{-- Aletras Register --}}
@if (session('message'))
    <div class="alert alert-success alert-dismissable fade show" role="alert">
        {{ session('message') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger alert-dismissable fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
{{-- Aletras Log_in --}}
@if (session('profile'))
    <div class="alert alert-warning alert-dismissable fade show" role="alert">
        {{ session('profile') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
    {{-- Aletras Log_out --}}
