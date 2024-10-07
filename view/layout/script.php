<script src="<?= assets("bootstrap/js/bootstrap.min.js") ?>"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>


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
                $(this).addClass("bg-info");
            }
        });
    })
</script>