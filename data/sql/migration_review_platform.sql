-- Add review_platform to existing business_settings (run once in phpMyAdmin if table already exists).
-- Choose where customers are sent after a high rating: only this platform is shown on the thank-you page.
ALTER TABLE business_settings
  ADD COLUMN review_platform VARCHAR(32) DEFAULT 'google'
  COMMENT 'google|yelp|facebook|tripadvisor';
