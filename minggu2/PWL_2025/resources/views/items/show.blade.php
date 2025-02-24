<!DOCTYPE html>
<html>
<head>
    <title>Lihat Item</title>
</head>
<body>
    <h1>Lihat Item</h1>

    <table>
        <tr>
            <td>Nama</td>
            <td>:</td>
            <td>{{ $item->name }}</td>
        </tr>
        <tr>
            <td>Deskripsi</td>
            <td>:</td>
            <td>{{ $item->description }}</td>
        </tr>
        <tr>
            <td>Dibuat Pada</td>
            <td>:</td>
            <td>{{ $item->created_at }}</td>
        </tr>
        <tr>
            <td>Diperbarui Pada</td>
            <td>:</td>
            <td>{{ $item->updated_at }}</td>
        </tr>
    </table>

    <a href="{{ route('items.index') }}">Kembali ke Daftar</a>
</body>
</html>
