@if (session()->has('message'))
    <div class="alert alert-{{ session()->get('message')['type'] ?? 'info' }}">
        {{ session()->get('message')['message'] }}
    </div>
@endif
