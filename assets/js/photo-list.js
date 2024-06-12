/////// Gestion pagination infinie en page d'accueil

document.addEventListener("DOMContentLoaded", function () {
  (function ($) {
    $(document).ready(function () {
      let currentPage = 1;

      // Gestion de la pagination infinie
      $("#load-more").click(function (e) {
        e.preventDefault();

        // L'URL qui réceptionne les requêtes Ajax dans l'attribut "action" de <form>
        // On récupère le jeton de sécurité
        const nonce = $("#nonce").val();

        // On récupère de l'adresse de la page pour pointer Ajax
        const ajaxurl = $("#ajaxurl").val();

        if (document.getElementById("currentPage") !== null) {
          currentPage = document.getElementById("currentPage").value;
        }
        // On récupère les valeurs des variables du filtre au click
        const categorie_id = document.getElementById("categorie_id").value;
        const format_id = document.getElementById("format_id").value;
        let order = document.getElementById("date").value;
        let orderby = "date";

        let max_pages = document.getElementById("max_pages").value;

        // currentPage + 1, pour pouvoir charger la page suivante
        currentPage++;
        document.getElementById("currentPage").value = currentPage;

        if (currentPage >= max_pages) {
          $("#load-more").addClass("hidden");
        } else {
          $("#load-more").removeClass("hidden");
        }

        $.ajax({
          type: "POST",
          url: ajaxurl,
          dataType: "html", // <-- Change dataType from 'html' to 'json'
          data: {
            action: "nathalie_mota_load",
            nonce: nonce,
            paged: currentPage,
            categorie_id: categorie_id,
            format_id: format_id,
            orderby: orderby,
            order: order,
          },

          success: function (res) {
            $(".photo-list").append(res);

            // Mise à jour du n° de page affiché
            document.getElementById("currentPage").value = currentPage;
          },
        });
      });
    });
  })(jQuery);
});
