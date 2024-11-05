SET search_path TO lbaw24112;


DROP TABLE IF EXISTS lbaw24112.user;
DROP TABLE IF EXISTS admin;
DROP TABLE IF EXISTS tag;
DROP TABLE IF EXISTS question;
DROP TABLE IF EXISTS answer;
DROP TABLE IF EXISTS comment;
DROP TABLE IF EXISTS popularity_vote;
DROP TABLE IF EXISTS aura_vote;
DROP TABLE IF EXISTS notification;
DROP TABLE IF EXISTS moderator_notification;
DROP TABLE IF EXISTS vote_notification;
DROP TABLE IF EXISTS helpful_notification;
DROP TABLE IF EXISTS answer_notification;
DROP TABLE IF EXISTS post;
DROP TABLE IF EXISTS user_follows_tag;
DROP TABLE IF EXISTS user_follows_question;
DROP TABLE IF EXISTS question_tags;

CREATE DOMAIN Today DATE DEFAULT CURRENT_DATE;

CREATE TYPE priority_level AS ENUM ('Red', 'Orange', 'Yellow', 'Green');
CREATE DOMAIN Priority AS priority_level;


-- R01
CREATE TABLE IF NOT EXISTS lbaw24112.user (
  id INTEGER SERIAL PRIMARY KEY UNIQUE NOT NULL,
  name VARCHAR NOT NULL,
  nickname VARCHAR UNIQUE CHECK (nickname.size <= 24) NOT NULL,
  email VARCHAR UNIQUE NOT NULL,
  password VARCHAR NOT NULL,
  birth_date DATE CHECK (birth_date <= Today - INTERVAL '13 years') NOT NULL,
  aura INT DEFAULT 0 NOT NULL,
  profile_picture VARCHAR DEFAULT 'default.png' NOT NULL,
  created DATE DEFAULT CURRENT_DATE NOT NULL,
  deleted BOOLEAN DEFAULT FALSE NOT NULL,
  is_mod BOOLEAN DEFAULT FALSE NOT NULL,
);

-- R02
CREATE TABLE IF NOT EXISTS admin (
  id INTEGER SERIAL PRIMARY KEY REFERENCES lbaw24112.user (id) UNIQUE NOT NULL,
  admin_start DATE CHECK (admin_start >= (SELECT created FROM lbaw24112.user WHERE id = lbaw24112.admin.id)) NOT NULL,
);

-- R03
CREATE TABLE IF NOT EXISTS tag (
  id INTEGER SERIAL PRIMARY KEY UNIQUE NOT NULL,
  name VARCHAR(32) UNIQUE CHECK (name.size <= 32) NOT NULL,
  description TEXT NOT NULL
);

-- R04
CREATE TABLE IF NOT EXISTS post (
  id INTEGER SERIAL PRIMARY KEY UNIQUE NOT NULL,
  body TEXT CHECK (body.size >= 4096) NOT NULL,
  time_stamp TIMESTAMP NOT NULL,
  deleted BOOLEAN DEFAULT FALSE NOT NULL,
  edited BOOLEAN DEFAULT FALSE NOT NULL
  edit_time TIMESTAMP DEFAULT NULL
);

-- R05
CREATE TABLE IF NOT EXISTS question (
  id INTEGER SERIAL PRIMARY KEY UNIQUE NOT NULL,
  title TEXT NOT NULL,
  urgency TEXT DEFAULT Priority NOT NULL,
  time_end TIMESTAMP CHECK (time_end >= time_stamp) NOT NULL,
  closed BOOLEAN DEFAULT FALSE NOT NULL,
  author_id INTEGER REFERENCES lbaw24112.user (id) NOT NULL,
  post_id INTEGER REFERENCES post (id) NOT NULL 
);

-- R06
CREATE TABLE IF NOT EXISTS answer (
  id INTEGER SERIAL PRIMARY KEY UNIQUE NOT NULL,
  chosen BOOLEAN DEFAULT FALSE NOT NULL,
  question_id INTEGER NOT NULL REFERENCES question(id),
  author_id INTEGER REFERENCES lbaw24112.user (id) NOT NULL,
  post_id INTEGER REFERENCES post (id) NOT NULL
);

-- R07
CREATE TABLE IF NOT EXISTS comment (
  id INTEGER SERIAL PRIMARY KEY UNIQUE NOT NULL,
  answer_id  INTEGER NOT NULL REFERENCES answer(id),
  author_id INTEGER REFERENCES lbaw24112.user (id) NOT NULL,
  post_id INTEGER REFERENCES post (id) NOT NULL 
);

-- R08
CREATE TABLE IF NOT EXISTS popularity_vote (
  id INTEGER SERIAL PRIMARY KEY UNIQUE NOT NULL,
  is_positive BOOLEAN NOT NULL,
  user_id INTEGER REFERENCES lbaw24112.user (id) NOT NULL,
  question_id  INTEGER REFERENCES question(id) NOT NULL
);

-- R09
CREATE TABLE IF NOT EXISTS aura_vote (
  id INTEGER SERIAL PRIMARY KEY UNIQUE NOT NULL,
  is_positive BOOLEAN NOT NULL,
  user_id INTEGER REFERENCES lbaw24112.user (id) NOT NULL,
  answer_id  INTEGER REFERENCES answer(id) NOT NULL
);

-- R10
CREATE TABLE IF NOT EXISTS notification (
  id INTEGER SERIAL PRIMARY KEY UNIQUE NOT NULL,
  content TEXT NOT NULL,
  time_stamp TIMESTAMP NOT NULL,
  post_id INTEGER REFERENCES post (id) NOT NULL,
  user_id INTEGER REFERENCES lbaw24112.user (id) NOT NULL
);

-- R11
CREATE TABLE IF NOT EXISTS vote_notification (
  notification_id INTEGER PRIMARY KEY REFERENCES notification(id) NOT NULL,
  votes INTEGER NOT NULL
);

-- R12
CREATE TABLE IF NOT EXISTS answer_notification (
  notification_id INTEGER PRIMARY KEY REFERENCES notification(id) NOT NULL,
  user TEXT DEFAULT 'A user' NOT NULL
);

-- R13
CREATE TABLE IF NOT EXISTS helpful_notification (
  notification_id INTEGER PRIMARY KEY REFERENCES notification(id) NOT NULL
);

-- R14
CREATE TABLE IF NOT EXISTS moderator_notification (
  notification_id INTEGER PRIMARY KEY REFERENCES notification(id) NOT NULL,
  reason TEXT NOT NULL
);

-- R15
CREATE TABLE IF NOT EXISTS user_follows_tag (
  user_id INTEGER REFERENCES lbaw24112.user(id) NOT NULL,
  tag_id INTEGER REFERENCES tag(id) NOT NULL
);

-- R16
CREATE TABLE IF NOT EXISTS user_follows_question (
  user_id INTEGER REFERENCES lbaw24112.user(id) NOT NULL,
  question_id INTEGER REFERENCES question(id) NOT NULL
);

-- R17
CREATE TABLE IF NOT EXISTS question_tags (
  question_id INTEGER REFERENCES question(id) NOT NULL,
  tag_id INTEGER REFERENCES tag(id) NOT NULL
);

--------------------------------------------------------------------------------------------



SELECT * FROM user;