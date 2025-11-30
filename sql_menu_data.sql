INSERT INTO categories (id, restaurant_id, name, name_en, name_de, sort_order, created_at) VALUES
       (1,  1, 'Makarnalar ve Fırın',        NULL, NULL, 10, NOW()),
       (2,  1, 'Izgara & Ana Yemekler',      NULL, NULL, 20, NOW()),
       (3,  1, 'Dürüm & Wrap',               NULL, NULL, 30, NOW()),
       (9,  1, 'Burger Menüler',             NULL, NULL, 90, NOW()),
       (10, 1, 'Kokteyl & İçecekler',        NULL, NULL, 100, NOW()),
       (11, 1, 'Atıştırmalıklar & Aperatif', NULL, NULL, 110, NOW()),
       (12, 1, 'Sıcak / Soğuk İçecekler',    NULL, NULL, 120, NOW()),
       (13, 1, 'Tatlı & Dessert',            NULL, NULL, 130, NOW())


    SET NAMES utf8mb4;
SET CHARACTER SET utf8mb4;

INSERT INTO products (category_id, name, name_en, name_de, image, description, description_en, description_de, price, is_active, sort_order)
VALUES (1, 'PENNE ARRABBİATA', NULL, NULL, NULL, 'ACILI ARRABBİATA SOS, ZEYTİN DİLİMİ, PESTO SOS, PARMESAN PEYNİRİ', NULL, NULL, 445.00, 1, 10);

INSERT INTO products (category_id, name, name_en, name_de, image, description, description_en, description_de, price, is_active, sort_order)
VALUES (1, 'DOMATES S. CHİCKEN', NULL, NULL, NULL, 'IZGARA T. BONFİLE, SARIMSAK, PESTO SOS, PARMESAN PEYNİRİ, NAPOLİTEN SOS, KREMA', NULL, NULL, 490.00, 1, 20);

INSERT INTO products (category_id, name, name_en, name_de, image, description, description_en, description_de, price, is_active, sort_order)
VALUES (1, 'SPAGHETTİ BOLOGNESE', NULL, NULL, NULL, 'KIYMALI BOLOGNESE SOS, PESTO SOS, SARIMSAK, PARMESAN PEYNİRİ', NULL, NULL, 525.00, 1, 30);

INSERT INTO products (category_id, name, name_en, name_de, image, description, description_en, description_de, price, is_active, sort_order)
VALUES (1, 'MAC AND CHEESE', NULL, NULL, NULL, 'KREMA, PEYNİR, SARIMSAK, FESLEĞEN', NULL, NULL, 485.00, 1, 40);

INSERT INTO products (category_id, name, name_en, name_de, image, description, description_en, description_de, price, is_active, sort_order)
VALUES (1, 'ÜÇ PEYNİRLİ TORTELLİNİ', NULL, NULL, NULL, 'PARMESAN PEYNİRİ, PESTO SOS, KREMA, SARIMSAK, DOMATES, SARIMSAK SOS', NULL, NULL, 480.00, 1, 50);

INSERT INTO products (category_id, name, name_en, name_de, image, description, description_en, description_de, price, is_active, sort_order)
VALUES (1, 'KARİDESLİ PASTA', NULL, NULL, NULL, 'SPAGETTİ, KARİDESL, DOMATES SOS, PESTO SOS, PARMESAN PEYNİR, BAHARAT', NULL, NULL, 495.00, 1, 60);

INSERT INTO products (category_id, name, name_en, name_de, image, description, description_en, description_de, price, is_active, sort_order)
VALUES (1, 'FETTUCİNE ALFREDO', NULL, NULL, NULL, 'SOTELENMİŞ TAVUK, MANTAR, SARIMSAK, PESTO SOS, PARMESAN PEYNİRİ, KREMA', NULL, NULL, 480.00, 1, 70);

INSERT INTO products (category_id, name, name_en, name_de, image, description, description_en, description_de, price, is_active, sort_order)
VALUES (1, 'ETLİ SEBZELİ N.', NULL, NULL, NULL, 'ÇİN ERİŞTESİ, KIRMIZI ET, HAVUÇ, KABAK, LAHANA, RENKLİ BİBERLER, SOYA SOS, SUSAM, MAYDONOZ', NULL, NULL, 495.00, 1, 80);

INSERT INTO products (category_id, name, name_en, name_de, image, description, description_en, description_de, price, is_active, sort_order)
VALUES (1, 'KARİDESLİ SEBZELİ N.', NULL, NULL, NULL, 'ÇİN ERİŞTESİ, KARİDES, HAVUÇ, KABAK, LAHANA, RENKLİ BİBER, SOYA SOS, SUSAM, MAYDONOZ', NULL, NULL, 485.00, 1, 90);

INSERT INTO products (category_id, name, name_en, name_de, image, description, description_en, description_de, price, is_active, sort_order)
VALUES (1, 'TAVUKLU SEBZELİ N.', NULL, NULL, NULL, 'ÇİN ERİŞTESİ, TAVUK, HAVUÇ, KABAK, LAHANA, RENKLİ BİBER, SOYA SOS, SUSAM, MAYDONOZ', NULL, NULL, 460.00, 1, 100);

INSERT INTO products (category_id, name, name_en, name_de, image, description, description_en, description_de, price, is_active, sort_order)
VALUES (1, 'GNOCHHİ MUSHROOM', NULL, NULL, NULL, 'GNOCHHİ MAKARNA, MANTAR, PARMESAN PEYNİRİ, KREMA', NULL, NULL, 415.00, 1, 110);

INSERT INTO products (category_id, name, name_en, name_de, image, description, description_en, description_de, price, is_active, sort_order)
VALUES (1, 'GNOCHHİ ALFREDO', NULL, NULL, NULL, 'GNOCHHİ MAKARNA, MANTAR, SARIIMSAK, PESTO SOS, TAVUK, PARMESAN PEYNİRİ, KREMA', NULL, NULL, 425.00, 1, 120);

INSERT INTO products (category_id, name, name_en, name_de, image, description, description_en, description_de, price, is_active, sort_order)
VALUES (1, 'GNOCHHİ BOLOGNESE', NULL, NULL, NULL, 'GNOCHHİ MAKARNA, BOLONEZ SOS, KIYMALI, SARIMSAK, PARMESAN PEYNİRİ', NULL, NULL, 445.00, 1, 130);

INSERT INTO products (category_id, name, name_en, name_de, image, description, description_en, description_de, price, is_active, sort_order)
VALUES (2, 'IZGARA KÖFTE', NULL, NULL, NULL, 'I. DOMATES, I. BİBER, KARIŞIK YEŞİLLİK, PİLAV', NULL, NULL, 585.00, 1, 10);

INSERT INTO products (category_id, name, name_en, name_de, image, description, description_en, description_de, price, is_active, sort_order)
VALUES (2, 'PİDELİ KÖFTE', NULL, NULL, NULL, 'IZGARA KÖFTE, PATATES, TIRNAK PİDE, SÜZME YOĞURT, I. DOMATES, I.BİBER', NULL, NULL, 610.00, 1, 20);

INSERT INTO products (category_id, name, name_en, name_de, image, description, description_en, description_de, price, is_active, sort_order)
VALUES (2, 'BEĞENDİLİ KÖFTE', NULL, NULL, NULL, 'I. KÖFTE, BEĞENDİ, NAPOLİTON SOS, I. BİBER, I.DOMATES, PATATES', NULL, NULL, 600.00, 1, 30);

INSERT INTO products (category_id, name, name_en, name_de, image, description, description_en, description_de, price, is_active, sort_order)
VALUES (2, 'DREAM KÖFTE', NULL, NULL, NULL, 'YUFKA, I. KÖFTE, PATATES, KARIŞIK YEŞİLLİK, DREAM SOS', NULL, NULL, 630.00, 1, 40);

INSERT INTO products (category_id, name, name_en, name_de, image, description, description_en, description_de, price, is_active, sort_order)
VALUES (2, 'ET SOTE', NULL, NULL, NULL, 'SOTELENMİŞ ET, RENKLİ BİBER, SOĞAN, DOMATES SOS', NULL, NULL, 840.00, 1, 50);

INSERT INTO products (category_id, name, name_en, name_de, image, description, description_en, description_de, price, is_active, sort_order)
VALUES (2, 'CAFEDE PARİS S. BONFİLE', NULL, NULL, NULL, 'I.DANA BONFİLE DİLİM, PATATES, KARIŞIK YEŞİLLİK, PİLAV', NULL, NULL, 890.00, 1, 60);

INSERT INTO products (category_id, name, name_en, name_de, image, description, description_en, description_de, price, is_active, sort_order)
VALUES (2, 'SOMON IZGARA', NULL, NULL, NULL, 'SOMON IZGARA, TARTAR SOS, MOR SOĞAN, PATATES KAŞARLI, K. SALSA SOS, YEŞİLLİK', NULL, NULL, 760.00, 1, 70);

INSERT INTO products (category_id, name, name_en, name_de, image, description, description_en, description_de, price, is_active, sort_order)
VALUES (3, 'MEVSİM SALATA', NULL, NULL, NULL, 'ROKA, DOMATES, BİBER, PEYNİR RENDE, ACI BİBER TURŞU, ZEYTİN YAĞI, LİMON', NULL, NULL, 390.00, 1, 10);

INSERT INTO products (category_id, name, name_en, name_de, image, description, description_en, description_de, price, is_active, sort_order)
VALUES (3, 'ÇOBAN SALATA', NULL, NULL, NULL, 'DOMATES, BİBER, SOĞAN, SALATALIK, MAYDONOZ, BEYAZ PEYNİR, ZEYTİNYAĞI, LİMON, NAR EKŞİSİ', NULL, NULL, 390.00, 1, 20);

INSERT INTO products (category_id, name, name_en, name_de, image, description, description_en, description_de, price, is_active, sort_order)
VALUES (3, 'TON B. SALATA', NULL, NULL, NULL, 'TON BALIĞI, MARUL, ROKA, MISIR, KORNİŞON TURŞU, KIRMIZI SOĞAN, KIRZARMIŞ BİBER, ÇERİ DOMATES, ZEYTİN YAĞI, LİMON SOS', NULL, NULL, 510.00, 1, 30);

INSERT INTO products (category_id, name, name_en, name_de, image, description, description_en, description_de, price, is_active, sort_order)
VALUES (3, 'TAVUKLU SEZAAR SALATA', NULL, NULL, NULL, 'I.PİLİÇ, DOMATES, PARMESAN, KITIR EKMEK, SEZAR SOS', NULL, NULL, 470.00, 1, 40);

INSERT INTO products (category_id, name, name_en, name_de, image, description, description_en, description_de, price, is_active, sort_order)
VALUES (3, 'TOSKANA', NULL, NULL, NULL, 'KAVRRULMUŞ DOMATES, PARMESAN PEYNİRİ, ÇERİ DOMATES, KIRMIZI SOĞAN, DREAM SOS, YOĞURT, ROKA, MARUL, KITIR EKMEK', NULL, NULL, 450.00, 1, 50);

INSERT INTO products (category_id, name, name_en, name_de, image, description, description_en, description_de, price, is_active, sort_order)
VALUES (3, 'STUTTGART BOWL', NULL, NULL, NULL, 'SOTELENMİŞ MANTAR, TALI K. SOĞAN, MARUL, ROKA, ÇERİ DOMATES, KITIR EKMEK, DREM SOS, YOĞURT, CEVİZ', NULL, NULL, 460.00, 1, 60);

INSERT INTO products (category_id, name, name_en, name_de, image, description, description_en, description_de, price, is_active, sort_order)
VALUES (3, 'DREAM AVOKADO', NULL, NULL, NULL, 'SOTELENMİŞ DOMATES, MARUL, ROKA, AVOKADO KĞP, KITIR EKMEK, ZEYTİN YAĞI, LİMON', NULL, NULL, 460.00, 1, 70);

INSERT INTO products (category_id, name, name_en, name_de, image, description, description_en, description_de, price, is_active, sort_order)
VALUES (3, 'CAJUN CHİCKEN S.', NULL, NULL, NULL, 'CAJUN B.IZGARA TAVUK, MARUL, SOĞAN, ÇERİ DOMATES, SALATALIK', NULL, NULL, 485.00, 1, 80);

INSERT INTO products (category_id, name, name_en, name_de, image, description, description_en, description_de, price, is_active, sort_order)
VALUES (3, 'KARİDESLİ SALATA', NULL, NULL, NULL, 'DOMATES, MARUL, HAVUÇ, SALATALIK, BAHARAT, SARIMSAK, JUMBO KARİDES, MAYONEZ, ZEYTİN YAĞI, LİMON', NULL, NULL, 580.00, 1, 90);

INSERT INTO products (category_id, name, name_en, name_de, image, description, description_en, description_de, price, is_active, sort_order)
VALUES (4, 'KEYİF TABAĞI (2 KİŞİ)', NULL, NULL, NULL, 'CAJUN, SOSİS, SOĞAN HALKASI, SİGARA BÖREĞİ, MOZERELLA STİCK, PATATES, DREAM SOS, BARBEKÜ SOS, CHİLİ SOS', NULL, NULL, 720.00, 1, 10);

INSERT INTO products (category_id, name, name_en, name_de, image, description, description_en, description_de, price, is_active, sort_order)
VALUES (4, 'CAJUN CHİCKEN BASKET', NULL, NULL, NULL, 'KIZARTILMIŞ TAVUK, PATATES, DREAM SOS, BARBEKÜ SOS', NULL, NULL, 450.00, 1, 20);

INSERT INTO products (category_id, name, name_en, name_de, image, description, description_en, description_de, price, is_active, sort_order)
VALUES (4, 'KÖFTE CRUSH', NULL, NULL, NULL, 'PARMESAN, PATATES, KÖFTE, BAHARAT, DREAM SOS, BABRBEKÜ SOS', NULL, NULL, 550.00, 1, 30);

INSERT INTO products (category_id, name, name_en, name_de, image, description, description_en, description_de, price, is_active, sort_order)
VALUES (4, 'TAVUK TACO', NULL, NULL, NULL, 'TACO EKMEĞİ, CHEDDAR PEYNİRİ, KIZARTILMIŞ TAVUK, BONFİLE, DREAM SOS', NULL, NULL, 325.00, 1, 40);

INSERT INTO products (category_id, name, name_en, name_de, image, description, description_en, description_de, price, is_active, sort_order)
VALUES (4, 'CHEDDARLI TAVUK', NULL, NULL, NULL, 'TAVUK, CHEDDAR SOS', NULL, NULL, 450.00, 1, 50);

INSERT INTO products (category_id, name, name_en, name_de, image, description, description_en, description_de, price, is_active, sort_order)
VALUES (4, 'MOZERELLA SEPETİ', NULL, NULL, NULL, 'MOZERELLA STİCK, PATATES, KETÇAP, MAYONEZ', NULL, NULL, 380.00, 1, 60);

INSERT INTO products (category_id, name, name_en, name_de, image, description, description_en, description_de, price, is_active, sort_order)
VALUES (4, 'SOSİS SEPETİ', NULL, NULL, NULL, 'KOKTEYL SOSİS, PATATES, KETCAP, MAYONEZ', NULL, NULL, 420.00, 1, 70);

INSERT INTO products (category_id, name, name_en, name_de, image, description, description_en, description_de, price, is_active, sort_order)
VALUES (5, 'IZGARA TAVUK', NULL, NULL, NULL, 'TAVUK GÖĞSÜ, SALATA, PİLAV', NULL, NULL, 490.00, 1, 10);

INSERT INTO products (category_id, name, name_en, name_de, image, description, description_en, description_de, price, is_active, sort_order)
VALUES (5, 'KREMALI MANTAR TAVUK', NULL, NULL, NULL, 'TAVUK BONFİLE, KREMA, MANTAR, SOTE SEBZE, PATATES', NULL, NULL, 520.00, 1, 20);

INSERT INTO products (category_id, name, name_en, name_de, image, description, description_en, description_de, price, is_active, sort_order)
VALUES (5, 'CAJUN SOSLU TAVUK', NULL, NULL, NULL, 'CAJUN BAHARATI, TAVUK, YEŞİLLİK, PATATES', NULL, NULL, 530.00, 1, 30);

INSERT INTO products (category_id, name, name_en, name_de, image, description, description_en, description_de, price, is_active, sort_order)
VALUES (5, 'MEKSİKA SOSLU TAVUK', NULL, NULL, NULL, 'J. TAVUK, BİBER, MEKSİKA FASULYE, MISIR, DOMATES SOS, SALATA, PATATES', NULL, NULL, 490.00, 1, 40);

INSERT INTO products (category_id, name, name_en, name_de, image, description, description_en, description_de, price, is_active, sort_order)
VALUES (5, 'KÖRİ SOSLU TAVUK', NULL, NULL, NULL, 'KÜP TAVUK, KÖRİ SOS, BİBER, KREMA, YEŞİLLİK, PATATES', NULL, NULL, 520.00, 1, 50);

INSERT INTO products (category_id, name, name_en, name_de, image, description, description_en, description_de, price, is_active, sort_order)
VALUES (5, 'BBQ SOSLU TAVUK', NULL, NULL, NULL, 'J. TAVUK, BBQ SOS, BİBER, YEŞİLLİK, PATATES', NULL, NULL, 490.00, 1, 60);

INSERT INTO products (category_id, name, name_en, name_de, image, description, description_en, description_de, price, is_active, sort_order)
VALUES (5, 'CAFE DE PARİS SOSLU TAVUK', NULL, NULL, NULL, 'TAVUK G., YEŞİLLİK, PİLAV', NULL, NULL, 510.00, 1, 70);

INSERT INTO products (category_id, name, name_en, name_de, image, description, description_en, description_de, price, is_active, sort_order)
VALUES (5, 'MUSHROOM CHİCKEN', NULL, NULL, NULL, 'I. TAVUK BONFİLE, SOTE MANTAR, KAŞAR PEYNİR, YEŞİLLİK, PATATES', NULL, NULL, 540.00, 1, 80);

INSERT INTO products (category_id, name, name_en, name_de, image, description, description_en, description_de, price, is_active, sort_order)
VALUES (5, 'TAVUK KÜLBASTI', NULL, NULL, NULL, 'I. TAVUK, BEĞENDİ, NAPOLİTAN SOS, YEŞİLLİK, PATATES, DREAM SOS', NULL, NULL, 500.00, 1, 90);

INSERT INTO products (category_id, name, name_en, name_de, image, description, description_en, description_de, price, is_active, sort_order)
VALUES (5, 'CHİCKEN SCHNİTZEL', NULL, NULL, NULL, 'PANE TAVUK FİLETOSU, ROKA, PATATES, DREAM SOS', NULL, NULL, 550.00, 1, 100);

INSERT INTO products (category_id, name, name_en, name_de, image, description, description_en, description_de, price, is_active, sort_order)
VALUES (5, 'CAJUN FİNGER', NULL, NULL, NULL, 'CAJUN BAHARAT, TAVUK GÖŞSÜ, YEŞİLLİK, PATATES, DREAM SOS', NULL, NULL, 560.00, 1, 110);

INSERT INTO products (category_id, name, name_en, name_de, image, description, description_en, description_de, price, is_active, sort_order)
VALUES (5, 'TAVUK SOTE', NULL, NULL, NULL, 'SOTELENMİŞ TAVUK, BİBER, SOĞAN, SOMATES SOS', NULL, NULL, 510.00, 1, 120);

INSERT INTO products (category_id, name, name_en, name_de, image, description, description_en, description_de, price, is_active, sort_order)
VALUES (5, 'DREAM CHİCKEN', NULL, NULL, NULL, 'J. TAVUK, DAĞ KEKİKLİ KREMA SOS, YEŞİLLİK, PATATES, DREAM SOS', NULL, NULL, 570.00, 1, 130);

INSERT INTO products (category_id, name, name_en, name_de, image, description, description_en, description_de, price, is_active, sort_order)
VALUES (6, 'TAVUKLU MANTARLI KREP', NULL, NULL, NULL, 'TAVUK, MANTAR, BEŞAMEL SOS, KREMA, KAŞAR PEYNİR, YEŞİLLİK', NULL, NULL, 440.00, 1, 10);

INSERT INTO products (category_id, name, name_en, name_de, image, description, description_en, description_de, price, is_active, sort_order)
VALUES (6, 'TAVUKLU WRAP', NULL, NULL, NULL, 'S. TAVUK, MANTAR, SOĞAN, BİBER, PATATES, YEŞİLLİK', NULL, NULL, 470.00, 1, 20);

INSERT INTO products (category_id, name, name_en, name_de, image, description, description_en, description_de, price, is_active, sort_order)
VALUES (6, 'CHEDDARLI TAVUK WRAP', NULL, NULL, NULL, 'S. TAVUK, MANTAR, CHEDDAR PEYNİRİ, SOĞAN, PATATES, YEŞİLLİK', NULL, NULL, 480.00, 1, 30);

INSERT INTO products (category_id, name, name_en, name_de, image, description, description_en, description_de, price, is_active, sort_order)
VALUES (6, 'ETLİ WRAP', NULL, NULL, NULL, 'S. BİFTEK, MANTAR, SOĞAN, BİBER, PATATES, YEŞİLLİK', NULL, NULL, 670.00, 1, 40);

INSERT INTO products (category_id, name, name_en, name_de, image, description, description_en, description_de, price, is_active, sort_order)
VALUES (6, 'CHEDDARLI ETLİ WRAP', NULL, NULL, NULL, 'S. BİFTEK, MANTAR, SOĞAN, CHEDDAR PEYNİRİ, PATATES, YEŞİLLİK', NULL, NULL, 690.00, 1, 50);

INSERT INTO products (category_id, name, name_en, name_de, image, description, description_en, description_de, price, is_active, sort_order)
VALUES (6, 'KÖFTELİ WRAP', NULL, NULL, NULL, 'IZGARA KÖFTE, BİBER, SOĞAN, PATATES, YEŞİLLİK', NULL, NULL, 520.00, 1, 60);

INSERT INTO products (category_id, name, name_en, name_de, image, description, description_en, description_de, price, is_active, sort_order)
VALUES (6, 'TONBALIKLI SANDWİCH', NULL, NULL, NULL, 'TON BALK, GÖBEK, MARUL, DOMATES, SOĞAN HALKASI, PATATES', NULL, NULL, 410.00, 1, 70);

INSERT INTO products (category_id, name, name_en, name_de, image, description, description_en, description_de, price, is_active, sort_order)
VALUES (7, 'QUESADİLLA PEYNİRLİ', NULL, NULL, NULL, 'TORTİLLA EKMEK, KAŞAR PEYNİRİ, CHEDDAR PEYNİR, SALSA SOS, SOUR CREAM SOS, DREAM SOS', NULL, NULL, 470.00, 1, 10);

INSERT INTO products (category_id, name, name_en, name_de, image, description, description_en, description_de, price, is_active, sort_order)
VALUES (7, 'QUESADİLLA TAVUKLU', NULL, NULL, NULL, 'TORTİLLA EKMEK, I. TAVUK, BİBER, K. SOĞAN, KAŞAR PEYNİR, CHEDDAR PEYNİR, SALSA SOS, SOUR CREAM SOS, DREAM SOS', NULL, NULL, 535.00, 1, 20);

INSERT INTO products (category_id, name, name_en, name_de, image, description, description_en, description_de, price, is_active, sort_order)
VALUES (7, 'QUESADİLLA ETLİ', NULL, NULL, NULL, 'TORTİLLA EKMEĞİ, I. BİFTEK, BİBER, K. SOĞAN, KAŞAR PEYNİR, CHEDDAR PEYNİR, SALSA SOS, SOUR CREAM SOS, DREAM SOS', NULL, NULL, 695.00, 1, 30);

INSERT INTO products (category_id, name, name_en, name_de, image, description, description_en, description_de, price, is_active, sort_order)
VALUES (7, 'QUESADİLLACOMBO', NULL, NULL, NULL, 'TORTİLLA EKMEĞİ, I. TAVUK, I. BİFTEK, BİBER, K. SOĞAN, KAŞAR PEYNİR, CHEDDAR PEYNİR, SALSA SOS, SOUR CREAM SOS, DREAM SOS', NULL, NULL, 615.00, 1, 40);

INSERT INTO products (category_id, name, name_en, name_de, image, description, description_en, description_de, price, is_active, sort_order)
VALUES (7, 'BURRİTOS SEBZELİ', NULL, NULL, NULL, 'TORTİLLA EKMEĞİ, SOĞAN, BİBER, BROKOLİ, ISPANAK, KAŞAR PEYNİR, CHEDDAR PEYNİR, PATATES, MEKSİKA PİLAV, SOUR CREAM', NULL, NULL, 490.00, 1, 50);

INSERT INTO products (category_id, name, name_en, name_de, image, description, description_en, description_de, price, is_active, sort_order)
VALUES (7, 'BURRİTOS TAVUKLU', NULL, NULL, NULL, 'TORTİLLA EKMEĞİ, SOĞAN, BİBER, TAVUK, KAŞAR PEYNİR, CHEDDAR PEYNİR, SOUR CREAM, PATATES, MEKSİKA PİLAV, DREAM SOS', NULL, NULL, 560.00, 1, 60);

INSERT INTO products (category_id, name, name_en, name_de, image, description, description_en, description_de, price, is_active, sort_order)
VALUES (7, 'BURRİTOS BİFTEK', NULL, NULL, NULL, 'TORTİLLA EKMEĞİ, SOĞAN, BİBER, BİFTEK, KAŞAR PEYNİR, CHEDDAR PEYNİR, SOUR CREAM, PATATES, MEKSİKA PİLAV, DREAM SOS', NULL, NULL, 740.00, 1, 70);

INSERT INTO products (category_id, name, name_en, name_de, image, description, description_en, description_de, price, is_active, sort_order)
VALUES (8, 'FAJİTAS TAVUKLU', NULL, NULL, NULL, 'I. TAVUK, BİBER, SOUR CREAM SOS, SALSA SOS, AVOKADO PÜRESİ, TORTİLLA', NULL, NULL, 660.00, 1, 10);

INSERT INTO products (category_id, name, name_en, name_de, image, description, description_en, description_de, price, is_active, sort_order)
VALUES (8, 'FAJİTAS BİFTEKLİ', NULL, NULL, NULL, 'I. BİFTEK, SOĞAN, BİBER, SOUR CRREAM SOS, SALSA SOS, AVOKADO PÜRESİ, TORTİLLA', NULL, NULL, 840.00, 1, 20);

INSERT INTO products (category_id, name, name_en, name_de, image, description, description_en, description_de, price, is_active, sort_order)
VALUES (8, 'FAJİTAS COMBO', NULL, NULL, NULL, 'I. BİFTEK, I. TAVUK, SOĞAN, BİBER, SOUR CRREAM SOS, SALSA SOS, AVOKADO PÜRESİ, TORTİLLA', NULL, NULL, 790.00, 1, 30);

INSERT INTO products (category_id, name, name_en, name_de, image, description, description_en, description_de, price, is_active, sort_order)
VALUES (9, 'DREAM MEX BURGER MENÜ', NULL, NULL, NULL, 'BURGER KÖFTESİ, JAMBON DANA, CHEDDAR PEYNİRİ, K. SOĞAN, MARUL, DOMATES, TURŞU, DREAM SOS, PATATES, SOFT İÇECEK', NULL, NULL, 670.00, 1, 10);

INSERT INTO products (category_id, name, name_en, name_de, image, description, description_en, description_de, price, is_active, sort_order)
VALUES (9, 'DREAM AVOKADO BURGER MENĞ', NULL, NULL, NULL, 'BURGER KÖFTESİ, AVOKADO, CHEDDAR PEYNİRİ, SOĞAN, MARUL, DREAM SOS, PATATES, SOFT İÇECEK', NULL, NULL, 580.00, 1, 20);

INSERT INTO products (category_id, name, name_en, name_de, image, description, description_en, description_de, price, is_active, sort_order)
VALUES (9, 'DREAM MUSHROOM BURGER MENÜ', NULL, NULL, NULL, 'BURGER KÖFTESİ, SOTE MANTAR, K. SOĞAN, MARUL, JALAPENO, CHEDDAR PEYNİRİ, DOMATES, PATATES, SOFT İÇECEK', NULL, NULL, 580.00, 1, 30);

INSERT INTO products (category_id, name, name_en, name_de, image, description, description_en, description_de, price, is_active, sort_order)
VALUES (9, 'DREAM MUSHROOM CHİCKEN MENÜ', NULL, NULL, NULL, 'TAVUK GÖĞSÜ, SOTE MANTAR, MARUL, JALAPENO, K. SOĞAN, CHEDDAR PEYNİRİ, DOMATES, DREAM SOS, PATATES, SOFT İÇECEK', NULL, NULL, 540.00, 1, 40);

INSERT INTO products (category_id, name, name_en, name_de, image, description, description_en, description_de, price, is_active, sort_order)
VALUES (9, 'DREAM CHİCKEN MENÜ', NULL, NULL, NULL, 'TAVUK GÖĞSÜ, MARUL, DOMATES, TURŞU, SOĞAN, DREAM SOS, PATATES, SOFT İÇECEK', NULL, NULL, 520.00, 1, 50);

INSERT INTO products (category_id, name, name_en, name_de, image, description, description_en, description_de, price, is_active, sort_order)
VALUES (9, 'DREAM CRİSPY MENÜ', NULL, NULL, NULL, 'TAVUK GÖĞSÜ, MARUL, DOMATES, JALAPENO, SOĞAN, DREAM SOS, PATATES, SOFT İÇECEK', NULL, NULL, 520.00, 1, 60);

INSERT INTO products (category_id, name, name_en, name_de, image, description, description_en, description_de, price, is_active, sort_order)
VALUES (9, 'DREAM SPECİAL BURGER MENÜ', NULL, NULL, NULL, 'BURGER KÖFTESİ, JAMBON, BURGER KÖFTESİ, DREAM SOS, K. SOĞAN, BURGER KÖFTESİ, DOMATES, JALAPENO, PATATES, SOFT İÇECEK', NULL, NULL, 595.00, 1, 70);

INSERT INTO products (category_id, name, name_en, name_de, image, description, description_en, description_de, price, is_active, sort_order)
VALUES (9, 'DREAM HOT BURGER MENÜ', NULL, NULL, NULL, 'BURGER KÖFTESİ, BURGER KÖFTESİ, MARUL, SALATALIK, DOMATES, JALAPENO, ACI SOS, PATATES, SOFT İÇECEK', NULL, NULL, 550.00, 1, 80);

INSERT INTO products (category_id, name, name_en, name_de, image, description, description_en, description_de, price, is_active, sort_order)
VALUES (9, 'DREAM CLASSİC BURGER MENÜ', NULL, NULL, NULL, 'BURGER KÖFTESİ, SOĞAN, MARUL, DOMATES, TURŞU, PATATES, SOFT İÇECEK', NULL, NULL, 540.00, 1, 90);

INSERT INTO products (category_id, name, name_en, name_de, image, description, description_en, description_de, price, is_active, sort_order)
VALUES (10, 'SİNİ KAHVALTI', NULL, NULL, NULL, 'EZİNE BEYAZ PEYNİR, KOLOT PEYNİRİ, SELE ZEYTİNİ, KIRMA YEŞİL ZEYTİN, EV YAPIIMI REÇEL, FINDIK KREMASI, SÖĞÜŞ SALATA, DOMATES SOS ACI BİBERLİ, UİSNE REÇELLİ LOR PEYNİRİ, MENEMEN, ZEYTİNLİ EKMEK, SİGARA BÖREĞİ, PİŞİ, IZGARA HELLİM, KAVURMA YUMURTA, SINIRSIZ ÇAY, 2 TÜRK KAHVESİ İKRAM', NULL, NULL, 1690.00, 1, 10);

INSERT INTO products (category_id, name, name_en, name_de, image, description, description_en, description_de, price, is_active, sort_order)
VALUES (10, 'SAHANDA YUMURTA', NULL, NULL, NULL, '3 YUMURTA', NULL, NULL, 230.00, 1, 20);

INSERT INTO products (category_id, name, name_en, name_de, image, description, description_en, description_de, price, is_active, sort_order)
VALUES (10, 'SAHANDA SOSİS', NULL, NULL, NULL, NULL, NULL, NULL, 210.00, 1, 30);

INSERT INTO products (category_id, name, name_en, name_de, image, description, description_en, description_de, price, is_active, sort_order)
VALUES (10, 'KAVURMALI YUMURTA', NULL, NULL, NULL, NULL, NULL, NULL, 410.00, 1, 40);

INSERT INTO products (category_id, name, name_en, name_de, image, description, description_en, description_de, price, is_active, sort_order)
VALUES (10, 'SAHANDA SUCUKLU YUMURTA', NULL, NULL, NULL, NULL, NULL, NULL, 310.00, 1, 50);

INSERT INTO products (category_id, name, name_en, name_de, image, description, description_en, description_de, price, is_active, sort_order)
VALUES (10, 'OMLET', NULL, NULL, NULL, '3 YUMURTA', NULL, NULL, 240.00, 1, 60);

INSERT INTO products (category_id, name, name_en, name_de, image, description, description_en, description_de, price, is_active, sort_order)
VALUES (10, 'KAŞARLI OMLET', NULL, NULL, NULL, NULL, NULL, NULL, 270.00, 1, 70);

INSERT INTO products (category_id, name, name_en, name_de, image, description, description_en, description_de, price, is_active, sort_order)
VALUES (10, 'SPORCU OMLET', NULL, NULL, NULL, 'YUMURTA BEYAZI, MAYDONOZ, ROKA, LOR PEYNİRİ', NULL, NULL, 290.00, 1, 80);

INSERT INTO products (category_id, name, name_en, name_de, image, description, description_en, description_de, price, is_active, sort_order)
VALUES (10, 'MANTARLI OMLET', NULL, NULL, NULL, 'MANTAR, 3 YUMURTA, KAŞAR', NULL, NULL, 295.00, 1, 90);

INSERT INTO products (category_id, name, name_en, name_de, image, description, description_en, description_de, price, is_active, sort_order)
VALUES (10, 'SOSİSLİ OMLET', NULL, NULL, NULL, '3 YUMURTA, SOSİS', NULL, NULL, 290.00, 1, 100);

INSERT INTO products (category_id, name, name_en, name_de, image, description, description_en, description_de, price, is_active, sort_order)
VALUES (10, 'KARIŞIK OMLET', NULL, NULL, NULL, '3 YUMURTA, SUCUK, MANTAR, SOSİS, KAŞAR PEYNİRİ', NULL, NULL, 390.00, 1, 110);

INSERT INTO products (category_id, name, name_en, name_de, image, description, description_en, description_de, price, is_active, sort_order)
VALUES (10, 'YUMURTALI EKMEK', NULL, NULL, NULL, '4 YUMURTA, EKMEK, VİŞNE REÇELİ, LOR PEYNİRİ', NULL, NULL, 165.00, 1, 120);

INSERT INTO products (category_id, name, name_en, name_de, image, description, description_en, description_de, price, is_active, sort_order)
VALUES (10, 'HELLİM TAVA', NULL, NULL, NULL, 'KIBRIS HELLİMİ', NULL, NULL, 340.00, 1, 130);

INSERT INTO products (category_id, name, name_en, name_de, image, description, description_en, description_de, price, is_active, sort_order)
VALUES (10, 'MENEMEN', NULL, NULL, NULL, 'DOMATES, BİBER, YUMURTA', NULL, NULL, 285.00, 1, 140);

INSERT INTO products (category_id, name, name_en, name_de, image, description, description_en, description_de, price, is_active, sort_order)
VALUES (10, 'AVAKADOLU POŞE YUMURTA', NULL, NULL, NULL, 'BRİOCHE EKMEĞİ, AVAKADO EZMESİ, PESTO SOS, POŞE YUMURTA, YEŞİLLİK', NULL, NULL, 430.00, 1, 150);

INSERT INTO products (category_id, name, name_en, name_de, image, description, description_en, description_de, price, is_active, sort_order)
VALUES (10, 'ANADOLU TOSTU', NULL, NULL, NULL, 'BEYAZA PEYNİR, DOMATES, KEKİK, SÖĞÜŞ SALATA, ZEYTİN', NULL, NULL, 270.00, 1, 160);

INSERT INTO products (category_id, name, name_en, name_de, image, description, description_en, description_de, price, is_active, sort_order)
VALUES (10, 'KARIŞIK PEYNİRLİ TOST', NULL, NULL, NULL, 'KARIŞIK PEYNİR, DOMATES, ZEYTİN EZMESİ, MİNİ YEŞİL SALATA', NULL, NULL, 280.00, 1, 170);

INSERT INTO products (category_id, name, name_en, name_de, image, description, description_en, description_de, price, is_active, sort_order)
VALUES (10, 'KARIŞIK TOST', NULL, NULL, NULL, 'DANA SOSİS, TAZE KAŞAR, SALAM, SUCUK, MİNİ YEŞİL SALATA', NULL, NULL, 320.00, 1, 180);

INSERT INTO products (category_id, name, name_en, name_de, image, description, description_en, description_de, price, is_active, sort_order)
VALUES (10, 'KAVURMALI KAŞARLI TOST', NULL, NULL, NULL, 'KAVURMA, KAŞAR, MİNİ YEŞİL SALATA', NULL, NULL, 395.00, 1, 190);

INSERT INTO products (category_id, name, name_en, name_de, image, description, description_en, description_de, price, is_active, sort_order)
VALUES (10, 'BAZLAMA TOST', NULL, NULL, NULL, 'KAŞAR PEYNİRİ, PATATES, MİNİ YEŞİL SALATA', NULL, NULL, 310.00, 1, 200);

INSERT INTO products (category_id, name, name_en, name_de, image, description, description_en, description_de, price, is_active, sort_order)
VALUES (10, 'KAVURMALI KAŞARLI BAZLAMA', NULL, NULL, NULL, 'KAVURMA, KAŞAR, PATATES, MİNİ YEŞİL SALATA', NULL, NULL, 430.00, 1, 210);

INSERT INTO products (category_id, name, name_en, name_de, image, description, description_en, description_de, price, is_active, sort_order)
VALUES (10, 'KARIŞIK BAZLAMA', NULL, NULL, NULL, 'SUCUK, KAŞAR, PATATES, MİNİ YEŞİL SALATA', NULL, NULL, 370.00, 1, 220);

INSERT INTO products (category_id, name, name_en, name_de, image, description, description_en, description_de, price, is_active, sort_order)
VALUES (10, 'DİET TOST', NULL, NULL, NULL, 'KEPEKLİ TOST EKMEĞİ, DŞL PEYNİRİ, DOMATES, ZEYTİN EZMESİ, MİNİ YEŞİL SALATA', NULL, NULL, 330.00, 1, 230);

INSERT INTO products (category_id, name, name_en, name_de, image, description, description_en, description_de, price, is_active, sort_order)
VALUES (10, 'ZEYTİN TABAĞI', NULL, NULL, NULL, NULL, NULL, NULL, 160.00, 1, 240);

INSERT INTO products (category_id, name, name_en, name_de, image, description, description_en, description_de, price, is_active, sort_order)
VALUES (10, 'PEYNİR TABAĞI', NULL, NULL, NULL, NULL, NULL, NULL, 270.00, 1, 250);

INSERT INTO products (category_id, name, name_en, name_de, image, description, description_en, description_de, price, is_active, sort_order)
VALUES (10, 'SÖĞÜŞ TABAĞI', NULL, NULL, NULL, NULL, NULL, NULL, 120.00, 1, 260);

INSERT INTO products (category_id, name, name_en, name_de, image, description, description_en, description_de, price, is_active, sort_order)
VALUES (10, 'VİŞNE REÇELİ', NULL, NULL, NULL, 'BAL KAYMAK (190TL', NULL, NULL, 140.00, 1, 270);

INSERT INTO products (category_id, name, name_en, name_de, image, description, description_en, description_de, price, is_active, sort_order)
VALUES (10, 'BAL-TEREYAĞI', NULL, NULL, NULL, NULL, NULL, NULL, 190.00, 1, 280);

INSERT INTO products (category_id, name, name_en, name_de, image, description, description_en, description_de, price, is_active, sort_order)
VALUES (10, 'TAHİN PEKMEZ', NULL, NULL, NULL, NULL, NULL, NULL, 190.00, 1, 290);

INSERT INTO products (category_id, name, name_en, name_de, image, description, description_en, description_de, price, is_active, sort_order)
VALUES (10, 'EV YAPIMI REÇEL', NULL, NULL, NULL, NULL, NULL, NULL, 100.00, 1, 300);

INSERT INTO products (category_id, name, name_en, name_de, image, description, description_en, description_de, price, is_active, sort_order)
VALUES (10, 'ŞZEL EKMEK SEPETİ', NULL, NULL, NULL, NULL, NULL, NULL, 140.00, 1, 310);

INSERT INTO products (category_id, name, name_en, name_de, image, description, description_en, description_de, price, is_active, sort_order)
VALUES (10, 'KIYMALI GÖZLEME', NULL, NULL, NULL, NULL, NULL, NULL, 380.00, 1, 320);

INSERT INTO products (category_id, name, name_en, name_de, image, description, description_en, description_de, price, is_active, sort_order)
VALUES (10, 'KIYMALI KAŞARLI GÖZLEME', NULL, NULL, NULL, NULL, NULL, NULL, 390.00, 1, 330);

INSERT INTO products (category_id, name, name_en, name_de, image, description, description_en, description_de, price, is_active, sort_order)
VALUES (10, 'PEYNİRLİ GÖZLEME', NULL, NULL, NULL, NULL, NULL, NULL, 310.00, 1, 340);

INSERT INTO products (category_id, name, name_en, name_de, image, description, description_en, description_de, price, is_active, sort_order)
VALUES (10, 'PATATESLİ GÖZLEME', NULL, NULL, NULL, NULL, NULL, NULL, 300.00, 1, 350);

INSERT INTO products (category_id, name, name_en, name_de, image, description, description_en, description_de, price, is_active, sort_order)
VALUES (11, 'MERCİMEK ÇORBASI', NULL, NULL, NULL, 'PEYNİRLİ EKMEK, BİBERLİ YAĞ, LİMON', NULL, NULL, 270.00, 1, 10);

INSERT INTO products (category_id, name, name_en, name_de, image, description, description_en, description_de, price, is_active, sort_order)
VALUES (11, 'DOMATES ÇORBASI', NULL, NULL, NULL, 'PEYNİRLİ EKMEK, KAŞAR PEYNİRİ', NULL, NULL, 310.00, 1, 20);

INSERT INTO products (category_id, name, name_en, name_de, image, description, description_en, description_de, price, is_active, sort_order)
VALUES (11, 'TAVUK SUYU ÇORBASI', NULL, NULL, NULL, 'TAVUK, TEL ŞEHRİYE, HAVUÇ, MAYDONOZ, LİMON, KIRMIZI YAĞ, PEYNİRLİ EKMEK', NULL, NULL, 390.00, 1, 30);

INSERT INTO products (category_id, name, name_en, name_de, image, description, description_en, description_de, price, is_active, sort_order)
VALUES (11, 'KREMALI MANTAR ÇORBASI', NULL, NULL, NULL, 'DİLİMLİ MANTAR, KREMA, PEYNİRLİ EKMEK', NULL, NULL, 305.00, 1, 40);

INSERT INTO products (category_id, name, name_en, name_de, image, description, description_en, description_de, price, is_active, sort_order)
VALUES (12, 'DREAM MENÜ 1', NULL, NULL, NULL, 'CHİCKEN FİNGER, SOSİS PARÇALARI, CHEDDAR SOSLU ÇITIR TAVUK, MOZARELLA STİCKS, TUZLU CHURROS, PATATES, DREAM SOS, BBQ SOS, K.M.', NULL, NULL, 940.00, 1, 10);

INSERT INTO products (category_id, name, name_en, name_de, image, description, description_en, description_de, price, is_active, sort_order)
VALUES (12, 'DREAM MENÜ 2', NULL, NULL, NULL, 'SOĞAN HALKASI, ÇITIR TAVUK, CHİCKEN BURGER, MOZARELLA STİCKS, CHEESE BURGER, PATATES, DREAM SOS, BBQ SOS, K.M.', NULL, NULL, 1190.00, 1, 20);

INSERT INTO products (category_id, name, name_en, name_de, image, description, description_en, description_de, price, is_active, sort_order)
VALUES (12, 'DREAM MENÜ 3', NULL, NULL, NULL, 'TAVUKLU WRAP, KÖFTELİ WRAP, SOĞAN HALKASI, MOZARELLA STİCKS, CHEDDARLI TAVUK PARÇALARI, PATATES, DREAM SOS, BBQ SOS, K.M.', NULL, NULL, 1100.00, 1, 30);

INSERT INTO products (category_id, name, name_en, name_de, image, description, description_en, description_de, price, is_active, sort_order)
VALUES (12, 'PEPEE TABAĞI', NULL, NULL, NULL, 'PİLİÇ NUGGET, PİLAV, PATATES', NULL, NULL, 240.00, 1, 40);

INSERT INTO products (category_id, name, name_en, name_de, image, description, description_en, description_de, price, is_active, sort_order)
VALUES (12, 'SPİDERMAN', NULL, NULL, NULL, 'KÖFTE, PİLAV, PATATES', NULL, NULL, 290.00, 1, 50);

INSERT INTO products (category_id, name, name_en, name_de, image, description, description_en, description_de, price, is_active, sort_order)
VALUES (12, 'MİCKEY MAUSE TABAĞI', NULL, NULL, NULL, 'HAMBURGER, PİLAV, PATATES', NULL, NULL, 310.00, 1, 60);

INSERT INTO products (category_id, name, name_en, name_de, image, description, description_en, description_de, price, is_active, sort_order)
VALUES (13, 'DONDURMALI BROWNİE', NULL, NULL, NULL, NULL, NULL, NULL, 340.00, 1, 10);

INSERT INTO products (category_id, name, name_en, name_de, image, description, description_en, description_de, price, is_active, sort_order)
VALUES (13, 'ÇİLEKLİ MAGNOLİA', NULL, NULL, NULL, NULL, NULL, NULL, 395.00, 1, 20);

INSERT INTO products (category_id, name, name_en, name_de, image, description, description_en, description_de, price, is_active, sort_order)
VALUES (13, 'WAFFLE CUP', NULL, NULL, NULL, 'WAFFLE, ÇİKOLATA SOS, ÖZEL KREMA, MUZ, ÇİLEK, DONDURMA', NULL, NULL, 320.00, 1, 30);

INSERT INTO products (category_id, name, name_en, name_de, image, description, description_en, description_de, price, is_active, sort_order)
VALUES (13, 'LİMONLU CHEESECAKE', NULL, NULL, NULL, NULL, NULL, NULL, 285.00, 1, 40);

INSERT INTO products (category_id, name, name_en, name_de, image, description, description_en, description_de, price, is_active, sort_order)
VALUES (13, 'BALLI FISTIKLI MARLENKA', NULL, NULL, NULL, NULL, NULL, NULL, 310.00, 1, 50);

INSERT INTO products (category_id, name, name_en, name_de, image, description, description_en, description_de, price, is_active, sort_order)
VALUES (13, 'KALPTEN KALBE', NULL, NULL, NULL, NULL, NULL, NULL, 360.00, 1, 60);

INSERT INTO products (category_id, name, name_en, name_de, image, description, description_en, description_de, price, is_active, sort_order)
VALUES (13, 'MEYVE TABAĞI 2 KİŞİLİK', NULL, NULL, NULL, NULL, NULL, NULL, 380.00, 1, 70);

INSERT INTO products (category_id, name, name_en, name_de, image, description, description_en, description_de, price, is_active, sort_order)
VALUES (13, 'DONDURMA 1 TOP', NULL, NULL, NULL, 'VANİLYA, ÇİKOLATALI, ÇİLEKLİ, CEVİZLİ, KAVUNLU, FRAMBUAZLI, LİMONLU, MUZLU', NULL, NULL, 90.00, 1, 80);

INSERT INTO products (category_id, name, name_en, name_de, image, description, description_en, description_de, price, is_active, sort_order)
VALUES (13, 'ÇEREZ TABAĞI', NULL, NULL, NULL, NULL, NULL, NULL, 410.00, 1, 90);

INSERT INTO products (category_id, name, name_en, name_de, image, description, description_en, description_de, price, is_active, sort_order)
VALUES (13, 'KEYİF TABAĞI 2KİŞİLİK', NULL, NULL, NULL, 'MEVSİM MEYVE, ÇEREZ TABAĞI, PATLAMIŞ MISIR', NULL, NULL, 810.00, 1, 100);

INSERT INTO products (category_id, name, name_en, name_de, image, description, description_en, description_de, price, is_active, sort_order)
VALUES (13, 'KIZARMIŞ DONDURMA', NULL, NULL, NULL, NULL, NULL, NULL, 380.00, 1, 110);

INSERT INTO products (category_id, name, name_en, name_de, image, description, description_en, description_de, price, is_active, sort_order)
VALUES (13, 'MUZLU MAGNOLİA', NULL, NULL, NULL, NULL, NULL, NULL, 295.00, 1, 120);

INSERT INTO products (category_id, name, name_en, name_de, image, description, description_en, description_de, price, is_active, sort_order)
VALUES (13, 'FRAMBUAZLI CHEESECAKE', NULL, NULL, NULL, NULL, NULL, NULL, 295.00, 1, 130);

INSERT INTO products (category_id, name, name_en, name_de, image, description, description_en, description_de, price, is_active, sort_order)
VALUES (13, 'BALLI CEVİZLİ MARLENKA', NULL, NULL, NULL, NULL, NULL, NULL, 310.00, 1, 140);

INSERT INTO products (category_id, name, name_en, name_de, image, description, description_en, description_de, price, is_active, sort_order)
VALUES (13, 'ALBENİ ÇİLEK FRAMBUAZ', NULL, NULL, NULL, NULL, NULL, NULL, 340.00, 1, 150);

INSERT INTO products (category_id, name, name_en, name_de, image, description, description_en, description_de, price, is_active, sort_order)
VALUES (13, 'MEYVE TABAĞI 4 KİŞİLİK', NULL, NULL, NULL, NULL, NULL, NULL, 630.00, 1, 160);

INSERT INTO products (category_id, name, name_en, name_de, image, description, description_en, description_de, price, is_active, sort_order)
VALUES (13, 'PATLAMIŞ MISIR', NULL, NULL, NULL, NULL, NULL, NULL, 80.00, 1, 170);

INSERT INTO products (category_id, name, name_en, name_de, image, description, description_en, description_de, price, is_active, sort_order)
VALUES (13, 'CHURROS', NULL, NULL, NULL, NULL, NULL, NULL, 330.00, 1, 180);

INSERT INTO products (category_id, name, name_en, name_de, image, description, description_en, description_de, price, is_active, sort_order)
VALUES (13, 'OREOLU MAGNOLİA', NULL, NULL, NULL, NULL, NULL, NULL, 300.00, 1, 190);

INSERT INTO products (category_id, name, name_en, name_de, image, description, description_en, description_de, price, is_active, sort_order)
VALUES (13, 'LOTUSLU CHEESECAKE', NULL, NULL, NULL, NULL, NULL, NULL, 300.00, 1, 200);

INSERT INTO products (category_id, name, name_en, name_de, image, description, description_en, description_de, price, is_active, sort_order)
VALUES (13, 'ALBENİ FISTIKLI', NULL, NULL, NULL, NULL, NULL, NULL, 350.00, 1, 210);

INSERT INTO products (category_id, name, name_en, name_de, image, description, description_en, description_de, price, is_active, sort_order)
VALUES (13, 'SAN SEBASTİAN', NULL, NULL, NULL, NULL, NULL, NULL, 395.00, 1, 220);

INSERT INTO products (category_id, name, name_en, name_de, image, description, description_en, description_de, price, is_active, sort_order)
VALUES (13, 'TİRAMİSU', NULL, NULL, NULL, NULL, NULL, NULL, 320.00, 1, 230);

INSERT INTO products (category_id, name, name_en, name_de, image, description, description_en, description_de, price, is_active, sort_order)
VALUES (13, 'SUFLE', NULL, NULL, NULL, NULL, NULL, NULL, 370.00, 1, 240);