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
  profile_picture VARCHAR DEFAULT 'profile_pictures/5P31c2m0XosLV5HWAl8gTDXUm0vVmNO6ht8llkev.png' NOT NULL,
  created DATE DEFAULT CURRENT_DATE NOT NULL,
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

CREATE INDEX post_body_tsvector_idx ON post USING GIN (to_tsvector('english', body));


INSERT INTO lbaw24112.user(name, nickname, email, password, birth_date)
VALUES ('Leonor', 'Nónó', 'leonoremail@fake.com', '$2y$10$BoY72PlgyoVpkCoqNSsBhunULIwdHhPbHOoOQtKATUF7kYGNgOsJy', '2004-10-23'),
('Rodrigo', 'Rodri_5', 'rodrigoemail@fake.com', '$2y$10$BoY72PlgyoVpkCoqNSsBhunULIwdHhPbHOoOQtKATUF7kYGNgOsJy', '2004-03-16'),
('Pedro', 'Puka', 'pedroemail@fake.com', '$2y$10$BoY72PlgyoVpkCoqNSsBhunULIwdHhPbHOoOQtKATUF7kYGNgOsJy', '2004-11-03'),
('Afonso', 'Osnofa', 'afonsoemail@fake.com', '$2y$10$BoY72PlgyoVpkCoqNSsBhunULIwdHhPbHOoOQtKATUF7kYGNgOsJy', '2004-01-28'),
('Miguel', 'Miguel', 'miguelemail@fake.com', '$2y$10$BoY72PlgyoVpkCoqNSsBhunULIwdHhPbHOoOQtKATUF7kYGNgOsJy', '2004-01-22'),
('Alexandre', 'Ramos', 'alexandreemail@fake.com', '$2y$10$BoY72PlgyoVpkCoqNSsBhunULIwdHhPbHOoOQtKATUF7kYGNgOsJy', '2004-07-17'),
('Afonso', 'Mansilha', 'mansilhaemail@fake.com', '$2y$10$BoY72PlgyoVpkCoqNSsBhunULIwdHhPbHOoOQtKATUF7kYGNgOsJy', '2004-04-19'),
('Vicente', 'Vicente', 'vicenteemail@fake.com', '$2y$10$BoY72PlgyoVpkCoqNSsBhunULIwdHhPbHOoOQtKATUF7kYGNgOsJy', '2004-06-26'),
('Francisco', 'Chico', 'franciscoemail@fake.com', '$2y$10$BoY72PlgyoVpkCoqNSsBhunULIwdHhPbHOoOQtKATUF7kYGNgOsJy', '2004-11-30')
('Clara', 'Clara', 'claraemail@fake.com', '$2y$10$BoY72PlgyoVpkCoqNSsBhunULIwdHhPbHOoOQtKATUF7kYGNgOsJy', '2004-06-14');

INSERT INTO tag(name, description)
VALUES ('computers', 'all things related to the little machines that we control (or atleast think we do)'),
('cookies', 'from the savoury to the yummy, all things cookies'),
('sports', 'a place to talk about what brings us together: sports'),
('colors', 'roses are red, violets are blue, join us if you love colors too'),
('gaming', 'from the classics to the new releases, all things gaming'),
('airplanes', 'we love to fly!'),
('music', 'all bangers included from mozart to ksi');

INSERT INTO post(body)
VALUES ('my computer crashed tooday, it was driving me to school and now i am lost.'),
('I need help with a windows update, can anyone help me?'),
('I love biscuits, especially hungaros and belgas. Any suggestions?'),
('I dont know why my tummy hurts, I ate a lot of cookies this morning but I was hungry and my tummy was hurting, but now it hurts even more!!!! Pleawse HEL?PPP')
('I just love Benfica, they are the best team in the world! They play the beautiful game and make me smile everytime'),
('Estonian league is a mess, I love it!'),
('I love purple, what are your favorite colors?'),
('FAST I have a 50 word essay due tomorrow on rainbows, what are their 7 colors?'),
('I am a grand champ in rocket league, looking for a duo partner!'),
('guys i need help to play lol, im too bad xD'),
('For me its Airbus A380 all the way, what about you?'),
('I am flying to Madrid next week, any tips and suggestions?'),
('Primavera Sound is coming up, anyone else excited?'),
('I love all music, but I am a sucker for a good pop song.')
;


INSERT INTO question(title, urgency, time_end, author_id ,post_id)
VALUES ('I need help fixing my computer!!', 'Red', '2021-06-01 00:00:00', 1, 1),
('How to install a windows update', 'Orange', '2024-11-28 00:00:00', 5, 2),
('Any new biscuit recomendation?', 'Yellow', '2021-06-01 00:00:00', 4, 3),
('Why does my tummy hurt?', 'Red', '2014-03-16 16:31:54', 10, 4),
('Benfica is the greatest team in the world', 'Green', '2014-03-16 16:31:54', 9, 5),
('Estonian league shenanigans...', 'Yellow', '2014-03-16 16:31:54', 8, 6),
('What is the best color?', 'Green', '2021-06-01 00:00:00', 2, 7),
('HELP what are the 7 colors of the rainbow??', 'Red', '2021-06-01 00:00:00', 3, 8),
('Any grand champs to duo with?', 'Green', '2024-11-28 00:00:00', 6, 9),
('Any tips for a noob in LoL?', 'Green', '2021-06-01 00:00:00', 7, 10),
('Are you a Boing 747 or an Airbus A380 type of guy?', 'Yellow', '2021-06-01 00:00:00', 4, 11),
('Im flying to Madrid next week', 'Green', '2021-06-01 00:00:00', 3, 12),
('Anyone else excited for Primavera Sound?', 'Green', '2021-06-01 00:00:00', 2, 13),
('Favorite music genres?', 'Green', '2021-06-01 00:00:00', 7, 14);



INSERT INTO question_tags(question_id, tag_id)
VALUES (1, 1),
(2, 1)
(3, 2),
(4, 2),
(5, 3),
(6, 3),
(7, 4),
(8, 4),
(9, 5),
(10, 5),
(11, 6),
(12, 6),
(13, 7),
(14, 7);

INSERT INTO post(body)
VALUES ('Have you tried turning it off and on again?'),
('I have the same problem, I think its a bug in the update'),
('I love the belgas, they are so good!'),
('You might have eaten too many cookies, try drinking some water'),
('I also love the Glorioso Benfica'),
('Estonian league should be considered a national treasure'),
('Honestly, purple is kinda awful as a color, but sure'),
('The 7 colors of the rainbow are red, orange, yellow, green, blue, indigo and violet'),
('I am a grand champ, I can help you out'),
('I can help you out, what do you need help with?'),
('I love the Airbus A380, its a beautiful plane'),
('I live in Madrid, I have some tips for you'),
('IM SO EXCITED, its gonna be hype'),
('I love pop music, its the best genre out there');

INSERT INTO answer(chosen, question_id, author_id, post_id)
VALUES (FALSE, 1, 4, 15),
(TRUE, 2, 7, 16),
(FALSE, 3, 3, 17),
(FALSE, 4, 1, 18),
(TRUE, 5, 3, 19),
(FALSE, 6, 6, 20),
(FALSE, 7, 2, 21),
(FALSE, 8, 5, 22),
(FALSE, 9, 5, 23),
(TRUE, 10, 3, 24),
(FALSE, 11, 10, 25),
(TRUE, 12, 9, 26),
(FALSE, 13, 8, 27),
(FALSE, 14, 1, 28);



INSERT INTO user_follows_tag(user_id, tag_id)
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