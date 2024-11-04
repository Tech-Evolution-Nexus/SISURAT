<script src="<?= assets("bootstrap/js/bootstrap.min.js") ?>"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<!-- code show hide navbar -->
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
            const href = $(this).attr("href");

            // Cek apakah href sesuai dengan pathname
            if (pathname.includes(href)) {
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

    })
</script>