<?php
class FileUploader
{
    private $targetDir;
    private $allowedFileTypes;
    private $file;
    private $targetFile;

    public function __construct($file, $targetDir = "", $allowedFileTypes = ["jpg", "png", "jpeg", "gif"])
    {
        $this->file = $file;
        $this->targetDir = $targetDir;
        $this->allowedFileTypes = $allowedFileTypes;
        $this->targetFile = $this->targetDir . basename($this->file["name"]);
    }

    // Metode untuk mengunggah file
    public function upload()
    {
        // if (!$this->isAllowedFileType()) {
        //     return "Maaf, hanya file " . implode(", ", $this->allowedFileTypes) . " yang diperbolehkan.";
        // }

        // if ($this->fileExists()) {
        //     return "Maaf, file sudah ada.";
        // }

        if ($this->moveFile()) {
            return true;
        }

        return "Maaf, terjadi kesalahan saat mengunggah file.";
    }

    // Metode untuk mengecek tipe file
    public function isAllowedFileType()
    {
        $fileType = strtolower(pathinfo($this->targetFile, PATHINFO_EXTENSION));
        return in_array($fileType, $this->allowedFileTypes);
    }

    // Metode untuk mengecek apakah file sudah ada
    private function fileExists()
    {
        return file_exists($this->targetFile);
    }

    // Metode untuk memindahkan file ke direktori tujuan
    private function moveFile()
    {
        return move_uploaded_file($this->file["tmp_name"], $this->targetFile);
    }
    public function delete($fileName)
    {
        $filePath = $this->targetDir . basename($fileName);
        if (file_exists($filePath)) {
            if (unlink($filePath)) {
                return "File $fileName telah berhasil dihapus.";
            } else {
                return "Maaf, terjadi kesalahan saat menghapus file.";
            }
        } else {
            return "Maaf, file tidak ditemukan.";
        }
    }
}
?>
