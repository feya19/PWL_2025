<!DOCTYPE html>
<html>
<head>
    <title>Tambah Item</title>
</head>
<body>
    <h1>Tambah Item</h1>

    {{-- Formulir untuk menambahkan item baru --}}
    <form action="{{ route('items.store') }}" method="POST">
        @csrf {{-- Perlindungan terhadap serangan CSRF --}}

        <label for="name">Nama:</label>
        <input type="text" name="name" required>
        <br>

        <label for="description">Deskripsi:</label>
        <textarea name="description" required></textarea>
        <br>

        <button type="submit">Tambah Item</button>
    </form>

    {{-- Tautan untuk kembali ke daftar item --}}
    <a href="{{ route('items.index') }}">Kembali ke Daftar</a>
</body>
</html>
