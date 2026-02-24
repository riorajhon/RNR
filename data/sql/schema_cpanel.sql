-- 1TXT Database Schema (cPanel) – run this in phpMyAdmin after selecting YOUR database (e.g. myraazsn_onetxt)
-- Do NOT run CREATE DATABASE or USE; your database already exists.

-- Users (business owners)
CREATE TABLE IF NOT EXISTS users (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  email VARCHAR(255) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  name VARCHAR(255) NOT NULL,
  profile_photo VARCHAR(512) DEFAULT NULL,
  plan ENUM('monthly', 'yearly') DEFAULT 'monthly',
  stripe_customer_id VARCHAR(255) DEFAULT NULL,
  stripe_subscription_id VARCHAR(255) DEFAULT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  INDEX idx_email (email)
) ENGINE=InnoDB;

-- Business settings per user (QR text, redirect URL, questions, gift option)
CREATE TABLE IF NOT EXISTS business_settings (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  user_id INT UNSIGNED NOT NULL,
  qr_footer_text VARCHAR(255) DEFAULT NULL,
  redirect_url_positive VARCHAR(512) DEFAULT NULL COMMENT 'URL when rating 7-10',
  review_platform VARCHAR(128) DEFAULT 'google' COMMENT 'comma-separated: google,yelp,facebook,tripadvisor',
  review_url_google VARCHAR(512) DEFAULT NULL,
  review_url_facebook VARCHAR(512) DEFAULT NULL,
  review_url_yelp VARCHAR(512) DEFAULT NULL,
  review_url_tripadvisor VARCHAR(512) DEFAULT NULL,
  review_url_other VARCHAR(512) DEFAULT NULL,
  review_label_other VARCHAR(255) DEFAULT NULL,
  question_1 VARCHAR(512) DEFAULT NULL,
  question_2 VARCHAR(512) DEFAULT NULL,
  question_3 VARCHAR(512) DEFAULT NULL,
  num_questions TINYINT UNSIGNED DEFAULT 3,
  offer_gift TINYINT(1) DEFAULT 1,
  gift_description TEXT DEFAULT NULL,
  gift_image VARCHAR(512) DEFAULT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  UNIQUE KEY uk_user (user_id),
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Ratings (each scan/submission)
CREATE TABLE IF NOT EXISTS ratings (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  user_id INT UNSIGNED NOT NULL,
  score TINYINT UNSIGNED NOT NULL COMMENT '1-10',
  is_positive TINYINT(1) NOT NULL COMMENT '1 if 7-10, 0 if 1-6',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  INDEX idx_user_created (user_id, created_at),
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Follow-up responses (for low ratings 1-6)
CREATE TABLE IF NOT EXISTS responses (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  rating_id INT UNSIGNED NOT NULL,
  answer_1 TEXT DEFAULT NULL,
  answer_2 TEXT DEFAULT NULL,
  answer_3 TEXT DEFAULT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (rating_id) REFERENCES ratings(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Lead capture (name, email, mobile when claiming gift)
CREATE TABLE IF NOT EXISTS leads (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  rating_id INT UNSIGNED NOT NULL,
  name VARCHAR(255) NOT NULL,
  email VARCHAR(255) NOT NULL,
  mobile VARCHAR(50) DEFAULT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (rating_id) REFERENCES ratings(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Sessions for auth
CREATE TABLE IF NOT EXISTS sessions (
  id VARCHAR(128) PRIMARY KEY,
  user_id INT UNSIGNED NOT NULL,
  expires_at TIMESTAMP NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  INDEX idx_user (user_id),
  INDEX idx_expires (expires_at),
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Contact form submissions (optional)
CREATE TABLE IF NOT EXISTS contact_submissions (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255) NOT NULL,
  email VARCHAR(255) NOT NULL,
  subject VARCHAR(255) NOT NULL,
  message TEXT NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;
