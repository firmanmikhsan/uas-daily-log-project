@push('js')
    <script type="text/javascript">
        $(function () {
            $("#{{ $uploader }}").on('change', function() {
                var file = $(this)[0].files[0];
                var reader = new FileReader();
                
                reader.onloadend = function() {
                    $('label[for="{{ $uploader }}"]').text(file.name);
                    $("#{{ $previewer }}").attr("src", reader.result);
                }
                if (file) {
                    reader.readAsDataURL(file);
                }
            });
        });
    </script>
@endpush
