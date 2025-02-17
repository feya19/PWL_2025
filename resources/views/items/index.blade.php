<!DOCTYPE html>
<html>
<head>
    <title>Daftar Item</title>
</head>
<body>
    <h1>Daftar Item</h1>

    {{-- Periksa apakah ada pesan sukses di sesi --}}
    @if(session('success'))
        <p>{{ session('success') }}</p>
    @endif

    <a href="{{ route('items.create') }}">Tambah Item</a>

    <ul>
        {{-- Loop melalui koleksi item --}}
        @foreach ($items as $item)
            <li>
                {{ $item->name }} -
                <a href="{{ route('items.show', $item) }}">Lihat</a>
                <a href="{{ route('items.edit', $item) }}">Edit</a>

                {{-- Formulir untuk menghapus item --}}
                <form action="{{ route('items.destroy', $item) }}" method="POST" style="display:inline;">
                    @csrf {{-- Perlindungan terhadap serangan CSRF --}}
                    @method('DELETE') {{-- Spoof metode HTTP DELETE --}}
                    <button type="submit">Hapus</button>
                </form>
            </li>
        @endforeach
    </ul>
</body>
</html>
