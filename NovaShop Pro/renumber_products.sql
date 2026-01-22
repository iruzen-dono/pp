SET @num := 0;
UPDATE products SET id = @num := @num + 1 ORDER BY id;
ALTER TABLE products AUTO_INCREMENT = 8;
