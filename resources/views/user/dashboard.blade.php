<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    @vite('resources/css/app.css')
</head>
<body class="font-sans bg-bg-dark min-h-screen">
    <x-header-dashboard/>
    <div>
        <x-statecard
            title="Total Aktif"
            value="21"
            label="Peminjaman"
            bg="bg-[#FFFFFF]"
            border="border-l-red-500"
            iconBg="bg-red-500"
        >
            <svg width="19" height="19" viewBox="0 0 19 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M0 -0.000162125V2.28282H3.1391L2.6825 2.68234C1.69321 3.55748 0.998803 4.55628 0.599282 5.67875C0.199761 6.80121 0 7.93319 0 9.07468C0 11.1864 0.632576 13.0651 1.89773 14.7108C3.16288 16.3564 4.81328 17.4456 6.84894 17.9783V15.5812C5.47915 15.0865 4.37571 14.2447 3.53862 13.0556C2.70153 11.8666 2.28298 10.5396 2.28298 9.07468C2.28298 8.21856 2.44469 7.38623 2.76811 6.57767C3.09153 5.76912 3.59569 5.02239 4.28059 4.3375L4.56596 4.05213V6.84878H6.84894V-0.000162125H0ZM11.4149 0.28521V2.68234C12.7847 3.17698 13.8881 4.01883 14.7252 5.20788C15.5623 6.39694 15.9809 7.72392 15.9809 9.18883C15.9809 10.0449 15.8191 10.8773 15.4957 11.6858C15.1723 12.4944 14.6681 13.2411 13.9832 13.926L13.6979 14.2114V11.4147H11.4149V18.2637H18.2638V15.9807H15.1247L15.5813 15.5812C16.5135 14.649 17.1937 13.6359 17.6217 12.542C18.0498 11.448 18.2638 10.3303 18.2638 9.18883C18.2638 7.07707 17.6313 5.19837 16.3661 3.55272C15.101 1.90708 13.4506 0.817905 11.4149 0.28521Z" fill="#095769"/>
            </svg>
        </x-statecard>

        <x-table
            :headers="['No', 'Nomor Surat', 'Perihal', 'Nama Kegiatan', 'Tanggal Kirim', 'Status', 'Aksi']"
            :cols="['60px', '0.5fr', '0.5fr', '0.5fr', '0.5fr', '180px', '180px']"
            headerBg="bg-primary-hover/10"
            headerClass="text-primary font-bold text-sm uppercase"
            bg="bg-white"
        >
            @foreach($surats as $surat)
                <x-table-row>
                    <div> {{ $loop->iteration }} </div>
                    <div class="font-bold"> {{ $surat->nomor }} </div>
                    <div> {{ $surat->perihal_peminjaman }} </div>
                    <div class="text-center"> {{ $surat->nama_kegiatan }} </div>
                    <div> {{ $surat->tanggal_peminjaman->format('d M Y') }} </div>
                    <div> 
                        <x-status-card :status="$surat->status_peminjaman"/>
                    </div>
                    <div> 
                        <x-take-action/>
                    </div>
                </x-table-row>
            @endforeach
        </x-table>
        
        <form action="{{ route('logout') }}" method="POST" style="display: inline;">
        @csrf 
            <button type="submit" class="text-red-500 hover:text-red-700 font-bold">
                Logout
            </button>
        </form>
    </div>
</body>
</html>