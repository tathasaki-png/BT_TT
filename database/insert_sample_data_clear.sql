-- Clear existing data and insert sample data
USE ttck_bai8;

-- Clear tables (remove foreign key constraints temporarily)
SET FOREIGN_KEY_CHECKS = 0;
DELETE FROM job_logs;
DELETE FROM jobs;
DELETE FROM users;
SET FOREIGN_KEY_CHECKS = 1;

-- Insert sample users
INSERT INTO users (name, email, password, created_at, updated_at) VALUES
('Nguyễn Văn A', 'nguyenvana@example.com', '$2y$12$abcdefghijklmnopqrstuvwxyz', NOW(), NOW()),
('Trần Thị B', 'tranthib@example.com', '$2y$12$abcdefghijklmnopqrstuvwxyz', NOW(), NOW()),
('Lê Minh C', 'leminhc@example.com', '$2y$12$abcdefghijklmnopqrstuvwxyz', NOW(), NOW()),
('Phạm Hương D', 'phamhuongd@example.com', '$2y$12$abcdefghijklmnopqrstuvwxyz', NOW(), NOW());

-- Insert sample job logs
INSERT INTO job_logs (job_name, email, status, payload, retry_count, max_retries, started_at, completed_at, error_message, created_at, updated_at) VALUES
('App\\Jobs\\SendWelcomeEmailJob', 'nguyenvana@example.com', 'success', '{"userName":"Nguyễn Văn A","email":"nguyenvana@example.com"}', 0, 3, NOW(), NOW(), NULL, NOW(), NOW()),
('App\\Jobs\\SendWelcomeEmailJob', 'tranthib@example.com', 'success', '{"userName":"Trần Thị B","email":"tranthib@example.com"}', 0, 3, NOW(), NOW(), NULL, NOW(), NOW()),
('App\\Jobs\\SendWelcomeEmailJob', 'leminhc@example.com', 'success', '{"userName":"Lê Minh C","email":"leminhc@example.com"}', 0, 3, NOW(), NOW(), NULL, NOW(), NOW()),
('App\\Jobs\\SendWelcomeEmailJob', 'phamhuongd@example.com', 'failed', '{"userName":"Phạm Hương D","email":"phamhuongd@example.com"}', 3, 3, NOW(), NOW(), 'ERROR: Connection refused', NOW(), NOW());

-- Display results
SELECT 'Total Users:' as label, COUNT(*) as count FROM users;
SELECT 'Total Job Logs:' as label, COUNT(*) as count FROM job_logs;
SELECT status, COUNT(*) as count FROM job_logs GROUP BY status;
