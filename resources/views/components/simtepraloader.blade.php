<div id="simtepraloader">
    <div class="simtepraloader-spinner"></div>
</div>

<script>
    window.addEventListener('load', function () {
        const loader = document.getElementById('simtepraloader');

        if (loader) {
            loader.classList.add('hide');

            setTimeout(function () {
                loader.remove();
            }, 300);
        }
    });
</script>