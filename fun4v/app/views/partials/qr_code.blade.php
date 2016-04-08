<script type="text/javascript">
    $(document).ready(function() {
        url = window.location.href;  
        $('#qr_code').qrcode({width: 120,height: 120, text: url});
    });
</script>