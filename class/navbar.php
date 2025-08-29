<?php
class Navbar {
    private $leftItems = [];  
    private $centerItems = [];
    private $rightItems = [];
    private $dropdownItems = [];

    // Ajouter les éléments à une section spécifique
    public function AddItem($name, $link, $section = 'left', $active = false, $class = '') {
        $item = [
            'name' => $name,
            'link' => $link,
            'active' => $active,
            'onclick' => null,
            'class' => $class
        ];
        $itemDrop = [
            'name' => $name,
            'link' => $link,
            'active' => $active,
            'onclick' => null,
            'class' => $class
            ];

        // Détecter si c'est un lien javascript et préparer l'attribut onclick
        if (strpos($link, 'javascript:') === 0) {
            $item['onclick'] = str_replace('javascript:', '', $link);
            $item['link'] = '#';  // Lien neutre pour ne pas recharger la page
            $itemDrop['onclick'] = str_replace('javascript:', '', $link);
            $itemDrop['link'] = '#'; 
        }

        // Ajouter à la bonne section
        if ($section === 'center') {
            $this->centerItems[] = $item; 
        } elseif ($section === 'right') {
            $this->rightItems[] = $item;
        } elseif ($section === 'left') {
            $this->leftItems[] = $item;
        } else {
            $this->dropdownItems[] = $itemDrop;
        }
    }

    // Générer la navbar avec les sections
    public function render() {
        echo '<nav class="navbar navbar-expand-lg shadow mb-5"  data-aos="fade-down" data-aos-duration="1000">';

                echo '<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">';
                    echo '<span class="navbar-toggler-icon"></span>';
                echo '</button>';       

                    echo '<div class="collapse navbar-collapse " id="navbarNav">';

                    echo '<div class="navbar-section left">';
                        $this->renderItems($this->leftItems);
                    echo '</div>';

                        if ($this->dropdownItems) {
                            echo '<div class="navbar-section center rounded-4 bg-white dropdown">';
                                echo '<button class="dropdown-toggle btn btn-white border-0" type="button" id="dropdownMenuButton" 
                                data-bs-toggle="dropdown" aria-expanded="false" aria-haspopup="true">';
                                echo 'Menu';
                                echo '</button>';
                                $this->renderDrops($this->dropdownItems);
                            echo '</div>';
                        }
                        
                    echo '<div class="navbar-section center">';
                        $this->renderItems($this->centerItems);        
                    echo '</div>';

                    echo '<div class="navbar-section right">';
                        $this->renderItems($this->rightItems);
                    echo '</div>';

                echo '</div>';
        echo '</nav>';
    }        

    // Générer les items d'une section
    private function renderItems($items) {
        echo '<ul class="navbar-list" >';
        foreach ($items as $item) {
            $activeClass = $item['active'] ? 'active' : '';
            echo '<li class="navbar-item ' . $activeClass . '" data-aos="flip-up" data-aos-delay="500" data-aos-duration="1000">';
            
            // Vérifier si un onclick est défini
            // Et des classes aux liens
            $itemClass = $item['class'];
            if ($item['onclick']) {
                echo '<a class="p-2 rounded-5 ' . $itemClass .'" href="#" onclick="' . htmlspecialchars($item['onclick']) . '">' . $item['name'] . '</a>';
            } else {
                echo '<a class="p-2 rounded-5 ' . $itemClass .' "  href="' . BASE_URL . htmlspecialchars($item['link']) . '">' . $item['name'] . '</a>';
            }
            
            echo '</li>';
        }
        echo '</ul>';
    }
    private function renderDrops($itemDrops) {
        echo '<ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">';
        foreach ($itemDrops as $itemDrop) {
            $activeClass = $itemDrop['active'] ? 'active' : '';
            echo '<li class=" ' . $activeClass . '">';
            
                // Vérifier si un onclick est défini
                $itemClass = $itemDrop['class'];
                if ($itemDrop['onclick']) {
                    echo '<a class="p-2 rounded-2 dropdown-item ' . $itemClass .' " href="#" onclick="' . htmlspecialchars($itemDrop['onclick']) . '">' . $itemDrop['name'] . '</a>';
                } else {
                    echo '<a class="p-2 rounded-2 dropdown-item ' . $itemClass .' "  href="' .BASE_URL . htmlspecialchars($itemDrop['link']) . '">' . $itemDrop['name'] . '</a>';
                }
            
            echo '</li>';
        }
        echo '</ul>';
    }
}
?>
<script>
    const BASE_URL = '<?= BASE_URL ?>';
</script>