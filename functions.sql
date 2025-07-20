-----------------------------------------------------------------------------------------------------------------------------------------------
convert_float_to_snapshot function
-----------------------------------------------------------------------------------------------------------------------------------------------
Parameters:
Parameter	    Direction	Datatype	Comment
p_float_id	    IN	        INT	        (the float you’re converting)
p_manager_id	IN	        INT	        (ID of the approving manager)


Body:

  BEGIN
  DECLARE v_snapshot_id INT DEFAULT NULL;
  -- if the SELECT finds no row, skip to the end
  DECLARE CONTINUE HANDLER FOR NOT FOUND SET v_snapshot_id = NULL;

  -- lock & fetch
  SELECT id
    INTO v_snapshot_id
    FROM inventory_floats
   WHERE id = p_float_id
     AND status = 'open'
   FOR UPDATE;

  -- only if it was open
  IF v_snapshot_id IS NOT NULL THEN

    INSERT INTO inventory_snapshots (float_id, snapshot_date, created_at)
      SELECT id, float_date, NOW()
        FROM inventory_floats
       WHERE id = p_float_id;
    SET v_snapshot_id = LAST_INSERT_ID();

    INSERT INTO inventory_snapshot_entries (snapshot_id, item_id, recorded_qty)
      SELECT
        v_snapshot_id,
        item_id,
        COALESCE(approved_qty, reported_qty)
      FROM inventory_float_entries
     WHERE float_id = p_float_id
       AND approved = TRUE;

    UPDATE inventory_floats
       SET status = 'finalized'
     WHERE id = p_float_id;

  END IF;
END


-----------------------------------------------------------------------------------------------------------------------------------------------