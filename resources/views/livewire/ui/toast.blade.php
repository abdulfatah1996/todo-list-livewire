<div class="fixed top-6 end-6 z-50 w-full max-w-sm space-y-3">
    @foreach ($toasts as $toast)
        <div x-data="{ show: true }" x-show="show" x-transition:enter="transition ease-out duration-500"
            x-transition:enter-start="opacity-0 translate-y-4 scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 scale-100"
            x-transition:leave="transition ease-in duration-300"
            x-transition:leave-start="opacity-100 translate-y-0 scale-100"
            x-transition:leave-end="opacity-0 translate-y-4 scale-95" x-init="const audio = new Audio({
                success: '{{ asset('assets/sounds/success.mp3') }}',
                error: '{{ asset('assets/sounds/error.mp3') }}',
                warning: '{{ asset('assets/sounds/warning.mp3') }}',
                info: '{{ asset('assets/sounds/info.mp3') }}',
            } ['{{ $toast['type'] }}']);
            audio.play();
            setTimeout(() => show = false, 4000);
            setTimeout(() => $wire.removeToast('{{ $toast['id'] }}'), 4500);"
            class="flex items-center gap-3 px-5 py-3 rounded-2xl shadow-lg backdrop-blur-sm text-white font-semibold tracking-wide text-sm"
            :class="{
                'bg-green-100': '{{ $toast['type'] }}'
                === 'success',
                'bg-red-100': '{{ $toast['type'] }}'
                === 'error',
                'bg-yellow-100': '{{ $toast['type'] }}'
                === 'warning',
                'bg-blue-100': '{{ $toast['type'] }}'
                === 'info',
            }">
            {{-- الأيقونة --}}
            <i class="text-lg"
                :class="{
                    'fa-solid fa-circle-check text-green-900': '{{ $toast['type'] }}'
                    === 'success',
                    'fa-solid fa-circle-xmark text-red-900': '{{ $toast['type'] }}'
                    === 'error',
                    'fa-solid fa-triangle-exclamation text-yellow-900': '{{ $toast['type'] }}'
                    === 'warning',
                    'fa-solid fa-circle-info text-blue-900': '{{ $toast['type'] }}'
                    === 'info',
                }"></i>

            {{-- الرسالة --}}
            <div class="flex-1"
                :class="{
                    'text-green-800': '{{ $toast['type'] }}'
                    === 'success',
                    'text-red-800': '{{ $toast['type'] }}'
                    === 'error',
                    'text-yellow-800': '{{ $toast['type'] }}'
                    === 'warning',
                    'text-blue-800': '{{ $toast['type'] }}'
                    === 'info',
                }">
                {{ $toast['message'] }}
            </div>

        </div>
    @endforeach
</div>
