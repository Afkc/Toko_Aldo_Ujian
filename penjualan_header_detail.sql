CREATE TABLE penjualan_header_detail (
    id INT AUTO_INCREMENT PRIMARY KEY,
    no_transaksi VARCHAR(20),
    kode_barang VARCHAR(20),
    qty INT,
    harga DECIMAL(10,2),
    discount DECIMAL(10,2),
    subtotal DECIMAL(10,2),
    FOREIGN KEY (no_transaksi) REFERENCES penjualan_header(no_transaksi)
);
