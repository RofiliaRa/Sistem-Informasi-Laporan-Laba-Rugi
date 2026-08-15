<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class BackupController extends Controller
{
    /**
     * Backup database
     */
    public function backup()
    {
        // Ambil konfigurasi database dari .env
        $database = config('database.connections.mysql.database');
        $username = config('database.connections.mysql.username');
        $password = config('database.connections.mysql.password');

        // Lokasi mysqldump Laragon
        $mysqldump = 'C:\\laragon\\bin\\mysql\\mysql-8.0.30-winx64\\bin\\mysqldump.exe';

        // Folder penyimpanan sementara
        $folder = storage_path('app/backups');

        // Buat folder jika belum ada
        if (!File::exists($folder)) {
            File::makeDirectory($folder, 0755, true);
        }

        // Nama file backup
        $namaFile = 'backup_' . date('Y-m-d_H-i-s') . '.sql';

        // Lokasi file backup
        $pathFile = $folder . DIRECTORY_SEPARATOR . $namaFile;

        // Command mysqldump
        $command = '"' . $mysqldump . '"'
            . ' --host=127.0.0.1'
            . ' --port=3306'
            . ' --user=' . $username;

        // Tambahkan password jika ada
        if ($password !== null && $password !== '') {
            $command .= ' --password=' . $password;
        }

        // Tambahkan database
        $command .= ' ' . $database;

        // Simpan hasil mysqldump ke file SQL
        $command .= ' > "' . $pathFile . '" 2>&1';

        // Jalankan command
        exec($command, $outputLines, $returnCode);

        // Jika command gagal
        if ($returnCode !== 0) {

            if (File::exists($pathFile)) {
                File::delete($pathFile);
            }

            return response()->json([
                'status' => 'gagal',
                'error' => 'Backup database gagal.',
                'detail' => implode("\n", $outputLines),
            ], 500);
        }

        // Pastikan file backup ada
        if (!File::exists($pathFile) || File::size($pathFile) === 0) {

            if (File::exists($pathFile)) {
                File::delete($pathFile);
            }

            return response()->json([
                'status' => 'gagal',
                'error' => 'File backup berhasil dibuat tetapi kosong.'
            ], 500);
        }

        // Download file backup
        return response()->download(
            $pathFile,
            $namaFile,
            [
                'Content-Type' => 'application/sql',
            ]
        )->deleteFileAfterSend(true);
    }

    /**
     * Restore database
     */
    public function restore(Request $request)
    {
        // Validasi file backup
        $request->validate([
            'backup_file' => 'required|file|max:51200',
        ]);

        $file = $request->file('backup_file');

        // Pastikan file memiliki ekstensi .sql
        if (strtolower($file->getClientOriginalExtension()) !== 'sql') {
            return back()->with(
                'error',
                'File restore harus berformat .sql.'
            );
        }

        // Ambil konfigurasi database dari .env
        $database = config('database.connections.mysql.database');
        $username = config('database.connections.mysql.username');
        $password = config('database.connections.mysql.password');

        // Lokasi mysql.exe Laragon
        $mysql = 'C:\\laragon\\bin\\mysql\\mysql-8.0.30-winx64\\bin\\mysql.exe';

        // Folder penyimpanan sementara
        $folder = storage_path('app/backups');

        // Buat folder jika belum ada
        if (!File::exists($folder)) {
            File::makeDirectory($folder, 0755, true);
        }

        // Simpan file upload sementara
        $namaFile = 'restore_' . date('Y-m-d_H-i-s') . '.sql';

        $pathFile = $folder . DIRECTORY_SEPARATOR . $namaFile;

        $file->move($folder, $namaFile);

        // Command mysql
        $command = '"' . $mysql . '"'
            . ' --host=127.0.0.1'
            . ' --port=3306'
            . ' --user=' . $username;

        // Tambahkan password jika ada
        if ($password !== null && $password !== '') {
            $command .= ' --password=' . $password;
        }

        // Tambahkan database tujuan
        $command .= ' ' . $database;

        // Masukkan file SQL ke database
        $command .= ' < "' . $pathFile . '" 2>&1';

        // Jalankan command restore
        exec($command, $outputLines, $returnCode);

        // Hapus file SQL sementara
        if (File::exists($pathFile)) {
            File::delete($pathFile);
        }

        // Jika restore gagal
        if ($returnCode !== 0) {
            return back()->with(
                'error',
                'Restore database gagal: ' . implode("\n", $outputLines)
            );
        }

        // Jika restore berhasil
        return back()->with(
            'success',
            'Database berhasil direstore dari file backup.'
        );
    }
}