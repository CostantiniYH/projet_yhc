<div class="detail-container">
        <!-- Breadcrumb -->
        <nav class="breadcrumb">
            <a href="./index.php" class="hvr-underline-from-center">Home /</a> 
            <a href="./categories.php" class="hvr-underline-from-center"><?= $one['nom_categorie'] ?> /</a> 
            <a href="./produits.php" class="hvr-underline-from-center">Produits /</a> 
            <span><?= $one['nom']; ?></span>
        </nav>

        <!-- Product Details -->
        <div class="product-detail">
            <!-- Images -->
            <div class="product-images">
                <img src="<?= $one['image'];?>" alt="Main Product Image"
                    class="main-image">
                <div class="thumbnail-images">
                    <img src="<?= $one['image'];?>" alt="Thumbnail 1">
                    <img src="<?= $one['image'];?>" alt="Thumbnail 2">
                </div>
            </div>
            
            <!-- Info -->
            <div class="product-info">
                <h1><?= $one['nom']; ?></h1><p><?= $one['nom_categorie'] ?></p>
                <p class="sku">SKU: 12345 | Men's Headphones</p>
                <p class="price"><?= $one['prix']; ?><?= $one ['devise']; ?></p>
                <p class="payment-info">4 interest-free payments with <a href="#">Klarna</a>.</p>

                <!-- Options -->
                <div class="options">
                    <p class="option-label">Color Options:</p>
                    <div class="option-buttons">
                        <button class="active">Black</button>
                        <button>White</button>
                        <button>Blue</button>
                    </div>
                </div>
                <div class="options">
                    <p class="option-label">Connectivity:</p>
                    <div class="option-buttons">
                        <button class="active">Bluetooth</button>
                        <button>Wired</button>
                    </div>
                </div>
                <div class="actions_wrraper">
                    <!-- Quantity -->
                    <div class="quantity-section">
                        <button>-</button>
                        <input type="text" class="quantity-input" value="1">
                        <button>+</button>
                    </div>
                    
                    <!-- Actions -->
                    <div class="actions">
                        <button class="add-to-cart" href="create.php">Add to Cart</button>
                        <button class="buy-now">Buy Now</button>
                    </div>
                </div>
                <!-- Additional Info (Free Shipping, Support, Warranty, Delivery) -->
                <div class="additional-info">
                    <p><strong>Free Shipping on Orders Over $50</strong></p>
                    <p><strong>24/7 Customer Support:</strong> +1-800-123-4567</p>
                    <p><strong>1-Year Manufacturer Warranty</strong></p>
                    <p><strong>Delivery:</strong> 3 - 5 Business Days</p>
                </div>
                <div class="tab-content">
                    <p>This wireless earphone combines sleek design with cutting-edge technology to deliver an
                        unparalleled audio experience. Featuring a lightweight and ergonomic build, it provides a
                        comfortable fit for extended wear. The advanced sound drivers ensure crisp highs and deep bass,
                        while the latest Bluetooth connectivity offers seamless pairing. Perfect for both work and play,
                        this wireless earphone is your ideal companion for on-the-go convenience and immersive
                        listening.</p>
                </div>
            </div>
        </div>
        
        
        <!-- Tabs for Additional Info -->
        <div class="tabs">
            <button class="active">Description</button>
            <button>Specifications</button>
            <button>Shipping & Returns</button>
            <button>Warranty</button>
        </div>
        
        <div class="tab-content">
            <p><?= $one['description']; ?></p>
        </div>
        
        <!-- Reviews -->
        <div class="reviews">
            <h2>Avis clients</h2>
            <div class="overflow-auto border p-2" style="max-height: 100px;">
            <p>"Beautiful watch! Absolutely love it!" - John</p>
            <p>"Great quality and fast shipping." - Sarah</p>
            </div>
            
        </div>
        
        <!-- Related Products -->
        <div class="related-products">
            <h2>Produits associés</h2>
            <div class="product">
                <img src="<?= $one['image'];?>" alt="Product 1">
                <p><?= $one['nom']; ?></p>
                <p><?= $one['prix']; ?><?= $one ['devise']; ?></p>
            </div>
            <div class="product">
                <img src="<?= $one['image'];?>" alt="Product 2">
                <p><?= $one['nom']; ?></p>
                <p><?= $one['prix']; ?><?= $one ['devise']; ?></p>
            </div>
        </div>
    </div>
    
    <div class="display-flex">
        <p class="col-md-10 m-5 p-5 rounded-4 shadow border-start border-success border-3">
                    <?= $one['description']; ?>
        </p> 
    </div>