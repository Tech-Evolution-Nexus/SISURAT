<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="<?= assets("bootstrap/js/bootstrap.min.js") ?>"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script type="importmap">
    {
				"imports": {
					"ckeditor5": "https://cdn.ckeditor.com/ckeditor5/43.3.1/ckeditor5.js",
					"ckeditor5/": "https://cdn.ckeditor.com/ckeditor5/43.3.1/"
				}
			}
		</script>
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
        Mention,
        TableColumnResize,
    } from 'ckeditor5';

    if (document.querySelector('.editor')) {
        ClassicEditor
            .create(document.querySelector('.editor'), {
                plugins: [Mention, HtmlEmbed, Heading, Essentials, Paragraph, Bold, Italic, Font, Alignment, Image, ImageUpload, TableColumnResize, TableToolbar, Table, Indent, HorizontalLine, Underline],
                table: {
                    contentToolbar: ['tableColumn', 'tableRow', 'mergeTableCells']
                },
                indentBlock: {
                    offset: 1,
                    unit: 'em'
                },
                toolbar: [
                    'undo', 'redo', '|', 'underline', 'htmlEmbed',
                    'bold', 'italic', 'underline', 'strikethrough', '|',
                    'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor', '|',
                    'alignment', 'bulletedList', 'numberedList', '|',
                    'link', 'blockQuote', 'insertTable', 'imageUpload', '|',
                    'heading', 'indent', 'outdent', '|',
                    'code', 'codeBlock', '|',
                    'removeFormat', 'horizontalLine'
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


<script>
    $(document).ready(function() {
        $(".nav-toggle").on("click", function() {
            if ($(".sidebar").hasClass("active")) {
                $(".sidebar").removeClass("active")
            } else {
                $(".sidebar").addClass("active")
            }
        });

        const sidebarItem = $(".side-link");
        const pathname = window.location.pathname;
        sidebarItem.each(function() {
            let href = $(this).attr("href");
            let protocolHost = window.location.protocol + '//' + window.location.host;
            href = href.replace(protocolHost, "");
            if (pathname == href) {
                $(this).addClass("bg-primary");
                $(this).attr("style", "color: white !important;");
            }
        });

        // phone format
        // Format nomor telepon saat pengguna mengetik
        $('.phone-format').on('input', function() {
            let formattedPhone = $(this).val().replace(/\D/g, ""); // Hapus semua karakter non-digit
            if (formattedPhone.length > 3 && formattedPhone.length <= 7) {
                formattedPhone = formattedPhone.replace(/(\d{3})(\d+)/, "$1-$2");
            } else if (formattedPhone.length > 7) {
                formattedPhone = formattedPhone.replace(/(\d{3})(\d{4})(\d+)/, "$1-$2-$3");
            }
            if (formattedPhone.length <= 13) {

                $(this).val(formattedPhone);
            }
        });

        $(".only-number").on("input", function(event) {
            event.target.value = event.target.value.replace(/[^0-9]/g, '');
        })

        // Toggle visibility of the password field
        $('.toggle-password').on('click', function() {
            const passwordInput = $(this).siblings('input[type="password"], input[type="text"]');
            const type = passwordInput.attr('type') === 'password' ? 'text' : 'password';
            passwordInput.attr('type', type);
            $(this).html(type === 'password' ? '<i class="fa fa-eye"></i>' : '<i class="fa fa-eye-slash"></i>');
        });


        $('.data-table').DataTable({
            responsive: true
        });
        $('.select2').select2({
            placeholder: $(".select2").attr("data-placeholder"),
        });
        $('.select2-modal').select2({
            dropdownParent: $('.modal'),
            placeholder: $(".select2-modal").attr("data-placeholder"),
            allowClear: true
        });

        setTimeout(() => {
            $(".alert").removeClass("d-flex").hide();
        }, 3000);


        const showSwalDelete = () => {
            const deleteUrl = $(".deleteBtn").attr("data-url");
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data ini akan dihapus dan tidak bisa dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Hapus',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`${deleteUrl}`, {
                            method: 'POST'
                        })
                        .then(response => {

                            if (response.ok) {
                                Swal.fire(
                                    'Dihapus!',
                                    'Data telah dihapus.',
                                    'success'
                                ).then(() => {
                                    // location.reload();
                                });
                            } else {
                                Swal.fire(
                                    'Gagal!',
                                    'Terjadi kesalahan saat menghapus data.',
                                    'error'
                                );
                            }


                            return response.json()
                        }).then(res => console.log(res))
                        .catch(error => {
                            console.log(error);

                            Swal.fire(
                                'Gagal!',
                                'Terjadi kesalahan saat menghapus data.',
                                'error'
                            );
                        });
                }
            });
        }
        $(".deleteBtn").on("click", showSwalDelete);


        $(".password-toggle").on("click", function() {
            const passwordField = $(this).parent().find("input[type='password'], input[type='text']");
            const fieldType = passwordField.attr("type") === "password" ? "text" : "password";
            if (passwordField.attr("type") === "password") {
                $(this).find("i").addClass("fa-eye-slash")
                $(this).find("i").removeClass("fa-eye")
            } else {
                $(this).find("i").removeClass("fa-eye-slash")
                $(this).find("i").addClass("fa-eye")
            }
            const font = passwordField.attr("type") === "password" ? $(this).addClass("") : $(this).removeClass("");
            passwordField.attr("type", fieldType);

        });


        //hanle image preview
        $(".image-upload-file").on("change", function() {
            const file = $(this)[0].files[0];
            const imageUrl = URL.createObjectURL(file);
            $(this).parent().css("backgroundImage", `url(${imageUrl})`);
            $(this).parent().find("i,span").hide();
        })




    })
</script>