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
                    <h5>Jenis Surat :</h5>
                    <div class="row">
                        <div class="col-md-6 col-12">
                            <div class="form-group   mb-4">
                                <label class="">Gambar surat</label>
                                <div class="input-group">
                                    <label style="background-image: url(<?= $data->data->gambar ?>);" class="image-upload w-100 rounded mt-2 flex-column d-flex justify-content-center align-items-center border border-dashed p-4">
                                        <input type="file" class="  form-control d-none image-upload-file" accept="image/*" placeholder="foto_kartu_keluarga" name="file_icon" id="file_icon">
                                        <i class="fa fa-image fs-1 mix-blend-color"></i>
                                        <span class="mix-blend-color">Upload File</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group  mb-2">
                                <label>Nama Surat</label>
                                <div class="input-group mt-1">
                                    <input value="<?= $data->data->nama ?>" type="text" class="form-control" placeholder="Nama Surat" name="nama_surat" id="nama_surat">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4 gap-4">
                        <div class="col-12">
                            <div id="lampiran">
                                <div class="d-flex justify-content-between">
                                    <h5>Lampiran</h5>
                                    <button type="button" id="add-lampiran" class="btn btn-warning"><i class="fa-solid fa-plus"></i></button>
                                </div>
                                <?php foreach ($data->data->lampiran as $i => $lampiran): ?>

                                    <div class="form-group " id="fselect">
                                        <label class="mb-1">Jenis Lampiran</label>
                                        <div class="d-flex">
                                            <select name="lampiran[]" class="form-select" required>
                                                <option value="">Pilih Lampiran</option>
                                                <?php foreach ($data->lampiran  as $index => $datas) : ?>
                                                    <option <?= $datas->id == $lampiran->id_lampiran  ? "selected" : "" ?> value="<?= $datas->id ?>"><?= $datas->nama_lampiran ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                            <?php if ($i > 0): ?>
                                                <button type="button" class="btn btn-danger text-white ms-2" onclick="removeField(this)"><i class="fa-solid fa-trash"></i></button>
                                            <?php endif; ?>
                                        </div>
                                        <input type="hidden" value="<?= $lampiran->id ?>" class="form-control" name="lampiran_id[]" id="">
                                    </div>
                                <?php endforeach; ?>
                                <?php if (count($data->data->lampiran) == 0): ?>
                                    <div class="form-group " id="fselect">
                                        <label class="mb-1">Jenis Lampiran</label>
                                        <select name="lampiran[]" class="form-select" required>
                                            <option value="">Pilih Lampiran</option>
                                            <?php foreach ($data->lampiran  as $index => $datas) : ?>
                                                <option value="<?= $datas->id ?>"><?= $datas->nama_lampiran ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <input type="hidden" value="0" class="form-control" name="lampiran_id[]" id="">
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-12">
                            <div id="fields">
                                <div class="d-flex justify-content-between">
                                    <h5>Fields</h5>
                                    <button type="button" id="add-field" class="btn btn-warning"><i class="fa-solid fa-plus"></i></button>
                                </div>
                                <?php foreach (old("fields", $data->data->fields) as $index => $field): ?>
                                    <div class="form-group " id="fselect">
                                        <div class="row">
                                            <div class="col-5">
                                                <label class="mb-1">Nama Inputan</label>
                                                <input type="text" class="form-control" value="<?= $field->nama_field ?>" placeholder="Name Inputan" required name="fields[]" id="">
                                            </div>
                                            <div class="col-4">
                                                <label class="mb-1">Tipe Data</label>
                                                <select name="typeData[]" class="form-control" id="">
                                                    <option <?= $field->tipe == "text" ? "selected" : "" ?> value="text">Text</option>
                                                    <option <?= $field->tipe == "date" ? "selected" : "" ?> value="date">Date</option>
                                                    <option <?= $field->tipe == "number" ? "selected" : "" ?> value="number">Number</option>
                                                </select>
                                            </div>

                                            <div class="col-2">
                                                <label class="mb-1">Status Input</label>
                                                <div class="form-check form-switch">
                                                    <input type="hidden" name="isRequired[<?= $index ?>]" value="0" id="">
                                                    <input class="form-check-input" value="1" <?= $field->is_required ? "checked" : "" ?> type="checkbox" name="isRequired[<?= $index ?>]" role="switch" id="isRequired1">
                                                    <label class="form-check-label" for="isRequired1">Required</label>
                                                </div>
                                            </div>
                                            <div class="col-1">
                                                <?php if ($index > 0): ?>
                                                    <button type="button" class="btn btn-danger text-white ms-2" onclick="removeField(this)"><i class="fa-solid fa-trash"></i></button>
                                                <?php endif; ?>
                                            </div>
                                        </div>

                                        <input type="hidden" value="<?= $field->id ?>" class="form-control" name="fields_id[]" id="">
                                    </div>
                                <?php endforeach; ?>

                                <!-- <?php if (count($data->data->fields) == 0): ?>
                                    <div class="form-group " id="fselect">

                                        <div class="row">
                                            <div class="col-5">
                                                <label class="mb-1">Nama Inputan</label>
                                                <input type="text" class="form-control" placeholder="Name Inputan" required name="fields[]" id="">
                                            </div>
                                            <div class="col-4">
                                                <label class="mb-1">Tipe Data</label>
                                                <select name="typeData[]" class="form-control" id="">
                                                    <option value="text">Text</option>
                                                    <option value="date">Date</option>
                                                    <option value="number">Number</option>
                                                </select>
                                            </div>

                                            <div class="col-2">
                                                <label class="mb-1">Status Input</label>
                                                <div class="form-check form-switch">
                                                    <input type="hidden" name="isRequired[]" value="0" id="">
                                                    <input class="form-check-input" value="1" type="checkbox" name="isRequired[]" role="switch" id="isRequired1">
                                                    <label class="form-check-label" for="isRequired1">Required</label>
                                                </div>
                                            </div>
                                        </div>
                                        <input type="hidden" value="0" class="form-control" name="fields_id[]" id="">
                                    </div>
                                <?php endif; ?> -->

                            </div>
                        </div>

                    </div>
                    <div class="flex mt-4">
                        <button type="submit" class="btn btn-primary fw-normal">Simpan</button>
                        <a href="<?= url("/admin/kartu-keluarga") ?>" class="btn btn-secondary">Kembali</a>
                    </div>
                </div>


            </form>

        </div>
    </main>


    <!--end yang perlu diubah -->

    <?php includeFile("layout/script") ?>
    <script>
        function addField() {
            const parentEl = $("#fields");
            const countInput = $(parentEl).children(".form-group").length
            console.log(countInput);

            const html = `
           <div class="form-group mt-2" >
                     <div class="row">
                            <div class="col-5">
                                <label class="mb-1">Nama Inputan</label>
                                <input type="text" class="form-control" placeholder="Name Inputan" required name="fields[]" id="">
                            </div>
                            <div class="col-4">
                                <label class="mb-1">Tipe Data</label>
                                <select name="typeData[]" class="form-control" id="">
                                    <option value="text">Text</option>
                                    <option value="date">Date</option>
                                    <option value="number">Number</option>
                                </select>
                            </div>

                            <div class="col-2">
                                <label class="mb-1">Status Input</label>
                                <div class="form-check form-switch">
                                <input type="hidden" name="isRequired[${countInput}]" value="0" id="">
                                    <input class="form-check-input" value="1" type="checkbox" name="isRequired[${countInput}]" role="switch" id="isRequired1">
                                    <label class="form-check-label" for="isRequired1">Required</label>
                                </div>
                            </div>
                            <div class="col-1">
                                ${countInput > 0 ? '<button type="button" class="btn btn-danger text-white ms-2" onclick="removeField(this)"><i class="fa-solid fa-trash"></i></button>':""}
                            </div>
                        </div>
                    </div>
                </div>
                <input type="hidden" value="0" class="form-control" name="fields_id[]" id=""></div>
            `;
            $(parentEl).append(html);
        }

        function addLampiran() {
            const parentEl = $("#lampiran");
            const formGroup = document.createElement("div");
            formGroup.className = "form-group";
            const countInput = $(parentEl).children(".form-group").length
            formGroup.innerHTML = `
                <div class="form-group mt-2" id="fselect">
                <label class="mb-1">Lampiran ${countInput+1}</label>
                <div class="d-flex">
                <select name="lampiran[]" class="form-select" required>
                    <option value="">Pilih Lampiran</option>
                    <?php foreach ($data->lampiran  as $index => $datas) : ?>
                        <option value="<?= $datas->id ?>"><?= $datas->nama_lampiran ?></option>
                    <?php endforeach; ?>
                </select>
                ${countInput > 0 ? '<button type="button" class="btn btn-danger text-white ms-2" onclick="removeField(this)"><i class="fa-solid fa-trash"></i></button>':""}</div>
                <input type="hidden" value="0" class="form-control" name="lampiran_id[]" id="">
                </div>   
            `;
            $(parentEl).append(formGroup);
        }

        function removeField(button) {
            $(button).parent().parent().parent().remove();
        }

        function removeLampiran(button) {
            $(button).parent().parent().remove();
        }

        $("#add-lampiran").on("click", removeLampiran)
        $("#add-field").on("click", addField)
    </script>
</body>

</html>