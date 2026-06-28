@extends('layouts.app')

@section('title', 'Detail Akun Mahasiswa') 

@section('content')
<x-header-page title="Profil Mahasiswa"></x-header-page>
<div class="p-8 space-y-9">

    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h3 class="text-3xl font-bold text-primary-hover">Detail Pendaftaran Mahasiswa</h3>
            <p class="text-sm text-dark-grey font-medium">Review data registrasi mahasiswa</p>
        </div>
        <x-badge label1="Pending">

        </x-badge>
    </div>
    <form action="{{ route('admin.user.approve', $user->id) }}" method="POST" class="space-y-9">
            @csrf
            @method('PUT')
            <div class="bg bg-white rounded-2xl  border border-border-custom/50 p-6 space-y-6">
                <h1 class="font-semibold text-2xl">
                    Foto KTM (Kartu Tanda Mahasiswa)
                </h1>
                <div class="bg-bg-dark rounded-2xl border border-border-custom border-dashed justify-center items-center flex p-16 space-y-6">
                     <img src="{{ asset('images/dashboard.png') }}" alt="KTM" class="w-full h-auto rounded-xl shadow-md object-cover">        
                </div>
            </div>
        
            <div class="bg bg-white rounded-2xl  border border-border-custom/50 p-6 space-y-6">
                <h1 class="text-2xl font-semibold text-primary-hover pb-3 border-b border-border-custom">
                    Informasi Mahasiswa
                </h1>
                <div class="space-y-6">
                    <div>
                        <h3 class="text-xs font-semibold text-dark-grey uppercase mb-0.5">
                            Nama Lengkap
                        </h3>
                        <h1 class="text-lg font-semibold text-judul capitalize">
                            {{ $user->name }}
                        </h1>
                    </div>
                    <div>
                        <h3 class="text-xs font-semibold text-dark-grey uppercase mb-0.5">
                            NIM (Nomor induk mahasiswa)
                        </h3>
                        <h1 class="text-lg font-semibold text-judul capitalize">
                            {{ $user->nim_nip }}
                        </h1>
                    </div>
                    <div>
                        <h3 class="text-xs font-semibold text-dark-grey uppercase mb-0.5">
                            Program studi
                        </h3>
                        <h1 class="text-lg font-semibold text-judul capitalize">
                            {{ $user->organization->name }}
                        </h1>
                    </div>
                    <div>
                        <h3 class="text-xs font-semibold text-dark-grey uppercase mb-0.5">
                            email
                        </h3>
                        <h1 class="text-lg font-semibold text-judul">
                            {{ $user->email }}
                        </h1>
                    </div>
                </div>
            </div>
        
            <div class="bg bg-bg-dark rounded-2xl  border border-border-custom/50 p-6 space-y-4">
                <h1 class="font-semibold text-xl text-judul">Catatan Verifikator (Opsional)
                </h1>
                <textarea name="notes" rows="3" placeholder="Tambahkan alasan jika menolak pendaftaran..." class="block w-full rounded-xl border border-border-custom/50 bg-white p-3 text-base text-judul focus:border-primary focus:ring-primary transition shadow-inner"></textarea>
            </div>
        
            <div class="bg bg-white rounded-2xl  border border-border-custom/50 p-4 flex flex-col sm:flex-row gap-4 items-center justify-between shadow-sm">
                <h1 class="font-normal text-base text-dark-grey">
                    Pastikan data NIM dan foto KTM telah sesuai dengan basis data Universitas.
                </h1>
                <div class="flex flex-row gap-4 items-center justify-between">
                    <button type="submit" name="status" value="tolak" onclick="return confirmReject(event)"
                        class="flex items-center justify-center gap-1.5 rounded-xl border border-status-red hover:bg-status-red/10 px-8 py-4 text-base font-bold text-status-red shadow-md transition w-full sm:w-auto">
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M10 20C8.61667 20 7.31667 19.7375 6.1 19.2125C4.88333 18.6875 3.825 17.975 2.925 17.075C2.025 16.175 1.3125 15.1167 0.7875 13.9C0.2625 12.6833 0 11.3833 0 10C0 8.61667 0.2625 7.31667 0.7875 6.1C1.3125 4.88333 2.025 3.825 2.925 2.925C3.825 2.025 4.88333 1.3125 6.1 0.7875C7.31667 0.2625 8.61667 0 10 0C11.3833 0 12.6833 0.2625 13.9 0.7875C15.1167 1.3125 16.175 2.025 17.075 2.925C17.975 3.825 18.6875 4.88333 19.2125 6.1C19.7375 7.31667 20 8.61667 20 10C20 11.3833 19.7375 12.6833 19.2125 13.9C18.6875 15.1167 17.975 16.175 17.075 17.075C16.175 17.975 15.1167 18.6875 13.9 19.2125C12.6833 19.7375 11.3833 20 10 20ZM10 18C10.9 18 11.7667 17.8542 12.6 17.5625C13.4333 17.2708 14.2 16.85 14.9 16.3L3.7 5.1C3.15 5.8 2.72917 6.56667 2.4375 7.4C2.14583 8.23333 2 9.1 2 10C2 12.2333 2.775 14.125 4.325 15.675C5.875 17.225 7.76667 18 10 18ZM16.3 14.9C16.85 14.2 17.2708 13.4333 17.5625 12.6C17.8542 11.7667 18 10.9 18 10C18 7.76667 17.225 5.875 15.675 4.325C14.125 2.775 12.2333 2 10 2C9.1 2 8.23333 2.14583 7.4 2.4375C6.56667 2.72917 5.8 3.15 5.1 3.7L16.3 14.9Z" fill="#EF4444"/>
                        </svg>
                
                        <span class="ml-1">
                            Tolak
                        </span>
                    </button>
                
                    <button type="submit" name="status" value="setuju"
                        class="flex items-center justify-center gap-1.5 rounded-xl bg-status-green hover:bg-primary px-8 py-4 text-base font-bold text-white shadow-md transition w-full sm:w-auto">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                
                        <span class="ml-1">
                            Setujui
                        </span>
                    </button>
                </div>
            </div>
    </form>


</div>  

<!-- page philip dan temannya -->
    <!-- <div class="bg-[#F8FAFC] p-6 sm:p-8 font-sans text-gray-800">

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

    </div> -->

@endsection