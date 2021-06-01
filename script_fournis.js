$(document).ready(function () {
    $('.update').click(function () {
        dat = {
            id_mod_jq: $(this).val()
        }
        $.get("apiFourni.php", dat,
            function (ligne, status) {
                $("#id_mod_jq").val(ligne.id);
                $("#nomprenom_jq").val(ligne.nomprenom);
                $("#tel1_jq").val(ligne.tel1);
                $("#tel2_jq").val(ligne.tel2);
                $("#email_jq").val(ligne.email);
                $("#adresse_jq").val(ligne.adresse);
                $("#remarques_jq").html(ligne.remarques);
            });
    });
    $('.info').click(function () {
        dat = {
            id_mod_jq: $(this).val()
        }
        $.get("apiFourni.php", dat,
            function (ligne, status) {
                console.log(ligne);
                $("#id_sup").val(ligne.id);
                $("#nomprenom_info").html(ligne.nomprenom);
                $("#tel1_info").html(ligne.tel1);
                $("#tel2_info").html(ligne.tel2);
                $("#email_info").html(ligne.email);
                $("#adresse_info").html(ligne.adresse);
                $("#remarques_info").html(ligne.remarques);
            });
    });

});