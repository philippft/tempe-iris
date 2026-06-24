@props([
    'id' => 'deleteModal', // ID unik untuk trigger modal
    'action' => '#',       // URL route untuk menghapus data
    'title' => 'Konfirmasi Hapus Data',
    'message' => 'Apakah Anda yakin ingin menghapus data ini?<br>Tindakan ini tidak dapat dibatalkan.',
])

<div id="{{ $id }}" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/40 px-4 transition-opacity">
    <div class="w-full max-w-xl rounded-3xl bg-white p-10 shadow-xl">
        
        <div class="mb-4 flex justify-center">
            <div class="flex h-16 w-16 items-center justify-center rounded-full bg-red-50">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-red-700"
                    fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M19 7L5 7M10 11V17M14 11V17M6 7L7 19C7.1 20.1 8 21 9.1 21H14.9C16 21 16.9 20.1 17 19L18 7M9 7V5C9 4.4 9.4 4 10 4H14C14.6 4 15 4.4 15 5V7"/>
                </svg>
            </div>
        </div>

        <h2 class="mb-4 text-center text-2xl font-bold text-slate-800">
            {{ $title }}
        </h2>

        {{-- Menggunakan {!! !!} agar tag <br> di dalam teks bisa dirender sebagai HTML --}}
        <p class="mb-10 text-center text-lg text-slate-600">
            {!! $message !!}
        </p>

        <div class="grid grid-cols-2 gap-4">
            {{-- Tombol Batal --}}
            <button type="button" onclick="closeModal('{{ $id }}')"
                    class="rounded-xl border border-slate-400 py-3 text-lg font-semibold text-slate-700 transition hover:bg-slate-100">
                Batal
            </button>

            {{-- Form Hapus --}}
            <form method="POST" action="{{ $action }}">
                @csrf
                @method('DELETE')

                <button type="submit"
                    class="w-full rounded-xl bg-red-700 py-3 text-lg font-semibold text-white transition hover:bg-red-800">
                    Hapus
                </button>
            </form>
        </div>
    </div>
</div>