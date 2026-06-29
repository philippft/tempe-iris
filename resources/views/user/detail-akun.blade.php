@extends('layouts.app') {{-- Berdasarkan master layout yang dibuat sebelumnya --}}

@section('title', 'Profile Mahasiswa')

@section('content')
    <div class="w-full mx-auto p-8">

        <div class="flex justify-between items-start mb-6">
            <div>
                <h1 class="text-[22px] font-bold text-[#1e293b]">Profile Mahasiswa</h1>
                <p class="text-[13px] text-gray-500 mt-1">Akses detail akunmu melalui halaman ni!</p>
            </div>

            {{-- Menggunakan Komponen Badge --}}
            @if (!is_null($user->verify_at))
                <x-badge status="aktif" />
            @elseif(is_null($user->verify_at) && !is_null($user->note))
                <x-badge status="ditolak" />
            @else
                <x-badge status="pending" />
            @endif

        </div>

        <div>
            <nav class="flex flex-col">
                @if (!is_null($user->verify_at))
                    <div class="bg-status-green/10 border border-status-green rounded-lg p-4 gap-3 mb-6">
                        <h3 class="text-[14px] font-bold text-status-green">Selamat Datang!</h3>
                        <p class="text-[13px] text-status-green mt-0.5 leading-relaxed">
                            Akun Anda telah diverifikasi oleh tim administrasi. Sekarang Anda memiliki akses penuh untuk
                            meminjam barang dan peralatan dari inventaris TEMPE IRIS.
                        </p>
                    </div>
                @elseif(is_null($user->verify_at) && !is_null($user->note))
                    <div class="bg-status-red/10 border border-status-red rounded-lg p-4 gap-3 mb-6">
                        <h3 class="text-[14px] font-bold text-status-red">Verifikasi Ditolak!</h3>
                        <p class="text-[13px] text-status-red mt-0.5 leading-relaxed">
                            {{ $user->note }}
                        </p>
                    </div>
                @else
                    <div class="bg-status-yellow/10 border border-status-yellow rounded-lg p-4 gap-3 mb-6">
                        <h3 class="text-[14px] font-bold text-status-yellow">Menunggu Verifikasi!</h3>
                        <p class="text-[13px] text-status-yellow mt-0.5 leading-relaxed">
                            Akun Anda sedang diverifikasi oleh tim administrasi. Cek berkala status akunmu melalui website
                            TEMPE IRIS.
                        </p>
                    </div>
                @endif
            </nav>

        </div>

        @if (!is_null($user->verify_at) || (is_null($user->verify_at) && is_null($user->note)))
            <div class="border border-gray-200 rounded-lg mb-6 bg-white shadow-sm">
                <div class="px-5 py-4 border-b border-gray-200">
                    <h2 class="font-semibold text-[15px] text-[#1e293b]">Foto KTM (Kartu Tanda Mahasiswa)</h2>
                </div>

                <div class="p-6">
                    <div
                        class="bg-[#f0f4ff] border-2 border-dashed border-[#c7d2fe] rounded-xl p-6 flex justify-center items-center">
                        @if ($user->ktm)
                            <img src="{{ asset($user->ktm) }}" alt="Foto KTM {{ $user->name }}"
                                class="w-full max-w-[500px] rounded-md shadow-md object-cover h-[300px]">
                        @else
                            {{-- Placeholder jika file gambar kosong --}}
                            <div class="text-center p-10 text-slate-400 italic text-sm">
                                Belum ada foto KTM yang diunggah.
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="border border-gray-200 rounded-lg bg-white shadow-sm">
                <div class="px-5 py-4 border-b border-gray-200">
                    <h2 class="font-semibold text-[15px] text-[#1e293b]">Informasi Pribadi</h2>
                </div>
                <div class="p-6 flex flex-col gap-5">

                    {{-- Menggunakan Komponen Input --}}
                    <x-show id="name" type="text" name="name" label="Nama Lengkap" :value="$user->name"
                        :isReadonly="true" />

                    <x-show id="nim" type="text" name="nim" label="NIM (Nomor Induk Mahasiswa)"
                        :value="$user->nim_nip" :isReadonly="true" />

                    <x-show id="prodi" type="text" name="prodi" label="Program Studi" :value="$user->organization->name"
                        :isReadonly="true" />

                    <x-show id="email" type="text" name="email" label="Email" :value="$user->email"
                        :isReadonly="true" />

                </div>
            </div>
        @elseif (is_null($user->verify_at) && !is_null($user->note))
            <form action="{{ route('user.detail-akun.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                {{-- Input untuk foto KTM --}}
                <div class="border border-gray-200 rounded-lg mb-6 bg-white shadow-sm">
                    <div class="px-5 py-4 border-b border-gray-200">
                        <h2 class="font-semibold text-[15px] text-[#1e293b]">Foto KTM (Kartu Tanda Mahasiswa)</h2>
                    </div>

                    <div class="p-6">
                        <div
                            class="bg-[#f0f4ff] border-2 border-dashed border-[#c7d2fe] rounded-xl p-6 flex justify-center items-center">
                            @if ($user->ktm)
                                <img src="{{ asset($user->ktm) }}" alt="Foto KTM {{ $user->name }}"
                                    class="w-full max-w-[500px] rounded-md shadow-md object-cover h-[300px]">
                            @else
                                {{-- Placeholder jika file gambar kosong --}}
                                <div class="text-center p-10 text-slate-400 italic text-sm">
                                    Belum ada foto KTM yang diunggah.
                                </div>
                            @endif
                        </div>

                        <div class="w-full w-full mt-4">
                            <label for="ktm" class="block text-sm font-bold text-gray-700 mb-2">Pilih Foto Baru
                                (Opsional)</label>

                            <input type="file" id="ktm" name="ktm" accept="image/jpeg, image/png, image/jpg"
                                class="block w-full text-sm text-slate-500
                            file:mr-4 file:py-2.5 file:px-4
                            file:rounded-full file:border-0
                            file:text-sm file:font-semibold
                            file:bg-indigo-50 file:text-indigo-700
                            hover:file:bg-indigo-100 cursor-pointer
                            transition duration-200 outline-none">

                            <p class="mt-2 text-xs text-gray-500">Format yang didukung: JPG, JPEG, PNG.</p>

                            {{-- Pesan Error Validasi jika file tidak sesuai --}}
                            @error('ktm')
                                <p class="text-red-500 text-xs mt-2 font-medium">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Komponen input teks lainnya di sini --}}
                <div class="border border-gray-200 rounded-lg bg-white shadow-sm">
                    <div class="px-5 py-4 border-b border-gray-200">
                        <h2 class="font-semibold text-[15px] text-[#1e293b]">Informasi Pribadi</h2>
                    </div>
                    <div class="p-6 flex flex-col gap-5">

                        {{-- Menggunakan Komponen Input --}}
                        <x-show id="name" type="text" name="name" label="Nama Lengkap" :value="$user->name" />

                        <x-show id="nim" type="text" name="nim_nip" label="NIM (Nomor Induk Mahasiswa)"
                            :value="$user->nim_nip" />

                        <x-select name="id_organization" label="PROGRAM STUDI">
                            <option value="" disabled {{ old('id_organization') ? '' : 'selected' }}>Pilih Program Studi
                            </option>

                            @foreach ($organizations as $org)
                                <option value="{{ $org->id }}" @selected(old('id_organization', $user->id_organization)
                                    == $org->id)>
                                    {{ str_replace('Program Studi ', '', $org->name) }}
                                </option>
                            @endforeach
                        </x-select>

                        <x-show id="email" type="text" name="email" label="Email" :value="$user->email" />

                    </div>
                </div>

                <button type="submit"
                    class="w-full bg-status-yellow p-4 rounded-xl text-white font-semibold font-xl mt-6 justify-center">
                    Perbaharui Data
                </button>

                @if ($errors->any())
                    <div class="bg-red-100 text-red-700 p-4 rounded-md mb-4">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>- {{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                
            </form>
        @endif

    </div>
@endsection
