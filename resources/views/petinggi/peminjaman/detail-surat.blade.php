@props([
    'username' => auth()->user()->name,
    'nim_nip' => auth()->user()->nim_nip,
])

@extends('layouts.app')

@section('title', 'Detail Surat')

@section('content')
<div class="m-5">
<x-header-dashboard />

<x-container>

    {{-- ===== TOP BAR ===== --}}
    <div class="flex items-center justify-between py-5 m-5">
        <div class="flex items-center gap-3">
            <h1 class="text-xl font-bold text-gray-800">
                {{ $surat->penyelenggara ?? ($user->organization->name ?? '-') }}
            </h1>

            @php
                $raw = $surat->getRawOriginal('status_peminjaman');
                $badge = match(true) {
                    is_null($raw) => ['label' => 'TERKIRIM',  'class' => 'bg-teal-100 text-teal-700 border border-teal-300'],
                    $raw == 1     => ['label' => 'DISETUJUI', 'class' => 'bg-green-100 text-green-700 border border-green-300'],
                    $raw == 0     => ['label' => 'DITOLAK',   'class' => 'bg-red-100 text-red-700 border border-red-300'],
                    default       => ['label' => 'PROSES',    'class' => 'bg-gray-100 text-gray-600 border border-gray-300'],
                };
            @endphp

            <span class="px-3 py-1 text-xs font-bold rounded-full {{ $badge['class'] }}">
                {{ $badge['label'] }}
            </span>
        </div>

        <a href="{{ route('petinggi.surat.download', $surat) }}"
        class="flex items-center gap-2 px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition text-sm font-medium text-gray-700">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M17 17H17.01M17 12V17M12 3V12M12 12L9 9M12 12L15 9M5 21H19" />
            </svg>
            Download Surat
        </a>
    </div>

    {{-- ===== INFORMASI DOKUMEN ===== --}}
    <div class="border border-gray-200 rounded-xl p-5 mb-4 bg-white m-5">
        <h2 class="flex items-center gap-2 text-primary font-semibold mb-5">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M12 2a10 10 0 100 20A10 10 0 0012 2z" />
            </svg>
            Informasi Dokumen
        </h2>

        <div class="grid grid-cols-2 gap-x-8 gap-y-4">
            <div>
                <p class="text-xs text-gray-400 uppercase tracking-widest mb-1">Nomor Surat</p>
                <p class="font-bold text-gray-800">{{ $surat->nomor }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-400 uppercase tracking-widest mb-1">Tanggal Terbit</p>
                <p class="font-bold text-gray-800">
                    {{ $surat->tanggal_peminjaman?->locale('id')->translatedFormat('d F Y') ?? '-' }}
                </p>
            </div>
            <div class="col-span-2">
                <p class="text-xs text-gray-400 uppercase tracking-widest mb-1">Perihal</p>
                <p class="text-gray-800">{{ $surat->perihal_peminjaman }}</p>
            </div>
            <div class="col-span-2">
                <p class="text-xs text-gray-400 uppercase tracking-widest mb-1">Tujuan</p>
                <p class="font-bold text-gray-800">{{ $tujuan ?? '-' }}</p>
            </div>
        </div>
    </div>

    {{-- ===== PREVIEW DOKUMEN ===== --}}
    <div class="border border-gray-200 rounded-xl overflow-hidden mb-6 m-5">

        {{-- Header bar --}}
        <div class="bg-primary flex items-center justify-between px-5 py-3">
            <h2 class="text-white font-semibold">Preview Dokumen</h2>
            <div class="flex items-center gap-2">
                {{-- Toggle halaman --}}
                <button onclick="togglePage()"
                    id="btn-toggle-page"
                    class="text-xs text-teal-100 hover:text-white border border-teal-400 rounded px-2 py-1 transition">
                    Lihat Lampiran →
                </button>
                {{-- Fullscreen --}}
                <button onclick="toggleFullscreen()"
                    class="text-white hover:text-gray-200 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 8V4H8M16 4H20V8M20 16V20H16M8 20H4V16" />
                    </svg>
                </button>
            </div>
        </div>

    {{-- iframe preview --}}
    <div id="preview-container" class="transition-all duration-300 m-15" 
        style="height: 600px; overflow: hidden; position: relative;">        
        <iframe
            id="preview-iframe"
            src="{{ route('petinggi.surat.preview', $surat) }}"
            style="width: calc(100% + 17px); height: 100%; border: none;"
            title="Preview Surat"
            onload="hideIframeScrollbar(this)">
        </iframe>
    </div>
    <script>
        function hideIframeScrollbar(iframe) {
            const style = iframe.contentDocument.createElement('style');
            style.textContent = `
                ::-webkit-scrollbar { display: none; }
                html, body { scrollbar-width: none; -ms-overflow-style: none; }
            `;
            iframe.contentDocument.head.appendChild(style);
        }
    </script>
</div>
</x-container>

{{-- ===== BOTTOM BAR VERIFIKASI (sticky) ===== --}}
@if(is_null($surat->getRawOriginal('tandatangan_pimpinan')) && $surat->getRawOriginal('status_peminjaman') === 1)
<div class="fixed bottom-0 left-70 right-0 bg-white border-t border-gray-200 shadow-lg z-40">
    <div class="max-w-screen-xl mx-auto px-6 py-3 flex items-center justify-between">
        <p class="text-sm text-gray-500">Pastikan data yang tercantum dalam surat sudah benar dan sesuai.</p>
        <button onclick="document.getElementById('modal-verifikasi').classList.remove('hidden')"
            class="flex items-center gap-2 px-5 py-2.5 bg-primary text-white rounded-lg hover:bg-primary-hover transition font-medium text-sm">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            Verifikasi
        </button>
    </div>
</div>
@endif

{{-- ===== MODAL VERIFIKASI ===== --}}
<div id="modal-verifikasi" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/40">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-md p-6 mx-4">
        <h3 class="text-lg font-bold text-gray-800 mb-1">Verifikasi Surat</h3>
        <p class="text-sm text-gray-500 mb-5">Pilih tindakan untuk surat <span class="font-semibold">{{ $surat->nomor }}</span></p>

        <form action="{{ route('petinggi.surat.verifikasi', $surat) }}" method="POST">
            @csrf

            {{-- Pilihan status --}}
            <div class="flex gap-3 mb-4">
                <label class="flex-1 cursor-pointer">
                    <input type="radio" name="status_peminjaman" value="1" class="peer hidden" required>
                    <div class="border-2 border-gray-200 peer-checked:border-green-500 peer-checked:bg-green-50 rounded-xl p-3 text-center transition">
                        <p class="font-semibold text-green-700">✓ Setujui</p>
                        <p class="text-xs text-gray-500">Izinkan peminjaman</p>
                    </div>
                </label>
                <label class="flex-1 cursor-pointer">
                    <input type="radio" name="status_peminjaman" value="0" class="peer hidden" required>
                    <div class="border-2 border-gray-200 peer-checked:border-red-500 peer-checked:bg-red-50 rounded-xl p-3 text-center transition">
                        <p class="font-semibold text-red-700">✗ Tolak</p>
                        <p class="text-xs text-gray-500">Tolak permintaan</p>
                    </div>
                </label>
            </div>

            {{-- Catatan --}}
            <div class="mb-5">
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Catatan <span class="text-gray-400 font-normal">(wajib jika menolak)</span>
                </label>
                <textarea name="catatan_peminjaman" rows="3"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-primary"
                    placeholder="Tulis alasan atau catatan...">{{ old('catatan_peminjaman') }}</textarea>
                @error('catatan_peminjaman')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex gap-3">
                <button type="button"
                    onclick="document.getElementById('modal-verifikasi').classList.add('hidden')"
                    class="flex-1 py-2.5 border border-gray-300 rounded-lg text-sm font-medium hover:bg-gray-50 transition">
                    Batal
                </button>
                <button type="submit"
                    class="flex-1 py-2.5 bg-primary text-white rounded-lg text-sm font-medium hover:bg-primary-hover transition">
                    Konfirmasi
                </button>
            </div>
        </form>
    </div>
</div>
</div>

<script>
    // Toggle fullscreen preview
    function toggleFullscreen() {
        const container = document.getElementById('preview-container');
        if (container.style.height === '700px') {
            container.style.height = '90vh';
        } else {
            container.style.height = '700px';
        }
    }

    // Toggle scroll ke halaman 2 (lampiran) di dalam iframe
    let onLampiran = false;
    function togglePage() {
        const iframe  = document.getElementById('preview-iframe');
        const btn     = document.getElementById('btn-toggle-page');
        const iframeDoc = iframe.contentDocument || iframe.contentWindow.document;

        if (!onLampiran) {
            const lampiran = iframeDoc.querySelector('.page-break');
            if (lampiran) {
                lampiran.nextElementSibling?.scrollIntoView({ behavior: 'smooth' });
            }
            btn.textContent = '← Lihat Surat';
            onLampiran = true;
        } else {
            iframeDoc.querySelector('body').scrollIntoView({ behavior: 'smooth' });
            btn.textContent = 'Lihat Lampiran →';
            onLampiran = false;
        }
    }
</script>
@endsection