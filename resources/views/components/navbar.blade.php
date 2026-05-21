@props(['active' => 'beranda'])

<nav class="fixed top-0 left-0 right-0 w-full z-50 bg-white border-b-2 border-gray-300 px-6 py-4">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <div class="flex items-center gap-2">
                <span class="text-2xl font-bold tracking-tight text-primary">TEMPE IRIS</span>
            </div>

            <div class="hidden md:flex space-x-8 text-sm font-medium text-gray-600">
            <a href="/" class="{{ $active === 'beranda' ? 'text-primary border-b-2 border-primary pb-1' : 'hover:text-primary transition' }}">Beranda</a>
            <a href="/fitur" class="{{ $active === 'fitur' ? 'text-primary border-b-2 border-primary pb-1' : 'hover:text-primary transition' }}">Fitur</a>
            <a href="/alur-kerja" class="{{ $active === 'alur' ? 'text-primary border-b-2 border-primary pb-1' : 'hover:text-primary transition' }}">Alur Kerja</a>
            <a href="/tentang" class="{{ $active === 'tentang' ? 'text-primary border-b-2 border-primary pb-1' : 'hover:text-primary transition' }}">Tentang</a>
            </div>

            <div class="flex items-center space-x-4 text-sm font-medium">
                <a href="#" class="text-gray-600 hover:text-primary transition">Login</a>
                <a href="#" class="bg-primary hover:bg-primary-hover text-white px-5 py-2 rounded-md transition shadow-sm">Daftar Akun</a>
            </div>
        </div>
</nav>
