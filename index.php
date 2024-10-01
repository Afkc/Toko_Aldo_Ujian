<?php
// index.php
include 'database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $customer = $_POST['customer'];
    $kode_promo = $_POST['kode_promo'];
    $items = $_POST['items']; // Array of items with format ['kode_barang' => ['qty' => qty, 'harga' => harga]]

    // Buat nomor transaksi baru
    $no_transaksi = date('Ymd') . '-' . str_pad(rand(1, 999), 3, '0', STR_PAD_LEFT);
    $tgl_transaksi = date('Y-m-d');

    // Hitung total bayar
    $total_bayar = 0;
    foreach ($items as $item) {
        $qty = $item['qty'];
        $harga = $item['harga'];
        $subtotal = $qty * $harga;
        $total_bayar += $subtotal;
    }

    // Hitung PPN dan Grand Total
    $ppn = $total_bayar * 0.1; // 10% PPN
    $grand_total = $total_bayar + $ppn;

    // Simpan header penjualan
    $stmt = $pdo->prepare("INSERT INTO penjualan_header (no_transaksi, tgl_transaksi, customer, kode_promo, total_bayar, ppn, grand_total) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$no_transaksi, $tgl_transaksi, $customer, $kode_promo, $total_bayar, $ppn, $grand_total]);

    // Simpan detail penjualan setelah header berhasil disimpan
    foreach ($items as $kode_barang => $item) {
        $qty = $item['qty'];
        $harga = $item['harga'];
        $subtotal = $qty * $harga;

        // Simpan detail penjualan
        $stmt = $pdo->prepare("INSERT INTO penjualan_header_detail (no_transaksi, kode_barang, qty, harga, discount, subtotal) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$no_transaksi, $kode_barang, $qty, $harga, 0, $subtotal]);
    }

    echo "Transaksi berhasil disimpan! No Transaksi: $no_transaksi";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaksi Penjualan</title>
    <link rel="stylesheet" href="style.css"> <!-- Link CSS untuk desain -->
</head>
<body>
    <h1>Form Transaksi Penjualan</h1>
    <form method="POST" action="">
        <label for="customer">Nama Customer:</label>
        <input type="text" name="customer" required>

        <label for="kode_promo">Kode Promo:</label>
        <input type="text" name="kode_promo">

        <h3>Daftar Barang:</h3>
        <div id="items">
            <div class="item">
                <select name="items[001][kode_barang]">
                    <option value="001">Skin Care</option>
                    <option value="002">Body Care</option>
                    <option value="003">Facial Care</option>
                    <option value="004">Hair Care</option>
                </select>
                <input type="number" name="items[001][qty]" placeholder="Qty" required>
                <input type="text" name="items[001][harga]" placeholder="Harga" required>
            </div>
            <!-- Tambahkan item lainnya di sini -->
             <!-- Tambahkan ini di bawah form -->
<a href="view_transactions.php">Lihat Daftar Transaksi</a>

        </div>
        
        <button type="submit">Simpan Transaksi</button>
    </form>
</body>
</html>
