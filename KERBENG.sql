use damairesto

DELIMITER $$
CREATE PROCEDURE GetInformasi(IN hidangan_id integer(11), IN nomor_meja integer(11),
IN nama_pelanggan VARCHAR(100),IN kuantitas integer(11), IN antrian integer(11), 
IN waktu integer(11))
BEGIN
DECLARE hitung integer;
DECLARE informasi integer;
set hitung = antrian/3;
set informasi=waktu*hitung;
INSERT INTO `pesanans` (`id`,`hidangan_id`, `nomor_meja`, `nama_pelanggan`, `kuantitas`, `informasi`, `created_at`, `updated_at`)
 VALUES (null,hidangan_id,nomor_meja, nama_pelanggan, kuantitas, informasi, now(), now());
END$$
DELIMITER ;


DELIMITER $$
CREATE PROCEDURE `GetPesanan`(IN meja VARCHAR(100))
BEGIN
select nomor_meja, tanggal, nama_pelanggan, SUM(harga) as total_harga
from viewpesanan where nomor_meja=meja;
END$$
DELIMITER ;



select id, nomor_meja, tanggal, nama_pelanggan, SUM(harga) as total_harga
from viewpesanan group by nomor_meja;

Call GetPesanan(14);
    
CREATE OR REPLACE VIEW antrians AS 
select count(nomor_meja) AS antrian from viewurutan;

//mke %id buat delete
CREATE OR REPLACE VIEW viewpesanan AS 
	SELECT ps.id, ps.nomor_meja, h.kode_hidangan ,ps.nama_pelanggan,h.nama_hidangan, ps.kuantitas, h.harga,
		ps.created_at AS Tanggal,h.waktu as informasi
		FROM hidangans h, pesanans ps, hidangan_pesanan hp
			WHERE
			hp.hidangan_kode_hidangan = h.kode_hidangan;
            group by nomor meja;


select * from pesanans;

CREATE VIEW customerOrders AS
    SELECT 
        d.orderNumber,
        customerName,
        SUM(quantityOrdered * priceEach) total
    FROM
        orderDetails d
            INNER JOIN
        orders o ON o.orderNumber = d.orderNumber
            INNER JOIN
        customers c ON c.customerNumber = c.customerNumber
    GROUP BY d.orderNumber
    ORDER BY total DESC;

CREATE OR REPLACE VIEW viewurutan AS 
select nomor_meja from viewpesanan 
	group by nomor_meja;
    
    
    
DELETE FROM pesanans
WHERE nama_pelanggan = 'Arif'; 

CREATE OR REPLACE VIEW viewpesanan AS
SELECT p.nomor_meja, h.kode_hidangan, p.nama_pelanggan, p.kuantitas, h.harga,
p.created_at AS Tanggal,h.waktu as informasi  
from hidangan_pesanan hp
INNER JOIN 
pesanans p ON p.id = hp.pesanan_id
INNER JOIN
hidangans h ON h.kode_hidangan = hp.hidangan_kode_hidangan;

SELECT * from viewpesanan group by nomor_meja;

select * from pesanans;

DELETE FROM viewpesanan
WHERE id = 14; 

select id, kode_hidangan, nomor_meja, tanggal, nama_pelanggan, SUM(harga) as total_harga from viewpesanan group by nomor_meja;

select count

statistika group by created date

select * from statistikas;

CREATE OR REPLACE VIEW viewrestmng AS
select nomor_meja, count(kode_hidangan) as total_order, tanggal, nama_pelanggan, SUM(harga) as total_harga from viewpesanan group by nomor_meja;

select * from viewrestmng;

CREATE OR REPLACE VIEW viewpelanggan AS
select nama_pelanggan from pesanans group by nama_pelanggan;

CREATE OR REPLACE VIEW total_pelanggan AS
select count(nama_pelanggan) from viewpelanggan group by nama_pelanggan;


