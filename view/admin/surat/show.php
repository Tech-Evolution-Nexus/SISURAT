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


            <div class="card">
                <div class="card-body">
                    <img src="<?= $data->data->gambar ?>" class="" alt="">
                </div>
            </div>
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