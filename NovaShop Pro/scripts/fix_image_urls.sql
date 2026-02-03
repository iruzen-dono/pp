-- ========================================
-- Apply correct image URL mappings to existing real files
-- Each product mapped to an actual image file that exists
-- ========================================

-- ÉLECTRONIQUE (7 produits) - using tech/electronics related images
UPDATE products SET image_url = '/Assets/Images/products/kobu-agency-ipARHaxETRk-unsplash.jpg' WHERE id = 1;  -- MacBook Pro
UPDATE products SET image_url = '/Assets/Images/products/markus-winkler-f57lx37DCM4-unsplash.jpg' WHERE id = 2;  -- LG UltraWide
UPDATE products SET image_url = '/Assets/Images/products/markus-spiske-1LLh8k2_YFk-unsplash.jpg' WHERE id = 3;  -- Logitech Brio
UPDATE products SET image_url = '/Assets/Images/products/nubelson-fernandes-rfoH17_F7F8-unsplash.jpg' WHERE id = 4;  -- Shure SM7B
UPDATE products SET image_url = '/Assets/Images/products/loganathan-logesh-uA1bZsgrTTs-unsplash.jpg' WHERE id = 5;  -- Portable Charger
UPDATE products SET image_url = '/Assets/Images/products/lautaro-andreani-xkBaqlcqeb4-unsplash.jpg' WHERE id = 6;  -- Tablet Samsung
UPDATE products SET image_url = '/Assets/Images/products/madeinegypt-ca-kpyz_oL7mP0-unsplash.jpg' WHERE id = 7;  -- BenQ Monitor

-- MODE & VÊTEMENTS (10 produits) - using fashion/clothing related images
UPDATE products SET image_url = '/Assets/Images/products/dries-de-schepper-j8fFee11sHU-unsplash.jpg' WHERE id = 8;  -- Veste Cuir
UPDATE products SET image_url = '/Assets/Images/products/fashion-needles-QRtWtyiU6cM-unsplash.jpg' WHERE id = 9;  -- Jeans Slim
UPDATE products SET image_url = '/Assets/Images/products/nick-fewings-SEtiU4dGMkY-unsplash.jpg' WHERE id = 10;  -- Chemise Oxford
UPDATE products SET image_url = '/Assets/Images/products/faith-yarn-Wr0TpKqf26s-unsplash.jpg' WHERE id = 11;  -- T-Shirt
UPDATE products SET image_url = '/Assets/Images/products/sevda-afshar-vkCmm43EfTc-unsplash.jpg' WHERE id = 12;  -- Pull Laine Mérinos
UPDATE products SET image_url = '/Assets/Images/products/marlon-corona-1tMc27CFUbA-unsplash.jpg' WHERE id = 13;  -- Sneakers
UPDATE products SET image_url = '/Assets/Images/products/mathilde-langevin--sZ_WM4cOlM-unsplash.jpg' WHERE id = 14;  -- Ceinture
UPDATE products SET image_url = '/Assets/Images/products/swabdesign-JwZ3GhXo8g4-unsplash.jpg' WHERE id = 15;  -- Montre
UPDATE products SET image_url = '/Assets/Images/products/shino-nakamura-7_TixXDAUZ8-unsplash.jpg' WHERE id = 16;  -- Lunettes Soleil
UPDATE products SET image_url = '/Assets/Images/products/feey-tDnlNLK_3dk-unsplash.jpg' WHERE id = 17;  -- Écharpe

-- LIVRES & PUBLICATIONS (8 produits) - reusing relevant images
UPDATE products SET image_url = '/Assets/Images/products/kobu-agency-ipARHaxETRk-unsplash.jpg' WHERE id = 18;  -- Clean Code
UPDATE products SET image_url = '/Assets/Images/products/markus-spiske-1LLh8k2_YFk-unsplash.jpg' WHERE id = 19;  -- Pragmatic Programmer
UPDATE products SET image_url = '/Assets/Images/products/nubelson-fernandes-rfoH17_F7F8-unsplash.jpg' WHERE id = 20;  -- Design Patterns
UPDATE products SET image_url = '/Assets/Images/products/loganathan-logesh-uA1bZsgrTTs-unsplash.jpg' WHERE id = 21;  -- Atomic Habits
UPDATE products SET image_url = '/Assets/Images/products/lautaro-andreani-xkBaqlcqeb4-unsplash.jpg' WHERE id = 22;  -- Zero to One
UPDATE products SET image_url = '/Assets/Images/products/madeinegypt-ca-kpyz_oL7mP0-unsplash.jpg' WHERE id = 23;  -- Python for Data Science
UPDATE products SET image_url = '/Assets/Images/products/markus-winkler-f57lx37DCM4-unsplash.jpg' WHERE id = 24;  -- Web Development React
UPDATE products SET image_url = '/Assets/Images/products/dries-de-schepper-j8fFee11sHU-unsplash.jpg' WHERE id = 25;  -- Machine Learning

-- MAISON & DÉCOR & SPORTS (10 produits)
UPDATE products SET image_url = '/Assets/Images/products/puscas-adryan-kpwmh_9OtG4-unsplash.jpg' WHERE id = 26;  -- Lampe LED
UPDATE products SET image_url = '/Assets/Images/products/feey-tDnlNLK_3dk-unsplash.jpg' WHERE id = 27;  -- Plante Monstera
UPDATE products SET image_url = '/Assets/Images/products/roger-bradshaw-Y6L_zTbSmbs-unsplash.jpg' WHERE id = 28;  -- Miroir Doré
UPDATE products SET image_url = '/Assets/Images/products/sj-2hwhvm0WyW0-unsplash.jpg' WHERE id = 29;  -- Étagères
UPDATE products SET image_url = '/Assets/Images/products/ayanda-kunene-DgMjb21sEUI-unsplash.jpg' WHERE id = 30;  -- Fauteuil
UPDATE products SET image_url = '/Assets/Images/products/victoria-berman-nLNimOqmbpg-unsplash.jpg' WHERE id = 31;  -- Tapis Persan
UPDATE products SET image_url = '/Assets/Images/products/himiway-bikes-oq_hv-oG58w-unsplash.jpg' WHERE id = 32;  -- Vélo Gravel
UPDATE products SET image_url = '/Assets/Images/products/karl-kohler-dGIEMeN2MV8-unsplash.jpg' WHERE id = 33;  -- Tapis Yoga
UPDATE products SET image_url = '/Assets/Images/products/deon-collison-Rk62VPlcZqw-unsplash.jpg' WHERE id = 34;  -- Chaussures Trail
UPDATE products SET image_url = '/Assets/Images/products/mathilde-langevin--sZ_WM4cOlM-unsplash.jpg' WHERE id = 35;  -- Gourde

SELECT 'Mappings appliqués avec succès!' AS Status;
