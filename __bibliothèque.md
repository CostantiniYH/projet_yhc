<!--

Liste des Classes Bootstrap
Bootstrap est un framework CSS populaire qui fournit une multitude de classes utilitaires pour le design et la mise en page. Voici une liste non exhaustive des classes Bootstrap les plus couramment utilisées :

Mise en page (Grid System)
----------------------------------
.container
.container-fluid
.row
.col
.col-{breakpoint}-{size} (ex: .col-md-6)
Typographie
.h1 à .h6
.display-1 à .display-4
.lead
.small
.text-muted
.text-primary, .text-secondary, etc.
.font-weight-bold, .font-weight-normal, etc.
.text-uppercase, .text-lowercase, .text-capitalize

Alignement et Espacement
-----------------------------------
.text-left, .text-center, .text-right
.text-justify
.m-{size} (margin)
.p-{size} (padding)
.mt-{size}, .mr-{size}, .mb-{size}, .ml-{size} (margin top, right, bottom, left)
.pt-{size}, .pr-{size}, .pb-{size}, .pl-{size} (padding top, right, bottom, left)

Couleurs de Fond
-----------------------------------
.bg-primary, .bg-secondary, etc.
.bg-light, .bg-dark
.bg-white, .bg-transparent

Bordure
-----------------------------------
.border
.border-top, .border-right, .border-bottom, .border-left
.border-primary, .border-secondary, etc.
.rounded, .rounded-top, .rounded-right, etc.

Flexbox
-----------------------------------
.d-flex
.flex-row, .flex-column
.justify-content-start, .justify-content-center, etc.
.align-items-start, .align-items-center, etc.

Visibilité
-----------------------------------
.d-none, .d-inline, .d-inline-block, .d-block
.d-{breakpoint}-none, .d-{breakpoint}-inline, etc.

Composants
-----------------------------------
.btn, .btn-primary, .btn-secondary, etc.
.card, .card-body, .card-title, etc.
.nav, .nav-item, .nav-link
.list-group, .list-group-item
.modal, .modal-dialog, .modal-content, etc.

-->


<!--

Liste des Classes AOS (Animate On Scroll)
AOS est une bibliothèque qui permet d'ajouter des animations lorsque les éléments entrent dans la vue. Voici une liste des classes AOS les plus couramment utilisées :

Animations
-----------------------------------
.aos-init (classe ajoutée automatiquement par AOS)
.aos-animate (classe ajoutée automatiquement par AOS)
.aos-fade
.aos-fade-up
.aos-fade-down
.aos-fade-left
.aos-fade-right
.aos-fade-up-right
.aos-fade-up-left
.aos-fade-down-right
.aos-fade-down-left
.aos-flip-up
.aos-flip-down
.aos-flip-left
.aos-flip-right
.aos-zoom-in
.aos-zoom-in-up
.aos-zoom-in-down
.aos-zoom-in-left
.aos-zoom-in-right
.aos-zoom-out
.aos-zoom-out-up
.aos-zoom-out-down
.aos-zoom-out-left
.aos-zoom-out-right
.aos-slide-up
.aos-slide-down
.aos-slide-left
.aos-slide-right

Durée de l'Animation
-----------------------------------
data-aos-duration="{duration}" (ex: data-aos-duration="1000" pour 1 seconde)

Délai de l'Animation
-----------------------------------
data-aos-delay="{delay}" (ex: data-aos-delay="500" pour un délai de 0.5 seconde)

Easing
-----------------------------------
data-aos-easing="{easing}" (ex: data-aos-easing="ease-in-out")

Offset
-----------------------------------
data-aos-offset="{offset}" (ex: data-aos-offset="100" pour un offset de 100 pixels)

Animation Une Fois
-----------------------------------
data-aos-once="true" (pour que l'animation ne se déclenche qu'une seule fois)

Animation sur Éléments Enfants
-----------------------------------
data-aos="{animation}" (ex: data-aos="fade-up")
-->

<!--
Bootstrap propose une variété d'attributs pour améliorer l'accessibilité et la fonctionnalité des composants. Voici une liste des attributs Bootstrap les plus couramment utilisés :

Attributs pour les Composants
-----------------------------------

Modals
-----------------------------------
data-bs-toggle="modal" : Active un modal.
data-bs-target="#modalId" : Cible un modal spécifique par son ID.
data-bs-dismiss="modal" : Ferme un modal.

Toasts
-----------------------------------
data-bs-toggle="toast" : Active un toast.
data-bs-autohide="false" : Empêche un toast de se fermer automatiquement.
data-bs-delay="5000" : Définit le délai avant la fermeture automatique d'un toast (en millisecondes).

Tooltips
-----------------------------------
data-bs-toggle="tooltip" : Active un tooltip.
data-bs-placement="top" : Définit la position du tooltip (peut être top, bottom, left, right).
data-bs-title="Tooltip text" : Définit le texte du tooltip.

Popovers
-----------------------------------
data-bs-toggle="popover" : Active un popover.
data-bs-placement="top" : Définit la position du popover (peut être top, bottom, left, right).
data-bs-title="Popover title" : Définit le titre du popover.
data-bs-content="Popover content" : Définit le contenu du popover.

Dropdowns
-----------------------------------
data-bs-toggle="dropdown" : Active un dropdown.
data-bs-auto-close="true" : Ferme automatiquement le dropdown lorsqu'un élément est sélectionné.

Collapse
-----------------------------------
data-bs-toggle="collapse" : Active un élément pliable.
data-bs-target="#collapseId" : Cible un élément pliable spécifique par son ID.

Tabs
-----------------------------------
data-bs-toggle="tab" : Active un onglet.
data-bs-target="#tabId" : Cible un onglet spécifique par son ID.

Carousel
-----------------------------------
data-bs-ride="carousel" : Active un carousel.
data-bs-interval="5000" : Définit l'intervalle entre les diapositives (en millisecondes).
data-bs-slide="next" : Passe à la diapositive suivante.
data-bs-slide="prev" : Revient à la diapositive précédente.

Attributs pour l'Accessibilité
-----------------------------------
ARIA (Accessible Rich Internet Applications)
-----------------------------------
role="alert" : Indique que l'élément est une alerte.
aria-live="assertive" : Indique que l'élément doit être annoncé immédiatement par les technologies d'assistance.
aria-atomic="true" : Indique que l'élément doit être lu comme un tout.
aria-labelledby="id" : Associe un label à un élément par son ID.
aria-describedby="id" : Associe une description à un élément par son ID.
aria-hidden="true" : Masque un élément des technologies d'assistance.
aria-expanded="true" : Indique qu'un élément est étendu (par exemple, un menu déroulant).
aria-controls="id" : Indique qu'un élément contrôle un autre élément par son ID.

Attributs pour les Formulaires
-----------------------------------
data-bs-toggle="buttons" : Active un groupe de boutons.
data-bs-target="#buttonGroup" : Cible un groupe de boutons spécifique par son ID.
required : Indique qu'un champ de formulaire est obligatoire.
disabled : Désactive un champ de formulaire.
readonly : Rend un champ de formulaire en lecture seule.

Attributs pour les Navbars
-----------------------------------
data-bs-toggle="collapse" : Active un élément pliable dans une navbar.
data-bs-target="#navbarId" : Cible un élément pliable spécifique dans une navbar par son ID.

-->

<!--
Animation au survol Bootstrap
-----------------------------------
data-mdb-animation-start="onHover" : Déclenche une animation au survol1.

transition : Définit la durée et le type de transition pour les propriétés CSS. Exemple : transition: transform 0.3s ease3.

transform : Applique des transformations CSS comme scale, rotate, etc. Exemple : transform: scale(1.1)3.

box-shadow : Ajoute des ombres aux éléments. Exemple : box-shadow: 8px 8px 5px blue3.

opacity : Modifie la transparence d'un élément. Exemple : opacity: 0.84.

@keyframes : Définit des animations personnalisées. Exemple : @keyframes zoom { from { transform: scale(1); } to { transform: scale(1.2); } }5.

data-mdb-ripple-color : Change la couleur de l'effet de vague (ripple) au clic ou au survol6.

data-mdb-animation-init : Initialise une animation sur un élément7.

hover : Pseudo-classe CSS utilisée pour appliquer des styles lorsque l'utilisateur passe la souris sur un élément. Exemple : .element:hover { background-color: red; }6.

data-mdb-toggle : Utilisé pour activer des composants interactifs comme les modals ou les menus déroulants au survol6.

data-mdb-dismiss : Utilisé pour fermer des composants interactifs comme les modals ou les alertes au survol6.

data-mdb-target : Utilisé pour cibler un élément spécifique avec une animation ou une interaction au survol6.

data-mdb-animation : Utilisé pour spécifier le type d'animation à appliquer. Exemple : data-mdb-animation="fade"7.

data-mdb-animation-duration : Utilisé pour définir la durée de l'animation. Exemple : data-mdb-animation-duration="1s"7.

data-mdb-animation-delay : Utilisé pour définir le délai avant le début de l'animation. Exemple : data-mdb-animation-delay="0.5s"7.

data-mdb-animation-repeat : Utilisé pour définir le nombre de répétitions de l'animation. Exemple : data-mdb-animation-repeat="infinite"7.

data-mdb-animation-timing : Utilisé pour définir la fonction de timing de l'animation. Exemple : data-mdb-animation-timing="ease-in-out"7.

-->