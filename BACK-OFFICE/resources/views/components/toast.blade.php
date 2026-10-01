 <!-- Success Message -->
    <div class="absolute bottom-2 left-210 right-0">
        @if (session('success'))
            <div
                x-data="{ show: true }"
                x-show="show"
                x-transition
                x-init="setTimeout(() => show = false, 5000)"
                class="bg-green-500 text-white px-4 py-2 rounded-md mb-4"
                role="alert"
            >
                {{ session('success') }}
            </div>
        @endif
    </div>