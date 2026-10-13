@props([
    'id' => 'modal',
])

<div
    id="{{ $id }}"
    class="fixed inset-0 z-50 hidden items-center justify-center bg-black/40 px-4"
>
    <div class="w-full max-w-md rounded-3xl bg-white p-8 shadow-xl">

        <div class="mb-5 flex justify-center">
            <div class="flex h-16 w-16 items-center justify-center rounded-full bg-green-100">
                <svg xmlns="http://www.w3.org/2000/svg"
                    class="h-9 w-9 text-green-600"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="2">
                    <path stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M5 13l4 4L19 7"/>
                </svg>
            </div>
        </div>

        <h2
            id="{{ $id }}Title"
            class="text-center text-2xl font-bold text-slate-800">
        </h2>

        <p
            id="{{ $id }}Message"
            class="mt-4 text-center text-slate-600">
        </p>

        <div class="mt-8">
            <button
                type="button"
                onclick="closeModal('{{ $id }}')"
                class="w-full rounded-xl bg-primary-hover py-3 font-semibold text-white hover:bg-primary">
                OK
            </button>
        </div>

    </div>
</div>