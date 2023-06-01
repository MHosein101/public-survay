BEGIN TRANSACTION;
DROP TABLE IF EXISTS "options";
CREATE TABLE IF NOT EXISTS "options" (
	"id"	INTEGER NOT NULL UNIQUE,
	"id_survay"	INTEGER,
	"content"	TEXT,
	"submits"	INTEGER,
	PRIMARY KEY("id" AUTOINCREMENT)
);
DROP TABLE IF EXISTS "users";
CREATE TABLE IF NOT EXISTS "users" (
	"id"	INTEGER NOT NULL UNIQUE,
	"nickname"	TEXT,
	"email"	TEXT,
	"survay_link_manage"	TEXT,
	PRIMARY KEY("id" AUTOINCREMENT)
);
DROP TABLE IF EXISTS "survays";
CREATE TABLE IF NOT EXISTS "survays" (
	"id"	INTEGER NOT NULL UNIQUE,
	"question"	TEXT,
	"note"	TEXT,
	"link_vote"	TEXT,
	"link_manage"	TEXT,
	"views"	INTEGER,
	PRIMARY KEY("id" AUTOINCREMENT)
);
COMMIT;
