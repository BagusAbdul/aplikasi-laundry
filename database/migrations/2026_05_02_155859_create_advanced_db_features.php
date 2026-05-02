<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        // 1. FUNCTION: Menghitung total transaksi
        DB::unprepared("
            CREATE FUNCTION HitungTotalTransaksi(trans_id BIGINT) RETURNS INT
            DETERMINISTIC
            BEGIN
                DECLARE total INT;
                SELECT SUM(subtotal) INTO total FROM detail_transaksi WHERE transaksi_id = trans_id;
                RETURN IFNULL(total, 0);
            END
        ");

        // 2. TRIGGER: Auto update status transaksi saat pembayaran masuk
        DB::unprepared("
            CREATE TRIGGER tr_after_insert_pembayaran
            AFTER INSERT ON pembayaran
            FOR EACH ROW
            BEGIN
                UPDATE transaksi
                SET dibayar = 'dibayar', tanggal_bayar = NEW.tanggal_pembayaran
                WHERE id = NEW.transaksi_id;
            END
        ");

        // 3. STORED PROCEDURE: Proses pembayaran aman dengan DB Transaction (Commit/Rollback)
        DB::unprepared("
            CREATE PROCEDURE ProsesPembayaran(
                IN p_transaksi_id BIGINT,
                IN p_jumlah INT,
                IN p_metode VARCHAR(50),
                IN p_tanggal DATETIME
            )
            BEGIN
                DECLARE exit handler for sqlexception
                BEGIN
                    -- ROLLBACK jika terjadi error (misal tipe data salah atau server mati)
                    ROLLBACK;
                END;

                START TRANSACTION;

                -- Insert ke tabel pembayaran (Ini akan memicu Trigger otomatis)
                INSERT INTO pembayaran (transaksi_id, jumlah_bayar, metode_pembayaran, tanggal_pembayaran, created_at, updated_at)
                VALUES (p_transaksi_id, p_jumlah, p_metode, p_tanggal, NOW(), NOW());

                -- COMMIT jika sukses
                COMMIT;
            END
        ");
    }

    public function down(): void
    {
        DB::unprepared("DROP PROCEDURE IF EXISTS ProsesPembayaran");
        DB::unprepared("DROP TRIGGER IF EXISTS tr_after_insert_pembayaran");
        DB::unprepared("DROP FUNCTION IF EXISTS HitungTotalTransaksi");
    }
};
