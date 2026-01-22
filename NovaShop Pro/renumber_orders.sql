SET @num := 0;
UPDATE orders SET id = @num := @num + 1 ORDER BY id;
ALTER TABLE orders AUTO_INCREMENT = (SELECT MAX(id) + 1 FROM orders);
