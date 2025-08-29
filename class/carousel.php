<?php

class Carousel {
    private function Image($array, $carouselId) {
        $html = '';
        foreach ($array as $key => $a) {
            $html .= '
                <div class="carousel-item ' . ($key == 0 ? 'active' : '') . '">
                    <img loading="lazy" src="' . htmlspecialchars($a['link']) . '" 
                    class="d-block w-100 img-carousel" alt="..." usemap="#map' . htmlspecialchars($carouselId) . '">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>' . htmlspecialchars($a['text']) . '</h5>
                    </div>
                </div>';
        }
        return $html;
    }

    private function Indicators($array, $carouselId) {
        $html = '';
        foreach ($array as $key => $a) {
            $html .= '
                <button type="button" data-bs-target="#' . htmlspecialchars($carouselId) . '" 
                        data-bs-slide-to="' . $key . '" 
                        class="' . ($key == 0 ? 'active' : '') . '" 
                        aria-label="Slide ' . ($key + 1) . '">
                </button>';
        }
        return $html;
    }
    

    public function Read($a, $carouselId) {
        if (empty($a) || !is_array($a)) {
            echo '<p>Aucune image disponible pour le carousel.</p>';
            return;
        }
    
        echo '
            <div id="' . htmlspecialchars($carouselId) . '" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-indicators">
                    ' . $this->Indicators($a, $carouselId) . '
                </div>
                <div class="carousel-inner">
                    ' . $this->Image($a, $carouselId) . '
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#' . htmlspecialchars($carouselId) . '" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#' . htmlspecialchars($carouselId) . '" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        ';
    }
    
}

?>
