-- Örnek demo veriler
-- Restaurant sabit: id = 1

INSERT INTO categories (restaurant_id, name, sort_order)
VALUES
    (1, 'Tatlı Kruvasan', 10),
    (1, 'Tuzlu Kruvasan & Kahvaltı', 20),
    (1, 'Pastalar', 30),
    (1, 'Çikolata Lezzetleri', 40),
    (1, 'Kahveler', 50);

-- Her INSERT sonrası id'leri al
SET @cat_tatli    = (SELECT id FROM categories WHERE restaurant_id = 1 AND name = 'Tatlı Kruvasan' LIMIT 1);
SET @cat_tuzlu    = (SELECT id FROM categories WHERE restaurant_id = 1 AND name = 'Tuzlu Kruvasan & Kahvaltı' LIMIT 1);
SET @cat_pastalar = (SELECT id FROM categories WHERE restaurant_id = 1 AND name = 'Pastalar' LIMIT 1);
SET @cat_cikolata = (SELECT id FROM categories WHERE restaurant_id = 1 AND name = 'Çikolata Lezzetleri' LIMIT 1);
SET @cat_kahve    = (SELECT id FROM categories WHERE restaurant_id = 1 AND name = 'Kahveler' LIMIT 1);

-- Tatlı Kruvasan ürünleri
INSERT INTO products (category_id, name, description, price, is_active, sort_order)
VALUES
    (@cat_tatli, 'Çilekli Kruvasan', 'Tereyağlı kruvasan içinde pastacı kreması ve taze çilek dilimleri.', 225, 1, 10),
    (@cat_tatli, 'Çikolatalı Kruvasan', 'Belçika çikolatası ile doldurulmuş sıcak kruvasan.', 210, 1, 20),
    (@cat_tatli, 'Bademli Kruvasan', 'Badem kreması ve kavrulmuş badem parçacıkları ile.', 235, 1, 30);

-- Tuzlu Kruvasan & Kahvaltı ürünleri
INSERT INTO products (category_id, name, description, price, is_active, sort_order)
VALUES
    (@cat_tuzlu, 'A La\'Lune Breakfast', 'Taze kruvasan, yanında çeşit peynirler, kahvaltılıklar ve çay/kahve eşliğinde.', 495, 1, 10),
(@cat_tuzlu, 'French Breakfast', 'Omlet, kruvasan, taze sebzeler ve kahvaltılık soslarla zenginleştirilmiş tabak.', 550, 1, 20),
(@cat_tuzlu, 'Üç Peynirli Kruvasan', 'Suda mozzarella, cheddar ve beyaz peynir ile doldurulmuş kruvasan.', 380, 1, 30);

-- Pastalar
INSERT INTO products (category_id, name, description, price, is_active, sort_order)
VALUES
(@cat_pastalar, 'Kırmızı Kadife Pasta', 'Yumuşak kırmızı kadife kek katları ve krem peynirli krema.', 320, 1, 10),
(@cat_pastalar, 'Frambuazlı Cheesecake', 'Tabanı bisküvili, üstü frambuaz soslu klasik cheesecake.', 345, 1, 20),
(@cat_pastalar, 'Çikolatalı Orman Pastası', 'Bol çikolatalı, fındık parçacıklı orman pastası.', 360, 1, 30);

-- Çikolata Lezzetleri
INSERT INTO products (category_id, name, description, price, is_active, sort_order)
VALUES
(@cat_cikolata, 'Sıcak Çikolata', 'Yoğun Belçika çikolatası ile hazırlanan sıcak içecek.', 195, 1, 10),
(@cat_cikolata, 'Çikolata Fondü', 'Taze meyveler ve minik kekler ile servis edilen çikolata fondü.', 420, 1, 20),
(@cat_cikolata, 'Brownie Tabağı', 'Dondurma eşliğinde servis edilen sıcak brownie dilimleri.', 310, 1, 30);

-- Kahveler
INSERT INTO products (category_id, name, description, price, is_active, sort_order)
VALUES
(@cat_kahve, 'Espresso', 'Yoğun ve kısa çekilmiş espresso.', 120, 1, 10),
(@cat_kahve, 'Latte', 'Süt köpüğü ile yumuşatılmış espresso.', 165, 1, 20),
(@cat_kahve, 'Cappuccino', 'Bol süt köpüklü klasik cappuccino.', 165, 1, 30),
(@cat_kahve, 'Mocha', 'Espresso, süt ve çikolata karışımı sıcak içecek.', 185, 1, 40);
