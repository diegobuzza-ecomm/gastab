<?php

function contactFormExternal($id = ''){

    // Si en Site options > Forms hay código cargado y activado, se usa ese.
    $options = get_option('mati_theme_options');
    if (!empty($options['contactform_external_code_enabled']) && !empty($options['contactform_external_code'])) {
        echo $options['contactform_external_code'];
        return;
    }

    // Formulario Zoho Forms "Contacto"
    ?>
<iframe id="ziframe_200464" aria-label="Contacto" frameborder="0" style="height:500px;width:99%;border:none;" src='https://forms.zohopublic.com/gastab1/form/Contacto/formperma/xUwMTxlY2Yb00gOudcO3HyKNhSgeVjCdKHbMedelRz8'></iframe>

<script type="text/javascript">
(function() {
  try {
    var zf_frame = document.getElementById("ziframe_200464");
    var ifrmSrc = zf_frame.src;
        if (!((new RegExp("[?&]referrername=")).test(ifrmSrc))) {
            var rfr = window.location.href;
            try {
                rfr = window.self !== window.top ?
                    window.top.location.href :
                    (/^https?:\/\/[\w.-]+\.[a-zA-Z]{2,}/i.test(rfr) ? rfr : "");
            } catch (e) {}
            if (rfr && rfr !== "") {
                if (rfr.length > 1800) {
                    var queryIndex = rfr.indexOf('?');
                    if (queryIndex > -1) {
                        rfr = rfr.substring(0, queryIndex);
                    }
                    if (rfr.length > 1800) {
                        rfr = rfr.substring(0, 1800);
                    }
                }
                ifrmSrc += ((ifrmSrc.indexOf('?') > 0) ? '&' : '?') + 'referrername=' + encodeURIComponent(rfr);
            }
        }
        if (zf_frame.src !== ifrmSrc) {
            zf_frame.src = ifrmSrc;
        }
  } catch (e) {}
})();
</script>
    <?php
}
