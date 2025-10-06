-- Fix the event table to ensure event_id is AUTO_INCREMENT
-- Run this SQL to fix the "Field doesn't have a default value" error

ALTER TABLE event 
MODIFY COLUMN event_id INT(11) NOT NULL AUTO_INCREMENT;

-- Verify the fix
SHOW CREATE TABLE event;
