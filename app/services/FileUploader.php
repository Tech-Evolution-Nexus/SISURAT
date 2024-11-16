<?php
class FileUploader
{
    private $targetDir = "";
    private $allowedFileTypes = ["jpg", "png", "jpeg", "gif"];
    private $tmp;

    // Set the temporary file path (from the uploaded file)
    public function setFile($file)
    {
        $this->tmp = is_array($file) ? $file["tmp_name"] : $file;
    }

    // Set the target directory and file name
    public function setTarget($targetDir = "")
    {
        $this->targetDir = $targetDir;
        // $this->targetFile = __DIR__ . "/../../upload/" . $this->targetDir . "/" . basename($namefile);
    }

    // Set allowed file types
    public function setAllowedFileTypes(array $allowedFileTypes)
    {
        $this->allowedFileTypes = $allowedFileTypes;
    }

    // Method to upload the file
    public function upload()
    {
        if (!$this->isAllowedFileType()) {
            return "Maaf, hanya file " . implode(", ", $this->allowedFileTypes) . " yang diperbolehkan.";
        }

        return $this->moveFile() ? true : "Maaf, terjadi kesalahan saat mengunggah file.";
    }

    // Check if the file type is allowed
    public function isAllowedFileType()
    {
        $fileType = strtolower(pathinfo($this->targetDir, PATHINFO_EXTENSION));
        return in_array($fileType, $this->allowedFileTypes);
    }

    // Move the file to the target directory
    private function moveFile()
    {
        return move_uploaded_file($this->tmp, $this->targetDir);
    }

    // Method to delete a file
    public function delete($targetDir)
    {

        if (file_exists($targetDir)) {
            return unlink($targetDir) ? "File  telah berhasil dihapus." : "Maaf, terjadi kesalahan saat menghapus file.";
        }
        return "Maaf, file tidak ditemukan.";
    }
}
