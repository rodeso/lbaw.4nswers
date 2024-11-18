DROP SCHEMA IF EXISTS lbaw24112 CASCADE;
CREATE SCHEMA IF NOT EXISTS lbaw24112;

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
  id SERIAL PRIMARY KEY UNIQUE NOT NULL,
  name VARCHAR NOT NULL,
  nickname VARCHAR UNIQUE CHECK (LENGTH(nickname) <= 24) NOT NULL,
  email VARCHAR UNIQUE NOT NULL,
  password VARCHAR NOT NULL,
  birth_date DATE CHECK (birth_date <= CURRENT_DATE - INTERVAL '13 years') NOT NULL,
  aura INT DEFAULT 0 NOT NULL,
  profile_picture VARCHAR DEFAULT 'default.png' NOT NULL,
  created DATE DEFAULT CURRENT_DATE NOT NULL,
  deleted BOOLEAN DEFAULT FALSE NOT NULL,
  is_mod BOOLEAN DEFAULT FALSE NOT NULL
);

-- R02
CREATE TABLE IF NOT EXISTS admin (
  id SERIAL PRIMARY KEY REFERENCES lbaw24112.user (id) ON DELETE CASCADE UNIQUE NOT NULL,
  admin_start DATE NOT NULL
);

-- R03
CREATE TABLE IF NOT EXISTS tag (
  id SERIAL PRIMARY KEY UNIQUE NOT NULL,
  name VARCHAR(32) UNIQUE CHECK (LENGTH(name) <= 32) NOT NULL,
  description TEXT NOT NULL
);

-- R04
CREATE TABLE IF NOT EXISTS post (
  id SERIAL PRIMARY KEY UNIQUE NOT NULL,
  body TEXT CHECK (LENGTH(body) <= 4096) NOT NULL,
  time_stamp TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  deleted BOOLEAN DEFAULT FALSE NOT NULL,
  edited BOOLEAN DEFAULT FALSE NOT NULL,
  edit_time TIMESTAMP DEFAULT NULL
);

-- R05
CREATE TABLE IF NOT EXISTS question (
  id SERIAL PRIMARY KEY UNIQUE NOT NULL,
  title TEXT NOT NULL,
  urgency TEXT NOT NULL,
  time_end TIMESTAMP NOT NULL,
  closed BOOLEAN DEFAULT FALSE NOT NULL,
  author_id INTEGER REFERENCES lbaw24112.user (id) ON DELETE CASCADE NOT NULL,
  post_id INTEGER REFERENCES post (id) ON DELETE CASCADE NOT NULL
);

-- R06
CREATE TABLE IF NOT EXISTS answer (
  id SERIAL PRIMARY KEY UNIQUE NOT NULL,
  chosen BOOLEAN DEFAULT FALSE NOT NULL,
  question_id INTEGER NOT NULL REFERENCES question(id) ON DELETE CASCADE,
  author_id INTEGER REFERENCES lbaw24112.user (id) ON DELETE CASCADE NOT NULL,
  post_id INTEGER REFERENCES post (id) ON DELETE CASCADE NOT NULL
);

-- R07
CREATE TABLE IF NOT EXISTS comment (
  id SERIAL PRIMARY KEY UNIQUE NOT NULL,
  answer_id INTEGER NOT NULL REFERENCES answer(id) ON DELETE CASCADE,
  author_id INTEGER REFERENCES lbaw24112.user (id) ON DELETE CASCADE NOT NULL,
  post_id INTEGER REFERENCES post (id) ON DELETE CASCADE NOT NULL
);

-- R08
CREATE TABLE IF NOT EXISTS popularity_vote (
  id SERIAL PRIMARY KEY UNIQUE NOT NULL,
  is_positive BOOLEAN NOT NULL,
  user_id INTEGER REFERENCES lbaw24112.user (id) ON DELETE CASCADE NOT NULL,
  question_id INTEGER REFERENCES question(id) ON DELETE CASCADE NOT NULL
);

-- R09
CREATE TABLE IF NOT EXISTS aura_vote (
  id SERIAL PRIMARY KEY UNIQUE NOT NULL,
  is_positive BOOLEAN NOT NULL,
  user_id INTEGER REFERENCES lbaw24112.user (id) ON DELETE CASCADE NOT NULL,
  answer_id INTEGER REFERENCES answer(id) ON DELETE CASCADE NOT NULL
);

-- R10
CREATE TABLE IF NOT EXISTS notification (
  id SERIAL PRIMARY KEY UNIQUE NOT NULL,
  content TEXT NOT NULL,
  time_stamp TIMESTAMP NOT NULL,
  post_id INTEGER REFERENCES post (id) ON DELETE CASCADE NOT NULL,
  user_id INTEGER REFERENCES lbaw24112.user (id) ON DELETE CASCADE NOT NULL
);

-- R11
CREATE TABLE IF NOT EXISTS vote_notification (
  notification_id SERIAL PRIMARY KEY REFERENCES notification(id) ON DELETE CASCADE NOT NULL,
  votes INTEGER NOT NULL
);

-- R12
CREATE TABLE IF NOT EXISTS answer_notification (
  notification_id SERIAL PRIMARY KEY REFERENCES notification(id) ON DELETE CASCADE NOT NULL,
  user_ TEXT DEFAULT 'A user' NOT NULL
);

-- R13
CREATE TABLE IF NOT EXISTS helpful_notification (
  notification_id SERIAL PRIMARY KEY REFERENCES notification(id) ON DELETE CASCADE NOT NULL
);

-- R14
CREATE TABLE IF NOT EXISTS moderator_notification (
  notification_id SERIAL PRIMARY KEY REFERENCES notification(id) ON DELETE CASCADE NOT NULL,
  reason TEXT NOT NULL
);

-- R15
CREATE TABLE IF NOT EXISTS user_follows_tag (
  user_id INTEGER REFERENCES lbaw24112.user(id) ON DELETE CASCADE NOT NULL,
  tag_id INTEGER REFERENCES tag(id) ON DELETE CASCADE NOT NULL
);

-- R16
CREATE TABLE IF NOT EXISTS user_follows_question (
  user_id INTEGER REFERENCES lbaw24112.user(id) ON DELETE CASCADE NOT NULL,
  question_id INTEGER REFERENCES question(id) ON DELETE CASCADE NOT NULL
);

-- R17
CREATE TABLE IF NOT EXISTS question_tags (
  question_id INTEGER REFERENCES question(id) ON DELETE CASCADE NOT NULL,
  tag_id INTEGER REFERENCES tag(id) ON DELETE CASCADE NOT NULL
);


INSERT INTO lbaw24112.user(name, nickname, email, password, birth_date, profile_picture)
VALUES ('Leonor', 'Nónó', 'leonoremail@fake.com', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', '2004-10-23', 'default.png'),
('Rodrigo', 'Rodri_5', 'rodrigoemail@fake.com', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', '2004-03-16', 'default.png'),
('Pedro', 'Puka', 'pedroemail@fake.com', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', '2004-11-03', 'default.png'),
('Afonso', 'Osnofa', 'afonsoemail@fake.com', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', '2004-01-28', 'default.png');

INSERT INTO tag(name, description)
VALUES ('computers', 'all things related to the little machines that we control (or atleast think we do)'),
('cookies', 'from the savoury to the yummy, all things cookies'),
('music', 'all bangers included from mozart to ksi');

INSERT INTO post(body)
VALUES ('my computer crashed tooday, it was driving me to school and now i am lost.'),
('I love biscuits. Hungaros and belgas are the best.'),
('I love music, it is the best thing in the world.'),
('I dont know why my tummy hurts, I ate a lot of cookies this morning but I was hungry and my tummy was hurting, but now it hurts even more!!!! Pleawse HEL?PPP');


INSERT INTO question(title, urgency, time_end, author_id ,post_id)
VALUES ('I need help fixing my computer!!', 'Red', '2021-06-01 00:00:00', 1, 1),
('Any new biscuit recomendation?', 'Green', '2021-06-01 00:00:00', 4, 2),
('What is the best music genre?', 'Yellow', '2021-06-01 00:00:00', 3, 3),
('Why does my tummy hurt?', 'Orange', '2014-03-16 16:31:54', 2, 4);

INSERT INTO question_tags(question_id, tag_id)
VALUES (1, 1),
(2, 2),
(3, 3),
(4, 2);

CREATE OR REPLACE FUNCTION update_post_edit_time()
    RETURNS TRIGGER AS $$
        BEGIN
            NEW.edited := TRUE;
            NEW.edit_time := CURRENT_TIMESTAMP;
            RETURN NEW;
        END;
    $$ LANGUAGE plpgsql;

CREATE TRIGGER TRIGGER01
BEFORE UPDATE ON post
FOR EACH ROW
WHEN (OLD.body IS DISTINCT FROM NEW.body)
EXECUTE FUNCTION update_post_edit_time();


---

CREATE OR REPLACE FUNCTION update_user_aura()
RETURNS TRIGGER AS $$
BEGIN
    IF NEW.is_positive THEN
        UPDATE lbaw24112.user SET aura = aura + 1 WHERE id = NEW.user_id;
    ELSE
        UPDATE lbaw24112.user SET aura = aura - 1 WHERE id = NEW.user_id;
    END IF;
    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER TRIGGER02
AFTER INSERT ON aura_vote
FOR EACH ROW
EXECUTE FUNCTION update_user_aura();