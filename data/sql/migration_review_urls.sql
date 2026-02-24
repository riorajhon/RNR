-- Per-platform review URLs (run once if business_settings already exists)
ALTER TABLE business_settings
  ADD COLUMN review_url_google VARCHAR(512) DEFAULT NULL,
  ADD COLUMN review_url_facebook VARCHAR(512) DEFAULT NULL,
  ADD COLUMN review_url_yelp VARCHAR(512) DEFAULT NULL,
  ADD COLUMN review_url_tripadvisor VARCHAR(512) DEFAULT NULL;
