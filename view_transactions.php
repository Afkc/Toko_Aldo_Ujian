<?php
// view_transactions.php
include 'database.php';

// Mengambil data dari tabel penjualan_header dan penjualan_header_detail
$query = "SELECT ph.*, phd.kode_barang, phd.qty, phd.harga, phd.discount, phd.subtotal 
          FROM penjualan_header ph 
          LEFT JOIN penjualan_header_detail phd ON ph.no_transaksi = phd.no_transaksi";
$stmt = $pdo->prepare($query);
$stmt->execute();
$transactions = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Transaksi</title>
    <link rel="stylesheet" href="style.css"> <!-- Link CSS untuk desain -->
</head>
<body>
    <h1>Daftar Transaksi</h1>
    <table border="1">
        <thead>
            <tr>
                <th>No Transaksi</th>
                <th>Tanggal Transaksi</th>
                <th>Customer</th>
                <th>Kode Promo</th>
                <th>Total Bayar</th>
                <th>PPN</th>
                <th>Grand Total</th>
                <th>Detail Barang</th>
                <th>Hapus Transaksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $current_transaction = '';
            foreach ($transactions as $transaction) {
                if ($current_transaction != $transaction['no_transaksi']) {
                    echo "<tr>
                            <td>{$transaction['no_transaksi']}</td>
                            <td>{$transaction['tgl_transaksi']}</td>
                            <td>{$transaction['customer']}</td>
                            <td>{$transaction['kode_promo']}</td>
                            <td>{$transaction['total_bayar']}</td>
                            <td>{$transaction['ppn']}</td>
                            <td>{$transaction['grand_total']}</td>
                            <td>";

                    // Reset untuk detail barang baru
                    $current_transaction = $transaction['no_transaksi'];
                }

                // Menampilkan detail barang
                echo "{$transaction['kode_barang']} (Qty: {$transaction['qty']}, Harga: {$transaction['harga']})<br>";
                
                // Jika ini adalah transaksi terakhir, tambahkan penutup baris
                if ($transaction === end($transactions) || $transactions[array_search($transaction, $transactions) + 1]['no_transaksi'] != $current_transaction) {
                    echo "</td>
                          <td>
                              <form method='POST' action='delete_transaction.php' onsubmit='return confirm(\"Apakah Anda yakin ingin menghapus transaksi ini?\");'>
                                  <input type='hidden' name='no_transaksi' value='{$transaction['no_transaksi']}'>
                                  <button type='submit'>Hapus</button>
                              </form>
                          </td>
                          </tr>";
                }
            }
            ?>
        </tbody>
    </table>
</body>
</html>
