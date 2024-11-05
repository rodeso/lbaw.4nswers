INSERT INTO lbaw24112.user(name, nickname, email, password, birth_date, profile_picture)
VALUES ('Leonor', 'Nónó', 'leonoremail@fake.com', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', '2004-10-23', 'default.png');
VALUES ('Rodrigo', 'Rodri_5', 'rodrigoemail@fake.com', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', '2004-03-16', 'default.png');
VALUES ('Pedro', 'Puka', 'pedroemail@fake.com', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', '2004-11-03', 'default.png');
VALUES ('Afonso', 'Osnofa', 'afonsoemail@fake.com', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', '2004-01-28', 'default.png');

INSERT INTO tag(name, description)
VALUES ('computers', 'all things related to the little machines that we control (or atleast think we do)');
VALUES ('cookies', 'from the savoury to the yummy, all things cookies');
VALUES ('music', 'all bangers included from mozart to ksi')

INSERT INTO post(body)
VALUES ('my computer crashed tooday, it was driving me to school and now i am lost.');
VALUES ('I love biscuits. Hungaros and belgas are the best.');
VALUES ('I love music, it is the best thing in the world.');
VALUES ('I dont know why my tummy hurts, I ate a lot of cookies this morning but I was hungry and my tummy was hurting, but now it hurts even more!!!! Pleawse HEL?PPP');


INSERT INTO question(title, urgency, time_end, author_id ,post_id)
VALUES ('I need help fixing my computer!!', 'Red', '2021-06-01 00:00:00', 1, 1);
VALUES ('Any new biscuit recomendation?', 'Green', '2021-06-01 00:00:00', 4, 2);
VALUES ('What is the best music genre?', 'Yellow', '2021-06-01 00:00:00', 3, 3);
VALUES ('Why does my tummy hurt?' 'Orange', '2014-03-16 16:31:54', 2, 4)

INSERT INTO question_tags(question_id, tag_id)
VALUES (1, 1);
VALUES (2, 2);
VALUES (3, 3);
VALUES (4, 2);


BEGIN;

UPDATE lbaw24112.user
SET deleted = TRUE
WHERE id = :user_id;

UPDATE post
SET deleted = TRUE
WHERE id IN (SELECT post_id FROM question WHERE author_id = :user_id)
   OR id IN (SELECT post_id FROM answer WHERE author_id = :user_id)
   OR id IN (SELECT post_id FROM comment WHERE author_id = :user_id);

COMMIT;