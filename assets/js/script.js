document.addEventListener("DOMContentLoaded", function () {
  // console.log("Lecture du DOM");

  // Gestion du menu mobile
  const contactBtn = document.querySelectorAll(".contact");
  const popupOverlay = document.querySelector(".popup-overlay");

  (function ($) {
    $(document).ready(function () {
      // Gestion de la fermeture et de l'ouverture du menu mobile
      $(".btn-modal").click(function (e) {
        $(".modal__content").toggleClass("animate-modal");
        $(".modal__content").toggleClass("open");
        $(".btn-modal").toggleClass("close");
      });
      $("a").click(function () {
        if ($(".modal__content").hasClass("open")) {
          $(".modal__content").removeClass("animate-modal");
          $(".modal__content").removeClass("open");
          $(".btn-modal").removeClass("close");
        }
      });
    });
  })(jQuery);

  // Ouverture de la popup contact au clic sur le lien contact
  contactBtn.forEach((contact) => {
    contact.addEventListener("click", () => {
      popupOverlay.classList.remove("hidden");
      // on re récupére la référence et on l'ajoute dans le formulaire
      if (document.querySelector(".reference") !== null) {
        let ref = document.querySelector(".reference").innerText.substring(11);
        ref = ref.trim();
        if (document.querySelector(".refphoto") !== null) {
          document.querySelector(".refphoto").value = ref;
        }
      }
    });
  });

  // Refermeture de la pop contact au clic
  popupOverlay.addEventListener("click", (e) => {
    if (e.target.className == "popup-overlay") {
      popupOverlay.classList.add("hidden");
    }
  });

  ///////////////////////////////////
  ////Gestion des filtres
  ///////////////////////////////////

  let body = document.querySelector("body");
  const allSelect = document.querySelectorAll("select");
  const message = "<p>Désolé. Aucun article ne correspond à votre demande.<p>";

  // Initialisation des variables des filtres au premier affichage du site
  let categorie_id = "";
  if (document.getElementById("categorie_id")) {
    document.getElementById("categorie_id").value = "";
  }
  let format_id = "";
  if (document.getElementById("format_id")) {
    document.getElementById("format_id").value = "";
  }
  let order = "";
  if (document.getElementById("date")) {
    document.getElementById("date").value = "";
  }

  let currentPage = 1;
  let max_pages = 1;
  let selectId = "";

  document.getElementById("currentPage").value = 1;

  (function ($) {
    $(document).ready(function () {
      $("select").select2({ width: "100%" });

      $(".option-filter").change(function (e) {
        // Empêcher l'envoi classique du formulaire
        e.preventDefault();

        // Récupération du jeton de sécurité
        const nonce = $("#nonce").val();

        // Récupération de l'adresse de la page	pour pointer Ajax
        const ajaxurl = $("#ajaxurl").val();

        if (document.getElementById("max_pages") !== null) {
          max_pages = document.getElementById("max_pages").value;
        }

        // Récupération des valeurs sélectionnées
        let targetName = e.target.name;
        let targetValue = e.target.value;

        // Réaffectation de la valeur dans la variable correspondante
        if (targetName === "categorie_id") {
          categorie_id = targetValue;
        }
        if (targetName === "format_id") {
          format_id = targetValue;
        }
        if (targetName === "date") {
          order = targetValue;
        }

        let orderby = "date";

        // Génération du nouvel affichage
        $.ajax({
          type: "POST",
          url: ajaxurl,
          dataType: "html", // <-- Change dataType from 'html' to 'json'
          data: {
            action: "nathalie_mota_load",
            nonce: nonce,
            paged: 1,
            categorie_id: categorie_id,
            format_id: format_id,
            orderby: orderby,
            order: order,
          },
          success: function (res) {
            $(".photo-list").empty().append(res);
            // Récupération de la valeur du nouveau nombre de pages
            let max_pages = document.getElementById("max_pages").value;
            let nb_total_posts = 0;

            // Affiche ou cache le bouton "Charger plus" en fonction du nombre de pages
            if (currentPage >= max_pages) {
              $("#load-more").addClass("hidden");
            } else {
              $("#load-more").removeClass("hidden");
            }

            // Contrôle s'il y a des photos à afficher
            if (document.getElementById("nb_total_posts") !== null) {
              nb_total_posts = document.getElementById("nb_total_posts").value;
            }

            // Et affiche un message s'il n'y a aucune photo à afficher
            if (nb_total_posts == 0) {
              $(".photo-list").append(message);
            }

            // Réinitialisation du n° de page affiché
            document.getElementById("currentPage").value = 1;
          },
        });
      });
    });
  })(jQuery);
});
