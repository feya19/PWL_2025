<!DOCTYPE html>
<html>
<head>
    <title>Edit Item</title>
</head>
<body>
    <h1>Edit Item</h1>

    {{-- Formulir untuk memperbarui item --}}
    <form action="{{ route('items.update', $item) }}" method="POST">
        @csrf {{-- Perlindungan CSRF --}}
        @method('PUT') {{-- Spoof metode HTTP PUT untuk memperbarui --}}

        <label for="name">Nama:</label>
        <input type="text" name="name" value="{{ $item->name }}" required>
        <br>

        <label for="description">Deskripsi:</label>
        <textarea name="description" required>{{ $item->description }}</textarea>
        <br>

        <button type="submit">Perbarui Item</button>
    </form>

    <a href="{{ route('items.index') }}">Kembali ke Daftar</a>
</body>
</html>
