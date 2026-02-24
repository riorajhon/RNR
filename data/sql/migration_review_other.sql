-- "Any other" review destination (run once if business_settings already exists)
ALTER TABLE business_settings
  ADD COLUMN review_url_other VARCHAR(512) DEFAULT NULL,
  ADD COLUMN review_label_other VARCHAR(255) DEFAULT NULL;
