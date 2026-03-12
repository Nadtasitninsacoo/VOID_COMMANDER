<div id="tactical-signals" class="hidden">
    @if (session('success'))
        <input type="hidden" id="signal-success" value="{{ session('success') }}">
    @endif

    @if (session('error'))
        <input type="hidden" id="signal-error" value="{{ session('error') }}">
    @endif

    @if ($errors->any())
        <input type="hidden" id="signal-validation" value="{{ $errors->first() }}">
    @endif
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{ asset('js/tactical-alerts.js') }}"></script>
