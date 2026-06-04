CREATE TABLE IF NOT EXISTS reservations (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  email VARCHAR(255) NOT NULL,
  telephone VARCHAR(20),
  reservation_date DATE NOT NULL,
  reservation_time TIME NOT NULL,
  consultation_method VARCHAR(50) NOT NULL,
  learning_languages TEXT,
  os_env VARCHAR(50),
  consultation_categories TEXT,
  details TEXT NOT NULL,
  urgency_level INT NOT NULL,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);