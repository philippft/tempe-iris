<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Pendaftaran Akun</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

@section('content')
<div class="p-8 space-y-10">
    <div>
        <h3 class="text-4xl font-extrabold text-judul">Manajemen Pendaftaran Akun</h3>
        <p class="text-base text-dark-grey font-medium">Kelola pengajuan akun mahasiswa</p>
    </div>
    <div class="space-y-4">
        <h2 class="text-base font-bold text-dark-grey uppercase tracking-[1.5px]">Statistik akun mahasiswa</h2>
        <div class="flex flex-wrap w-full justify-start gap-6">
        <x-statecard
                title="Total Akun Mahasiswa"
                :value="$totalMahasiswa"
                label="Akun"
                border="border-l-primary-hover"
                iconBg="bg-primary/10"
            > 
                <x-icons.totalaktif/>
            </x-statecard>
            <x-statecard
                title="Akun Pending"
                :value="$totalPending"
                label="Akun"
                border="border-l-status-yellow"
                iconBg="bg-status-yellow/10"
            > 
                <x-icons.totalpending/>
            </x-statecard>
        </div>

        <div>
            <h2 class="text-[10px] font-bold text-[#64748B] uppercase tracking-wider mb-3">Statistik Akun Mahasiswa</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">

                <div
                    class="bg-white rounded-2xl border-l-[6px] border-[#0A5C66] border-y border-r border-slate-100 p-5 shadow-sm flex justify-between items-start">
                    <div class="space-y-1">
                        <p class="text-xs font-bold text-slate-500">Total Akun Mahasiswa</p>
                        <p class="text-3xl font-extrabold text-slate-800">21 <span
                                class="text-xs font-medium text-slate-400">Akun</span></p>
                    </div>
                    <div class="p-2 rounded-xl bg-slate-50 text-[#0A5C66]">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M4 4v5h.582m15.356 2A8.001 8.001 0 1121 12v-1L19 11" />
                        </svg>
                    </div>
                </div>

                <div
                    class="bg-white rounded-2xl border-l-[6px] border-amber-500 border-y border-r border-slate-100 p-5 shadow-sm flex justify-between items-start">
                    <div class="space-y-1">
                        <p class="text-xs font-bold text-slate-500">Akun Pending</p>
                        <p class="text-3xl font-extrabold text-slate-800">21 <span
                                class="text-xs font-medium text-slate-400">Akun</span></p>
                    </div>
                    <div class="p-2 rounded-xl bg-amber-50 text-amber-500">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>

            </div>

            <div class="w-full md:w-64">
                <label class="block text-xs font-bold text-dark-grey uppercase tracking-wider mb-2">Status</label>
                <select name="category" onchange="this.form.submit()"
                    class="block w-full rounded-xl border border-border-custom bg-bg-dark px-4 py-2.5 text-sm text-dark-grey focus:border-primary-hover focus:ring-primary-hover transition">
                    <option value="">Semua Status</option>
<!-- tambah opsinyaaaaaaa -->
                </select>
            </div>
        </form>
    </div>
    
    <x-container>
        <x-table
        :headers="['No', 'Nama Mahasiswa', 'NIM', 'Email', 'Tanggal Daftar', 'Status', 'Aksi']"
        :cols="['60px', '1.2fr', '1fr', '1.5fr', '1.2fr', '1fr', '120px']"
        :data="$user"
        headerBg="bg-primary-hover"
        headerClass="text-white font-bold text-sm uppercase"
        bg="bg-white overflow-hidden"
        >
        @php 
            $no = ($user->currentPage() - 1) * $user->perPage(); 
        @endphp

        @forelse($user as $index => $data)
            <x-table-row>
                <div class="justify-center font-medium text-base text-dark-grey">
                    {{ str_pad(++$no, 2, '0', STR_PAD_LEFT) }}
                </div>

                <div class="justify-start font-bold text-judul wrap-break-words pr-2 text-base leading-tight">
                    {{ $data->name }}
                </div>

                <div class="justify-start">
                    <span class="bg-bg-dark text-primary px-2 py-0.5 rounded-md text-sm font-bold ">
                        {{ $data->nim_nip ?? '0000000000' }}
                    </span>
                </div>

                <div class="justify-center text-dark-grey font-normal text-[10px] break-all">
                    {{ $data->email }}
                </div>

                <div class="justify-center text-dark-grey font-medium text-base">
                    {{ $data->created_at ? $data->created_at->format('d F Y') : '-' }}
                </div>

                <div class="justify-center">
                    @if($data->verify_at)
                        <span class="bg-status-green inline-flex items-center justify-center px-4 py-2 text-xs font-bold text-white uppercase rounded-full tracking-wider">
                            AKTIF
                        </span>
                    @elseif($data->note && $data->verify_at == null)
                        <span class="bg-status-red inline-flex items-center justify-center px-4 py-2 text-xs font-bold text-white uppercase rounded-full tracking-wider">
                            DITOLAK
                        </span>
                    @elseif($data->note == null && $data->verify_at == null)
                        <span class="bg-status-yellow inline-flex items-center justify-center px-4 py-2 text-xs font-bold text-white uppercase rounded-full tracking-wider">
                            PENDING
                        </span>
                    @endif
                </div>

                <div class="justify-center">
                    <a href="{{ route('admin.user.detail', $data->id) }}"
                    class="border-2 border-primary-hover  rounded-xl inline-flex items-center justify-center px-4.5 py-2 text-sm font-bold text-primary-hover shadow-sm hover:bg-bg-dark hover:shadow-lg transition tracking-wider">
                        Detail
                    </a>
                </div>
            </x-table-row>
            @empty
            <x-table-empty title="Tidak ada Data Mahasiswa" message="Saat ini belum ada mahasiswa yang terdaftar atau tidak ada data yang cocok dengan pencarian Anda."/>
        @endforelse
        </x-table>

</x-container>
    
@endsection
