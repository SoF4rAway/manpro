<?php

use Phinx\Db\Adapter\MysqlAdapter;

class Initial extends Phinx\Migration\AbstractMigration
{
    public function change()
    {
        $this->table('detail_penjualan', [
                'id' => false,
                'engine' => 'InnoDB',
                'encoding' => 'utf8mb4',
                'collation' => 'utf8mb4_general_ci',
                'comment' => '',
                'row_format' => 'DYNAMIC',
            ])
            ->addColumn('id_penjualan', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
            ])
            ->addColumn('id_obat', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'id_penjualan',
            ])
            ->addColumn('quantity', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'id_obat',
            ])
            ->addColumn('harga', 'string', [
                'null' => false,
                'limit' => 20,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'quantity',
            ])
            ->addIndex(['id_penjualan'], [
                'name' => 'fk_penjualan',
                'unique' => false,
            ])
            ->addIndex(['id_obat'], [
                'name' => 'fk_obat',
                'unique' => false,
            ])
            ->create();
        $this->table('obat', [
                'id' => false,
                'primary_key' => ['id_obat'],
                'engine' => 'InnoDB',
                'encoding' => 'utf8mb4',
                'collation' => 'utf8mb4_general_ci',
                'comment' => '',
                'row_format' => 'DYNAMIC',
            ])
            ->addColumn('id_obat', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'identity' => true,
            ])
            ->addColumn('expired', 'date', [
                'null' => false,
                'after' => 'id_obat',
            ])
            ->addColumn('deskripsi', 'text', [
                'null' => false,
                'limit' => 65535,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'expired',
            ])
            ->addColumn('stok', 'integer', [
                'null' => false,
                'limit' => 3,
                'after' => 'deskripsi',
            ])
            ->addColumn('harga', 'integer', [
                'null' => false,
                'limit' => 7,
                'after' => 'stok',
            ])
            ->addColumn('nama_obat', 'string', [
                'null' => false,
                'limit' => 36,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'harga',
            ])
            ->addColumn('foto_obat', 'string', [
                'null' => false,
                'limit' => 100,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'nama_obat',
            ])
            ->create();
        $this->table('penjualan', [
                'id' => false,
                'primary_key' => ['id_penjualan'],
                'engine' => 'InnoDB',
                'encoding' => 'utf8mb4',
                'collation' => 'utf8mb4_general_ci',
                'comment' => '',
                'row_format' => 'DYNAMIC',
            ])
            ->addColumn('id_penjualan', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'identity' => true,
            ])
            ->addColumn('tanggal', 'date', [
                'null' => false,
                'after' => 'id_penjualan',
            ])
            ->addColumn('total_penjualan', 'float', [
                'null' => false,
                'after' => 'tanggal',
            ])
            ->create();
        $this->table('user', [
                'id' => false,
                'primary_key' => ['uid'],
                'engine' => 'InnoDB',
                'encoding' => 'utf8mb4',
                'collation' => 'utf8mb4_general_ci',
                'comment' => '',
                'row_format' => 'DYNAMIC',
            ])
            ->addColumn('uid', 'integer', [
                'null' => false,
                'limit' => 10,
                'identity' => true,
            ])
            ->addColumn('username', 'text', [
                'null' => true,
                'default' => null,
                'limit' => 65535,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'uid',
            ])
            ->addColumn('nama', 'text', [
                'null' => false,
                'limit' => 65535,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'username',
            ])
            ->addColumn('telepon', 'string', [
                'null' => true,
                'default' => null,
                'limit' => 12,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'nama',
            ])
            ->addColumn('password', 'text', [
                'null' => true,
                'default' => null,
                'limit' => 65535,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'telepon',
            ])
            ->addColumn('admin', 'boolean', [
                'null' => false,
                'default' => '0',
                'limit' => MysqlAdapter::INT_TINY,
                'after' => 'password',
            ])
            ->create();
    }
}
