<?php
class FileUploader
{
    private $targetDir;
    private $allowedFileTypes;
    private $file;
    private $tmp;

    private $targetFile;



    public function __construct($namefile, $tmp="", $file = "", $targetDir = "", $allowedFileTypes = ["jpg", "png", "jpeg", "gif"])

    {
        // dd($file);
        $this->file = $file;
        $this->tmp = $tmp;
        $this->targetDir = $targetDir;

        $this->allowedFileTypes = $allowedFileTypes;
        $this->targetFile = __DIR__ . "/../../upload/" . $this->targetDir . "/" . basename($namefile);
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

    private function moveFile()
    {
        if($this->file==""){

            return move_uploaded_file($this->tmp, $this->targetFile);
        }else{
        return move_uploaded_file($this->file["tmp_name"], $this->targetFile);

        }
    }
    public function delete($fileName)
    {
        $filePath = __DIR__ . "/../../upload/" . $this->targetDir . "/" . basename($fileName);
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
