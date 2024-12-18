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
DROP TABLE IF EXISTS report_notification;
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
  deleted BOOLEAN DEFAULT FALSE NOT NULL,
  is_mod BOOLEAN DEFAULT FALSE NOT NULL,
  is_blocked BOOLEAN DEFAULT FALSE NOT NULL
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
  description TEXT NOT NULL,
  follower_count INTEGER DEFAULT 0 NOT NULL
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
  author_id INTEGER REFERENCES lbaw24112.user (id) ON DELETE SET DEFAULT NOT NULL DEFAULT 0,
  post_id INTEGER REFERENCES post (id) ON DELETE CASCADE NOT NULL
);

-- R06
CREATE TABLE IF NOT EXISTS answer (
  id SERIAL PRIMARY KEY UNIQUE NOT NULL,
  chosen BOOLEAN DEFAULT FALSE NOT NULL,
  question_id INTEGER NOT NULL REFERENCES question(id) ON DELETE CASCADE,
  author_id INTEGER REFERENCES lbaw24112.user (id) ON DELETE SET DEFAULT NOT NULL DEFAULT 0,
  post_id INTEGER REFERENCES post (id) ON DELETE CASCADE NOT NULL
);

-- R07
CREATE TABLE IF NOT EXISTS comment (
  id SERIAL PRIMARY KEY UNIQUE NOT NULL,
  answer_id INTEGER NOT NULL REFERENCES answer(id) ON DELETE CASCADE,
  author_id INTEGER REFERENCES lbaw24112.user (id) ON DELETE SET DEFAULT NOT NULL DEFAULT 0,
  post_id INTEGER REFERENCES post (id) ON DELETE CASCADE NOT NULL
);

-- R08
CREATE TABLE IF NOT EXISTS popularity_vote (
  id SERIAL PRIMARY KEY UNIQUE NOT NULL,
  is_positive BOOLEAN NOT NULL,
  user_id INTEGER REFERENCES lbaw24112.user (id) ON DELETE SET DEFAULT NOT NULL DEFAULT 0,
  question_id INTEGER REFERENCES question(id) ON DELETE CASCADE NOT NULL
);

-- R09
CREATE TABLE IF NOT EXISTS aura_vote (
  id SERIAL PRIMARY KEY UNIQUE NOT NULL,
  is_positive BOOLEAN NOT NULL,
  user_id INTEGER REFERENCES lbaw24112.user (id) ON DELETE SET DEFAULT NOT NULL DEFAULT 0,
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
CREATE TABLE IF NOT EXISTS report_notification (
  notification_id SERIAL PRIMARY KEY REFERENCES notification(id) ON DELETE CASCADE NOT NULL,
  report TEXT NOT NULL
);

-- R16
CREATE TABLE IF NOT EXISTS user_follows_tag (
  user_id INTEGER REFERENCES lbaw24112.user(id) ON DELETE CASCADE NOT NULL,
  tag_id INTEGER REFERENCES tag(id) ON DELETE CASCADE NOT NULL
);

-- R17
CREATE TABLE IF NOT EXISTS user_follows_question (
  user_id INTEGER REFERENCES lbaw24112.user(id) ON DELETE CASCADE NOT NULL,
  question_id INTEGER REFERENCES question(id) ON DELETE CASCADE NOT NULL,
  PRIMARY KEY (user_id, question_id)
);

-- R18
CREATE TABLE IF NOT EXISTS question_tags (
  question_id INTEGER REFERENCES question(id) ON DELETE CASCADE NOT NULL,
  tag_id INTEGER REFERENCES tag(id) ON DELETE CASCADE NOT NULL
);

CREATE INDEX user_name_tsvector_idx ON lbaw24112.user USING GIN (to_tsvector('simple', name));
CREATE INDEX post_title_tsvector_idx ON question USING GIN (to_tsvector('english', title));
CREATE INDEX post_body_tsvector_idx ON post USING GIN (to_tsvector('english', body));
CREATE INDEX tag_name_tsvector_idx ON tag USING GIN (to_tsvector('english', name));


INSERT INTO lbaw24112.user(id, name, nickname, email, password, birth_date, is_mod)
VALUES (0, 'DELETED', 'DELETED','DELETEDemail@fake.com', '$2y$10$BoY72PlgyoVpkCoqNSsBhunULIwdHhPbHOoOQtKATUF7kYGNgOsJy', '1111-01-01', FALSE);

INSERT INTO lbaw24112.user(name, nickname, email, password, birth_date, profile_picture, is_mod)
VALUES ('Leonor', 'Nónó', 'leonoremail@fake.com', '$2y$10$BoY72PlgyoVpkCoqNSsBhunULIwdHhPbHOoOQtKATUF7kYGNgOsJy', '2004-10-23', 'profile_pictures/N0tRfvH1MHP02zNHNNc0cHpJjdNQxckuyoLBqiPv.jpg', TRUE),
('Rodrigo', 'Rodri_5', 'rodrigoemail@fake.com', '$2y$10$BoY72PlgyoVpkCoqNSsBhunULIwdHhPbHOoOQtKATUF7kYGNgOsJy', '2004-03-16', 'profile_pictures/rJ2LsD8YY4ywMKx1UtbnJfXWWlXHKHtmrmSw60gW.jpg', TRUE),
('Pedro', 'Puka', 'pedroemail@fake.com', '$2y$10$BoY72PlgyoVpkCoqNSsBhunULIwdHhPbHOoOQtKATUF7kYGNgOsJy', '2004-11-03', 'profile_pictures/yTbQ1IqrVfz7dFDVxnR0IXCICgZ2to3MiiCbtSdv.jpg', TRUE),
('Afonso', 'Osnofa', 'afonsoemail@fake.com', '$2y$10$BoY72PlgyoVpkCoqNSsBhunULIwdHhPbHOoOQtKATUF7kYGNgOsJy', '2004-01-28', 'profile_pictures/2GphZhBD3PHr65qCHlOM0bVOCJHduKXhPZFHOsyr.jpg', TRUE),
('Miguel', 'Miguel', 'miguelemail@fake.com', '$2y$10$BoY72PlgyoVpkCoqNSsBhunULIwdHhPbHOoOQtKATUF7kYGNgOsJy', '2004-01-22', 'profile_pictures/WSS0v1cdife3VfV4TKUCt5orIIaPe5DifNsuaWeu.jpg', TRUE),
('Alexandre', 'Ramos', 'alexandreemail@fake.com', '$2y$10$BoY72PlgyoVpkCoqNSsBhunULIwdHhPbHOoOQtKATUF7kYGNgOsJy', '2004-07-17', 'profile_pictures/JPAzV9YlMUkfSkaRKBXIGogxGcrEZ65XOBYCD1LJ.jpg', FALSE),
('Afonso', 'Mansilha', 'mansilhaemail@fake.com', '$2y$10$BoY72PlgyoVpkCoqNSsBhunULIwdHhPbHOoOQtKATUF7kYGNgOsJy', '2004-04-19', 'profile_pictures/rGVQeyrqfMFkqjkdL2gpnkI8RjjwiTHI5EklbwNA.png', FALSE),
('Vicente', 'Vicente', 'vicenteemail@fake.com', '$2y$10$BoY72PlgyoVpkCoqNSsBhunULIwdHhPbHOoOQtKATUF7kYGNgOsJy', '2004-06-26', 'profile_pictures/K1LVtEeG8IIh1RZaYxKSWCDtUDFoaFnynfZDUIJv.jpg', TRUE),
('Francisco', 'Chico', 'franciscoemail@fake.com', '$2y$10$BoY72PlgyoVpkCoqNSsBhunULIwdHhPbHOoOQtKATUF7kYGNgOsJy', '2004-11-30', 'profile_pictures/X6rPuddaSb616CKoQ7W8tvMil6gicxNonLBpNVDJ.jpg', FALSE),
('Clara', 'Clara', 'claraemail@fake.com', '$2y$10$BoY72PlgyoVpkCoqNSsBhunULIwdHhPbHOoOQtKATUF7kYGNgOsJy', '2004-06-14', 'profile_pictures/EcibNls9rCYEBMSk0vRQLf5AT8CQkijt1T78ZbYC.jpg', FALSE),
('Rafael', 'Rafa', 'rafaelemail@fake.com', '$2y$10$BoY72PlgyoVpkCoqNSsBhunULIwdHhPbHOoOQtKATUF7kYGNgOsJy', '2004-12-22', 'profile_pictures/5P31c2m0XosLV5HWAl8gTDXUm0vVmNO6ht9llkev.png', FALSE);


INSERT INTO admin (id, admin_start)
VALUES 
(1, '2024-12-03'),
(2, '2024-12-01'),
(3, '2024-11-25'),
(4, '2024-11-30');


INSERT INTO tag(name, description)
VALUES ('computers', 'all things related to the little machines that we control (or atleast think we do)'),
('cookies', 'from the savoury to the yummy, all things cookies'),
('sports', 'a place to talk about what brings us together: sports'),
('colors', 'roses are red, violets are blue, join us if you love colors too'),
('gaming', 'from the classics to the new releases, all things gaming'),
('airplanes', 'we love to fly!'),
('music', 'all bangers included from mozart to ksi'),
('math', 'from the simple to the complex, all things math');


INSERT INTO post(body, time_stamp)
VALUES ('my computer crashed tooday, it was driving me to school and now i am lost.', '2024-05-31 21:00:00'),
('I need help with a windows update, can anyone help me?', '2023-12-27 19:00:00'),
('I love biscuits, especially hungaros and belgas. Any suggestions?', '2024-05-31 14:00:00'),
('I dont know why my tummy hurts, I ate a lot of cookies this morning but I was hungry and my tummy was hurting, but now it hurts even more!!!! Pleawse HEL?PPP', '2024-03-16 13:31:54'),
('I just love Benfica, they are the best team in the world! They play the beautiful game and make me smile everytime',  '2024-07-19 16:31:54'),
('Estonian league is a mess, I love it!',  '2015-10-20 06:31:54'),
('I love purple, what are your favorite colors?','2018-02-28 00:00:00' ),
('FAST I have a 50 word essay due tomorrow on rainbows, what are their 7 colors?', '2022-02-03 21:00:00'),
('I am a grand champ in rocket league, looking for a duo partner!', '2024-11-27 00:00:00'),
('guys i need help to play lol, im too bad xD', '2024-01-03 00:00:00'),
('For me its Airbus A380 all the way, what about you?', '2024-11-09 14:00:00'),
('I am flying to Madrid next week, any tips and suggestions?', '2023-12-30 00:00:00'),
('Primavera Sound is coming up, anyone else excited?', '2024-09-16 00:00:00'),
('I love all music, but I am a sucker for a good pop song.', '2024-08-28 00:00:00'),
('I was asked an interview question where I needed to use it but I have no idea what it is. So in plain english what is the Fast Fourier Transform and how can I use it to find the derivative of a function given its (x, y) values as input?', '2024-12-06 18:00:00');

INSERT INTO post(body, time_stamp, edit_time)
VALUES ('teste de edit', '2024-08-28 00:00:00', '2024-12-17 22:00:00');

INSERT INTO question(title, urgency, time_end, author_id ,post_id)
VALUES ('I need help fixing my computer!!', 'Red', '2024-06-01 00:00:00', 1, 1),
('How to install a windows update', 'Orange', '2023-12-28 00:00:00', 5, 2),
('Any new biscuit recomendation?', 'Yellow', '2024-06-01 00:00:00', 4, 3),
('Why does my tummy hurt?', 'Red', '2024-03-16 16:31:54', 10, 4),
('Benfica is the greatest team in the world', 'Green', '2024-07-20 16:31:54', 9, 5),
('Estonian league shenanigans...', 'Yellow', '2015-10-20 16:31:54', 8, 6),
('What is the best color?', 'Green', '2018-03-01 00:00:00', 2, 7),
('HELP what are the 7 colors of the rainbow??', 'Red', '2022-02-04 00:00:00', 3, 8),
('Any grand champs to duo with?', 'Green', '2024-11-28 00:00:00', 6, 9),
('Any tips for a noob in LoL?', 'Green', '2024-01-04 00:00:00', 7, 10),
('Are you a Boeing 747 or an Airbus A380 type of guy?', 'Yellow', '2024-11-10 00:00:00', 4, 11),
('Im flying to Madrid next week', 'Green', '2023-12-31 00:00:00', 3, 12),
('Anyone else excited for Primavera Sound?', 'Green', '2024-09-17 00:00:00', 2, 13),
('Favorite music genres?', 'Green', '2024-08-29 00:00:00', 7, 14),
('What is the Fast Fourier Transform?', 'Green', '2024-12-07 18:00:00', 9, 15),
('teste de edit', 'Green', '2024-12-18 22:00:00', 2, 16);


INSERT INTO question_tags(question_id, tag_id)
VALUES (1, 1),
(2, 1),
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
(14, 7),
(15, 8),
(16, 4);


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
('I love pop music, its the best genre out there'),
('Say you have a sound coming from the speaker.

You then set up, lets get a nice round number here, 1024 harmonic oscillators that resonate to specific frequency ranges.

Play the sound for, say, a second.

Oscillators begin to resonate to the sound coming from the speaker. After the said second you read how much every oscillator is resonating. As a result you get a discrete fourier transform, meaning you get a chart of how much each of the frequency ranges contributed to the sound coming from the speaker.

Instead of visualising the sound as amount of air pressure caused by the waveform, changing in time slots, you visualized it as a series of intensities of the frequency ranges.

Of course in explaining the DFT, the speakers part is not really appropriate since you have to work on sampled input. So in this case the 1024 digital "oscillators" should actually be measured after 1/44th of a second, given the audio is sampled at the rate of 44kHz.

Fast Fourier Transform is an algorithm to perform a Discrete Fourier Transform thats pretty easy for computers to run on an incoming signal. It imposes some constraints you have to work with in your implementation (e.g. the number of samples has to be a power of 2), because it uses some clever tricks to drastically reduce the amount of calculation performed on the sample buffer.

There is really no need to go deeper, since the two links I gave provide a pretty clear explanation. And note that its impossible to go from theory to implementation without knowing the math behind it.

I hope this introduction makes some sense!
');

INSERT INTO answer(chosen, question_id, author_id, post_id)
VALUES (FALSE, 1, 4, 16),
(TRUE, 2, 7, 17),
(FALSE, 3, 3, 18),
(FALSE, 4, 1, 19),
(TRUE, 5, 3, 20),
(FALSE, 6, 6, 21),
(FALSE, 7, 6, 22),
(FALSE, 8, 5, 23),
(FALSE, 9, 5, 24),
(TRUE, 10, 3, 25),
(FALSE, 11, 10, 26),
(TRUE, 12, 9, 27),
(FALSE, 13, 8, 28),
(FALSE, 14, 1, 29),
(FALSE, 15, 11, 30);





CREATE OR REPLACE FUNCTION update_post_edit_time()
    RETURNS TRIGGER AS $$
        BEGIN
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
    -- Increment or decrement the aura of the answer owner
    IF NEW.is_positive THEN
        UPDATE lbaw24112.user
        SET aura = aura + 1
        WHERE id = (SELECT author_id FROM lbaw24112.answer WHERE id = NEW.answer_id);
    ELSE
        UPDATE lbaw24112.user
        SET aura = aura - 1
        WHERE id = (SELECT author_id FROM lbaw24112.answer WHERE id = NEW.answer_id);
    END IF;

    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER TRIGGER02
AFTER INSERT ON aura_vote
FOR EACH ROW
EXECUTE FUNCTION update_user_aura();


CREATE OR REPLACE FUNCTION reverse_user_aura()
RETURNS TRIGGER AS $$
BEGIN
    -- Reverse the aura adjustment for the answer owner
    IF OLD.is_positive THEN
        UPDATE lbaw24112.user
        SET aura = aura - 1
        WHERE id = (SELECT author_id FROM lbaw24112.answer WHERE id = OLD.answer_id);
    ELSE
        UPDATE lbaw24112.user
        SET aura = aura + 1
        WHERE id = (SELECT author_id FROM lbaw24112.answer WHERE id = OLD.answer_id);
    END IF;

    RETURN OLD;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER TRIGGER03
AFTER DELETE ON aura_vote
FOR EACH ROW
EXECUTE FUNCTION reverse_user_aura();



CREATE OR REPLACE FUNCTION create_vote_notification() RETURNS TRIGGER AS $$
DECLARE
    total_votes INTEGER;
    post_id INTEGER;
    threshold INTEGER;
    thresholds INTEGER[] := ARRAY[1, 5, 10, 20, 50, 100];
BEGIN
    IF TG_TABLE_NAME = 'popularity_vote' THEN
        SELECT
            question.post_id INTO post_id
        FROM
            question
        WHERE
            question.id = NEW.question_id;

        SELECT
            COUNT(CASE WHEN is_positive THEN 1 END) -
            COUNT(CASE WHEN NOT is_positive THEN 1 END)
        INTO
            total_votes
        FROM
            popularity_vote
        WHERE
            question_id = NEW.question_id;

    ELSIF TG_TABLE_NAME = 'aura_vote' THEN
        SELECT
            answer.post_id INTO post_id
        FROM
            answer
        WHERE
            answer.id = NEW.answer_id;

        SELECT
            COUNT(CASE WHEN is_positive THEN 1 END) -
            COUNT(CASE WHEN NOT is_positive THEN 1 END)
        INTO
            total_votes
        FROM
            aura_vote
        WHERE
            answer_id = NEW.answer_id;
    END IF;

    FOREACH threshold IN ARRAY thresholds LOOP
        IF total_votes = threshold THEN
            -- Insert a new notification
            INSERT INTO notification (content, time_stamp, post_id, user_id)
            VALUES (
                threshold || ' votes reached!',
                CURRENT_TIMESTAMP,
                post_id,
                COALESCE(NEW.user_id, OLD.user_id)
            )
            RETURNING id INTO threshold;

            INSERT INTO vote_notification (notification_id, votes)
            VALUES (threshold, total_votes);
            RETURN NULL;
        END IF;
    END LOOP;

    RETURN NULL;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER popularity_vote_notification
AFTER INSERT OR UPDATE OR DELETE ON popularity_vote
FOR EACH ROW
EXECUTE FUNCTION create_vote_notification();

CREATE TRIGGER aura_vote_notification
AFTER INSERT OR UPDATE OR DELETE ON aura_vote
FOR EACH ROW
EXECUTE FUNCTION create_vote_notification();

---

-- When a user is deleted it is replaced by the DELETED user
CREATE OR REPLACE FUNCTION reassign_user_content()
RETURNS TRIGGER AS $$
BEGIN
    UPDATE question
    SET author_id = 0
    WHERE author_id = OLD.id;

    UPDATE answer
    SET author_id = 0
    WHERE author_id = OLD.id;

    UPDATE comment
    SET author_id = 0
    WHERE author_id = OLD.id;

    UPDATE popularity_vote
    SET user_id = 0
    WHERE user_id = OLD.id;

    UPDATE aura_vote
    SET user_id = 0
    WHERE user_id = OLD.id;

    RETURN OLD;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER TRIGGER04
AFTER DELETE ON lbaw24112.user
FOR EACH ROW
EXECUTE FUNCTION reassign_user_content();

-- Function to increment follower_count
CREATE OR REPLACE FUNCTION increment_follower_count()
RETURNS TRIGGER AS $$
BEGIN
  -- Increment the follower_count in the tag table
  UPDATE tag
  SET follower_count = follower_count + 1
  WHERE id = NEW.tag_id;

  RETURN NEW;
END;
$$ LANGUAGE plpgsql;

-- Trigger to call the function before inserting into user_follows_tag
CREATE TRIGGER trigger_increment_follower_count
AFTER INSERT ON user_follows_tag
FOR EACH ROW
EXECUTE FUNCTION increment_follower_count();

INSERT INTO user_follows_tag(user_id, tag_id)
VALUES (1,1),
(1,2),
(1,4),
(1,7),
(2,1),
(2,5),
(2,7),
(3,1),
(3,2),
(3,3),
(3,5),
(4,1),
(4,2),
(4,6),
(4,7),
(5,1),
(5,5),
(5,7),
(6,1),
(6,3),
(6,4),
(6,5),
(6,6),
(7,3),
(7,5),
(7,6),
(8,1),
(8,3),
(8,7),
(9,1),
(9,3),
(9,5),
(10,1),
(10,2),
(10,4),
(10,7),
(11,6),
(11,8);


CREATE OR REPLACE FUNCTION decrement_follower_count()
RETURNS TRIGGER AS $$
BEGIN
    -- Decrement the follower_count in the tags table
    UPDATE tag
    SET follower_count = follower_count - 1
    WHERE id = OLD.tag_id;

    RETURN OLD; -- Return the deleted row
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER on_user_follows_tag_delete
AFTER DELETE ON user_follows_tag
FOR EACH ROW
EXECUTE FUNCTION decrement_follower_count();

