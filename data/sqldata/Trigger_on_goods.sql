/*Trigger on INSERT*/
DROP TRIGGER IF EXISTS t_on_add_goods;
delimiter //
CREATE TRIGGER t_on_add_goods AFTER INSERT ON ecs_goods
FOR EACH ROW
BEGIN
	SELECT ecs_category.parent_id INTO @tmp_cat_id from ecs_category where ecs_category.cat_id = NEW.cat_id;
	SELECT ecs_category.parent_id INTO @new_cat_id from ecs_category where ecs_category.cat_id = @tmp_cat_id;

	SELECT COUNT(*) INTO @tmpcount FROM ecs_brand2category
	WHERE ecs_brand2category.brand_id = NEW.brand_id
	AND ecs_brand2category.cat_id = @new_cat_id;

	IF (@tmpcount > 0) THEN
		UPDATE ecs_brand2category set ecs_brand2category.count = ecs_brand2category.count + 1
		WHERE ecs_brand2category.brand_id = NEW.brand_id
		AND ecs_brand2category.cat_id = @new_cat_id;
	ELSE
		INSERT INTO ecs_brand2category (brand_id, cat_id, count)values(NEW.brand_id, @new_cat_id, 1);
	END IF;
END; //
delimiter ;

/*Trigger on UPDATE*/
DROP TRIGGER IF EXISTS t_on_update_goods;
delimiter //
CREATE TRIGGER t_on_update_goods AFTER UPDATE ON ecs_goods
FOR EACH ROW
BEGIN
	SELECT ecs_category.parent_id INTO @tmp_cat_id from ecs_category where ecs_category.cat_id = OLD.cat_id;
	SELECT ecs_category.parent_id INTO @old_cat_id from ecs_category where ecs_category.cat_id = @tmp_cat_id;

	SELECT ecs_category.parent_id INTO @tmp_cat_id from ecs_category where ecs_category.cat_id = NEW.cat_id;
	SELECT ecs_category.parent_id INTO @new_cat_id from ecs_category where ecs_category.cat_id = @tmp_cat_id;

	IF (NEW.is_delete <> OLD.is_delete) THEN
		SELECT ecs_brand2category.count INTO @oldcount FROM ecs_brand2category
		WHERE ecs_brand2category.brand_id = OLD.brand_id
		AND ecs_brand2category.cat_id = @old_cat_id LIMIT 1;

		IF (@oldcount>1) THEN
			UPDATE ecs_brand2category set ecs_brand2category.count = ecs_brand2category.count - 1
			WHERE ecs_brand2category.brand_id = OLD.brand_id
			AND ecs_brand2category.cat_id = @old_cat_id;
		ELSE
			DELETE FROM ecs_brand2category
			WHERE ecs_brand2category.brand_id = OLD.brand_id
			AND ecs_brand2category.cat_id = @old_cat_id;
		END IF;
	ELSE
		IF (@new_cat_id <> @old_cat_id OR NEW.brand_id <> OLD.brand_id) THEN
			SELECT ecs_brand2category.count INTO @oldcount FROM ecs_brand2category
			WHERE ecs_brand2category.brand_id = OLD.brand_id
			AND ecs_brand2category.cat_id = @old_cat_id LIMIT 1;

			IF (@oldcount>1) THEN
				UPDATE ecs_brand2category set ecs_brand2category.count = ecs_brand2category.count - 1
				WHERE ecs_brand2category.brand_id = OLD.brand_id
				AND ecs_brand2category.cat_id = @old_cat_id;
			ELSE
				DELETE FROM ecs_brand2category
				WHERE ecs_brand2category.brand_id = OLD.brand_id
				AND ecs_brand2category.cat_id = @old_cat_id;
			END IF;


			SELECT COUNT(*) INTO @tmpcount FROM ecs_brand2category
			WHERE ecs_brand2category.brand_id = NEW.brand_id
			AND ecs_brand2category.cat_id = @new_cat_id;

			IF (@tmpcount > 0) THEN
				UPDATE ecs_brand2category set ecs_brand2category.count = ecs_brand2category.count + 1
				WHERE ecs_brand2category.brand_id = NEW.brand_id
				AND ecs_brand2category.cat_id = @new_cat_id;
			ELSE
				INSERT INTO ecs_brand2category (brand_id, cat_id, count)values(NEW.brand_id, @new_cat_id, 1);
			END IF;
		END IF;
	END IF;
END; //
delimiter ;

