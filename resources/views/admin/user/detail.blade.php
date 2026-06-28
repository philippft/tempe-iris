@extends('layouts.app')

@section('title', 'Detail Akun Mahasiswa') 

@section('content')
<x-header-page title="Profil Mahasiswa"></x-header-page>

<!-- page philip dan temannya -->
    <div class="bg-[#F8FAFC] p-6 sm:p-8 font-sans text-gray-800">

        <form action="{{ route('admin.user.approve', $user->id) }}" method="POST"
            class="max-w-4xl mx-auto space-y-6 pb-12">
            @csrf
            @method('PUT')

            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6 space-y-4">
                <h3 class="text-xs font-bold text-slate-800 tracking-wide">Foto KTM (Kartu Tanda Mahasiswa)</h3>

                <div
                    class="bg-blue-50/40 border border-dashed border-blue-200 rounded-2xl p-4 flex justify-center items-center overflow-hidden">
                    {{-- Ganti dengan asset() dari database kamu cok --}}
                    <img src="{{ $user->foto_ktm ?? asset('images/dummy-ktm.png') }}" alt="Foto KTM"
                        class="max-w-md w-full h-auto rounded-xl shadow-md border border-slate-200 object-cover">
                </div>
            </div>

            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6 space-y-4">
                <h3 class="text-xs font-bold text-[#0A5C66] tracking-wide border-b border-slate-100 pb-3">Informasi Mahasiswa
                </h3>

                <div class="space-y-4 text-xs">
                    <div>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Nama Lengkap</p>
                        <p class="text-slate-800 font-extrabold mt-0.5">{{ $user->username ?? 'I Putu Ardyana Darma Nugraha' }}
                        </p>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">NIM (Nomor Induk Mahasiswa)</p>
                        <p class="text-slate-800 font-extrabold mt-0.5">{{ $user->NIM_NIP ?? '2408561030' }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Program Studi</p>
                        <p class="text-slate-800 font-extrabold mt-0.5">{{ $user->prodi ?? 'Informatika' }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Email</p>
                        <p class="text-slate-800 font-extrabold mt-0.5">{{ $user->email ?? 'ardyganteng123@gmail.com' }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-blue-50/30 rounded-2xl border border-blue-100/70 p-5 space-y-3">
                <h3 class="text-xs font-bold text-slate-800 tracking-wide">Catatan Verifikator (Opsional)</h3>
                <div>
                    <textarea name="notes" rows="3" placeholder="Tambahkan alasan jika menolak pendaftaran..."
                        class="block w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-xs text-gray-900 focus:border-[#0A5C66] focus:ring-[#0A5C66] transition shadow-inner"></textarea>
                </div>
            </div>

            <div
                class="bg-white border border-slate-100 rounded-2xl p-4 flex flex-col sm:flex-row gap-4 items-center justify-between shadow-sm">
                <p class="text-[11px] text-slate-400 font-medium text-center sm:text-left">
                    Pastikan data NIM dan foto KTM telah sesuai dengan basis data Universitas.
                </p>

                <div class="flex items-center gap-3 w-full sm:w-auto justify-end">
                    <button type="submit" name="status" value="tolak" onclick="return confirmReject(event)"
                        class="flex items-center justify-center gap-1.5 rounded-xl border border-rose-500 bg-white px-5 py-2.5 text-xs font-bold text-rose-600 hover:bg-rose-50 transition shadow-sm w-full sm:w-auto">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                        </svg>
                        Tolak
                    </button>

                    <button type="submit" name="status" value="setuju"
                        class="flex items-center justify-center gap-1.5 rounded-xl bg-[#00B983] hover:bg-[#00966A] px-5 py-2.5 text-xs font-bold text-white shadow-md transition w-full sm:w-auto">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Setujui
                    </button>
                </div>
            </div>

        </form>

    </div>

@endsection