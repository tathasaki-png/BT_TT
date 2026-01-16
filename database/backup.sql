-- SQLite Database Backup
-- Exported: 2026-01-16 12:15:15

CREATE TABLE "migrations" ("id" integer primary key autoincrement not null, "migration" varchar not null, "batch" integer not null);

INSERT INTO migrations (id, migration, batch) VALUES ('1', '0001_01_01_000000_create_users_table', '1');
INSERT INTO migrations (id, migration, batch) VALUES ('2', '0001_01_01_000001_create_cache_table', '1');
INSERT INTO migrations (id, migration, batch) VALUES ('3', '0001_01_01_000002_create_jobs_table', '1');
INSERT INTO migrations (id, migration, batch) VALUES ('4', '2026_01_16_030943_create_messages_table', '1');
INSERT INTO migrations (id, migration, batch) VALUES ('5', '2026_01_16_031013_add_role_to_users_table', '1');
INSERT INTO migrations (id, migration, batch) VALUES ('6', '2026_01_16_031749_add_username_to_users_table', '1');

CREATE TABLE sqlite_sequence(name,seq);

INSERT INTO sqlite_sequence (name, seq) VALUES ('migrations', '6');
INSERT INTO sqlite_sequence (name, seq) VALUES ('users', '2');
INSERT INTO sqlite_sequence (name, seq) VALUES ('messages', '8');

CREATE TABLE "users" ("id" integer primary key autoincrement not null, "name" varchar not null, "email" varchar not null, "email_verified_at" datetime, "password" varchar not null, "remember_token" varchar, "created_at" datetime, "updated_at" datetime, "role" varchar not null default 'user', "username" varchar not null);

INSERT INTO users (id, name, email, email_verified_at, password, remember_token, created_at, updated_at, role, username) VALUES ('1', 'Administrator', 'admin@example.com', '2026-01-16 10:57:34', '$2y$12$IFZVhkKkiQC20pFd5G9G7u8xWuOA4DPO5uwYkhpdqpSFIg961llDa', 'DS9kDIpRnh5ADHNT4inE0BctEgblV8jEIyd781Xabu3aqyCsvGJTstTlqeI9', '2026-01-16 10:57:35', '2026-01-16 10:57:35', 'admin', 'admin');
INSERT INTO users (id, name, email, email_verified_at, password, remember_token, created_at, updated_at, role, username) VALUES ('2', 'User', 'user123@example.com', '2026-01-16 10:57:35', '$2y$12$4mLhQg.x97o8d88ADVlQ5O.TfBSnecsuOYV7abzqhG27Elfm1332y', 'OLGgLrpMeEgjbxwcYFHpePh3YNZAX0ZtDxcHi5fom2OELoobVtofVzRjyNxt', '2026-01-16 10:57:35', '2026-01-16 10:57:35', 'user', 'user123');

CREATE TABLE "password_reset_tokens" ("email" varchar not null, "token" varchar not null, "created_at" datetime, primary key ("email"));


CREATE TABLE "sessions" ("id" varchar not null, "user_id" integer, "ip_address" varchar, "user_agent" text, "payload" text not null, "last_activity" integer not null, primary key ("id"));

INSERT INTO sessions (id, user_id, ip_address, user_agent, payload, last_activity) VALUES ('RAzhYZ4ewT7yGul6dfx1PUnJrCb5goeFMWqpd9yi', '2', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36 Edg/143.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoidENTYllIWjlzQUhJMW10c29vQjJBWUg5VnVBQ09YeGdWb1Vob0gwViI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjY6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9jaGF0IjtzOjU6InJvdXRlIjtzOjEwOiJjaGF0LmluZGV4Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6Mjt9', '1768565713');

CREATE TABLE "cache" ("key" varchar not null, "value" text not null, "expiration" integer not null, primary key ("key"));


CREATE TABLE "cache_locks" ("key" varchar not null, "owner" varchar not null, "expiration" integer not null, primary key ("key"));


CREATE TABLE "jobs" ("id" integer primary key autoincrement not null, "queue" varchar not null, "payload" text not null, "attempts" integer not null, "reserved_at" integer, "available_at" integer not null, "created_at" integer not null);


CREATE TABLE "job_batches" ("id" varchar not null, "name" varchar not null, "total_jobs" integer not null, "pending_jobs" integer not null, "failed_jobs" integer not null, "failed_job_ids" text not null, "options" text, "cancelled_at" integer, "created_at" integer not null, "finished_at" integer, primary key ("id"));


CREATE TABLE "failed_jobs" ("id" integer primary key autoincrement not null, "uuid" varchar not null, "connection" text not null, "queue" text not null, "payload" text not null, "exception" text not null, "failed_at" datetime not null default CURRENT_TIMESTAMP);


CREATE TABLE "messages" ("id" integer primary key autoincrement not null, "sender_id" integer not null, "receiver_id" integer not null, "message" text not null, "created_at" datetime, "updated_at" datetime, foreign key("sender_id") references "users"("id") on delete cascade, foreign key("receiver_id") references "users"("id") on delete cascade);

INSERT INTO messages (id, sender_id, receiver_id, message, created_at, updated_at) VALUES ('1', '1', '2', 'abcd', '2026-01-16 10:58:20', '2026-01-16 10:58:20');
INSERT INTO messages (id, sender_id, receiver_id, message, created_at, updated_at) VALUES ('2', '1', '2', 'a la kadv', '2026-01-16 10:59:30', '2026-01-16 10:59:30');
INSERT INTO messages (id, sender_id, receiver_id, message, created_at, updated_at) VALUES ('3', '1', '2', 'an vlvnq;MC''V', '2026-01-16 10:59:35', '2026-01-16 10:59:35');
INSERT INTO messages (id, sender_id, receiver_id, message, created_at, updated_at) VALUES ('4', '1', '2', 'vavavav', '2026-01-16 12:03:46', '2026-01-16 12:03:46');
INSERT INTO messages (id, sender_id, receiver_id, message, created_at, updated_at) VALUES ('5', '1', '2', 'vavavavavav', '2026-01-16 12:04:00', '2026-01-16 12:04:00');
INSERT INTO messages (id, sender_id, receiver_id, message, created_at, updated_at) VALUES ('6', '1', '2', 'vứvwvwvvdwv', '2026-01-16 12:14:26', '2026-01-16 12:14:26');
INSERT INTO messages (id, sender_id, receiver_id, message, created_at, updated_at) VALUES ('7', '1', '2', '1234567890', '2026-01-16 12:14:54', '2026-01-16 12:14:54');
INSERT INTO messages (id, sender_id, receiver_id, message, created_at, updated_at) VALUES ('8', '2', '1', '0987654321', '2026-01-16 12:15:15', '2026-01-16 12:15:15');

