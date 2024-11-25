<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SISURAT | <?= $data->title ?></title>
    <?php includeFile("layout/css") ?>
</head>

<body class="admin d-flex">
    <div class="header-layer bg-primary"></div>
    <?php includeFile("layout/sidebar") ?>
    <!--start yang perlu diubah -->
    <main class="flex-grow-1 ">
        <?php includeFile("layout/navbar") ?>
        <div class="p-4">
            <?php if (session()->has("success")): ?>
                <div class="alert alert-success d-flex justify-content-between" role="alert">
                    <?= session()->flash("success") ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>

                </div>
            <?php endif; ?>

            <?php if (session()->has("error")): ?>
                <div class="alert alert-danger d-flex justify-content-between" role="alert">
                    <?= session()->flash("error") ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
            <div class="d-flex align-items-center">
                <div class="">
                    <h2 class="mb-0 text-white"><?= $data->title ?></h2>
                    <p class="text-white text-small"><?= $data->description ?> </p>
                </div>
            </div>


            <form action="<?= $data->action_form ?>" method="post" class="card" enctype="multipart/form-data">
                <div class="card-body">
                    <div class="form-group">
                        <label for="">Nama Format</label>
                        <input value="<?= old("nama", $data->data->nama) ?>" type="text" name="nama" class="form-control" id="">
                        <?php if (session()->has("nama")): ?>
                            <small class="text-danger text-capitalize"><?= session()->error("nama") ?></small>
                        <?php endif; ?>
                    </div>
                    <div class="form-group">
                        <label for="">Konten</label>
                        <textarea name="konten" class="konten" id="">
                            <?= old("konten", $data->data->konten) ?>
                        </textarea>
                        <?php if (session()->has("konten")): ?>
                            <small class="text-danger text-capitalize"><?= session()->error("konten") ?></small>
                        <?php endif; ?>
                    </div>
                    <div class="flex mt-4">
                        <button type="submit" class="btn btn-primary fw-normal">Simpan</button>
                        <a href="<?= url("/admin/format-surat") ?>" class="btn btn-secondary">Kembali</a>
                    </div>
                </div>
            </form>

        </div>
    </main>


    <!--end yang perlu diubah -->
    <?php includeFile("layout/script") ?>


    <script type="module">
        import {
            ClassicEditor,
            Essentials,
            Paragraph,
            Bold,
            Italic,
            Font,
            Alignment,
            Image,
            ImageUpload,
            Table,
            TableToolbar,
            Heading,
            Indent,
            HorizontalLine,
            Underline,
            HtmlEmbed,
            Mention
        } from 'ckeditor5';

        const mention = [
            '{no_surat}',
            '{nama}',
            '{nik}',
            '{tempat_lahir}',
            '{tanggal_lahir}',
            '{jenis_kelamin}',
            '{pekerjaan}',
            '{agama}',
            '{status_perkawinan}',
            '{kewarganegaraan}',
            '{pendidikan}',
            '{alamat}',
            '{rw}',
            '{nama_bapak}',
            '{nik_bapak}',
            '{tempat_lahir_bapak}',
            '{tanggal_lahir_bapak}',
            '{jenis_kelamin_bapak}',
            '{pekerjaan_bapak}',
            '{agama_bapak}',
            '{status_perkawinan_bapak}',
            '{kewarganegaraan_bapak}',
            '{pendidikan_bapak}',
            '{alamat_bapak}',
            '{nama_ibu}',
            '{nik_ibu}',
            '{tempat_lahir_ibu}',
            '{tanggal_lahir_ibu}',
            '{jenis_kelamin_ibu}',
            '{pekerjaan_ibu}',
            '{agama_ibu}',
            '{status_perkawinan_ibu}',
            '{kewarganegaraan_ibu}',
            '{pendidikan_ibu}',
            '{alamat_ibu}',
            '{rt}',
            '{kecamatan}',
            '{desa}',
            '{kabupaten}',
            '{tanggal_pengajuan}'
        ];

        if (document.querySelector('.konten')) {
            ClassicEditor
                .create(document.querySelector('.konten'), {
                    plugins: [Mention, HtmlEmbed, Heading, Essentials, Paragraph, Bold, Italic, Font, Alignment, Image, ImageUpload, Table, TableToolbar, Indent, HorizontalLine, Underline],
                    mention: {
                        feeds: [{
                            marker: '{',
                            feed: mention,
                            minimumCharacters: 0
                        }]
                    },
                    toolbar: [
                        'undo', 'redo', '|', 'underline', 'htmlEmbed',
                        'bold', 'italic', 'underline', 'strikethrough', '|',
                        'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor', '|',
                        'alignment', 'bulletedList', 'numberedList', '|',
                        'link', 'blockQuote', 'insertTable', 'imageUpload', '|',
                        'heading', 'indent', 'outdent', '|',
                        'code', 'codeBlock', '|',
                        // 'removeFormat', 'horizontalLine'
                    ],
                })
                .then(editor => {
                    window.editor = editor;
                })
                .catch(error => {
                    console.error(error);
                });
        }
    </script>
</body>

</html>