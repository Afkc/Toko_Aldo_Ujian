CREATE TABLE penjualan_header (
    no_transaksi VARCHAR(20) PRIMARY KEY,
    tgl_transaksi DATE,
    customer VARCHAR(100),
    kode_promo VARCHAR(20),
    total_bayar DECIMAL(10,2),
    ppn DECIMAL(10,2),
    grand_total DECIMAL(10,2)
);
