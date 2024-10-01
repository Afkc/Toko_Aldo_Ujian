<?php
// delete_transaction.php
include 'database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $no_transaksi = $_POST['no_transaksi'];

    try {
        // Mulai transaksinya
        $pdo->beginTransaction();

        // Hapus detail penjualan terlebih dahulu
        $stmt = $pdo->prepare("DELETE FROM penjualan_header_detail WHERE no_transaksi = ?");
        $stmt->execute([$no_transaksi]);

        // Hapus header penjualan
        $stmt = $pdo->prepare("DELETE FROM penjualan_header WHERE no_transaksi = ?");
        $stmt->execute([$no_transaksi]);

        // Commit transaksinya
        $pdo->commit();

        echo "Transaksi dengan No: $no_transaksi berhasil dihapus.";
    } catch (Exception $e) {
        // Rollback jika ada kesalahan
        $pdo->rollBack();
        echo "Terjadi kesalahan: " . $e->getMessage();
    }

    // Redirect kembali ke daftar transaksi setelah penghapusan
    header("Location: view_transactions.php");
    exit();
}
