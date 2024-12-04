# ER: Requirements Specification Component

 Our project aims to redefine what it means to be online and have questions. Our goal is to ensure that every user feels comfortable asking questions and confident that they will receive fast and constructive answers in a friendly environment. We will have a rating system to ensure only the best and most helpful answers according to the community get to the top.
 

## A1: 4NSWERS

 As Learners, we often have questions that need answers as fast as possible. So we decided to create a Collaborative Q&A Content Rated Forum Website adapted for those situations.
 
 In this website, the user can post their questions or doubts about a certain topic, marking the post with the appropriate tags, and other users can respond with what they think is the best answer to the current problem. To be able to do that, an account must be created. If not, the guest can only see the questions and responses, but cannot partake in the post's action.

 As those various answers start stacking up on a certain post, they are positively or negatively voted by all the users, affecting the answers' order of appearance (meaning the most publicly supported answers appear at the top).

 The website contains a points system (gamification).
 The responders with the top 4 answers on a certain post according to the votes, and the responder that has had its answer marked as USEFUL by the poster, receive reward points. The poster also receives a certain amount of points depending on how popular the question was.

 The top 16 users with the most points are shown in a special 'Hall of Fame' ranking in the website.

 Users can make comments on other responders' answers, and can search for specific question posts and users.
 
 Knowing that the website encourages a fast answer delivery mentality, all questions are open only during a predetermined amount of time (up to a maximum of 48 hours) selected by the poster.

 In the feed, all active posts are shown and can be ordered by newest, most urgent (those whose timer is running out) and hottest (most positive votes). Users can also filter the feed to only show posts with their 'followed' tags.
 
 The question closes when time runs out, or when the poster declares one of the answers as USEFUL.
 
 After its closure, the post will remain up for users to read it, despite them being now blocked from posting new answers and voting on existing ones.

 During the entirety of this process, a Moderator may appear and provide an analysis of the answer(s), alerting the community for the existence of an incorrect answer with alerts, independently if the original poster declared that answer as USEFUL or not.

 The probability of a post receiving a Moderator's analysis is higher on posts that are having more user interactions (trending), or when a significant amount of users have reported a certain question, answer or comment.
 
 Responders that have had their answers flagged by a Moderator's Alert, may lose a certain amount of points, that amount depending on the type of the Alert. The same applies to posters with flagged questions.

 A user can acquire the title of moderator for a tag after earning a specific number of points and providing a certain number of correct answers to posts associated with said tag.


 The central motivation behind this project is to find a way to reduce the frustration of not having someone to ask about an important and/or urgent question or doubt. Our project helps by having multiple users engaged to answer our questions the best way they can.



## A2: Actors and User stories

The goal for this artefact is to define how users will interact with our website. It also serves as a guideline for features.


### 1. Actors

![Actors](https://gitlab.up.pt/lbaw/lbaw2425/lbaw24112/raw/main/wiki/docs/ER/UML/actors.png?ref_type=heads)

**Table of Actors**

| **Actor**       | **Description**                                                                                                                           |
|-----------------|-------------------------------------------------------------------------------------------------------------------------------------------|
| Person          | Any individual that accesses the platform.                                                                                                |
| Guest           | A non-authenticated user that can read questions and answers.                                                                             |
| User            | Any individual that can post questions, answer questions, vote, and comment on answers.                                                   |
| Poster          | A user who posts a question and selects a timeframe during which answers can be submitted, and can eventually declare one of them USEFUL. |
| Responder       | A user who answers questions and contributes to discussions by commenting on other answers.                                               |
| Voter           | A user who votes on the validity or quality of answers to help promote the best ones.                                                     |
| Moderator       | A user responsible for flagging harmful or incorrect answers (ALERTS) and moderating users in its community.                              |
| Admin           | An individual that has been chosen to have absolute control over the platform.                                                            |


### 2. User Stories

#### 2.1 Actor 1: Person

| **ID**  | **Name**                               | **Priority** | **Responsible**  |**Description**                                                                                                                              |
|---------|----------------------------------------|--------------|------------------|---------------------------------------------------------------------------------------------------------------------------------------------|
| US01    | Read a Question and respective Answers | High         | Pedro Santos     | As a Person, I want to read questions so that I can get answers to my doubts without having to create an account.                           | 
| US02    | Create an account                      | High         | Rodrigo de Sousa | As a Person, I want to be able to create an account so I can log in.                                                                        |
| US03    | Sign in                                | High         | Leonor Couto     | As a Person, I want to be able to sign in to my account so I can be identified.                                                             |
| US04    | Read Most Voted Questions              | High         | Rodrigo de Sousa | As a Person, I want to find the most voted questions so that I can find the most relevant and important ones first.                         |
| US05    | Filter Questions by Tag                | Medium       | Pedro Santos     | As a Person, I want to filter questions by tag so that I can get only the questions that match my specific interests.                       | 
| US06    | Search for Questions                   | Medium       | Afonso Castro    | As a Person, I want to search for questions similar to mine that have already been answered so I can find other answers to similar problems.|
| US07    | Search for Users                       | Medium       | Pedro Santos     | As a Person, I want to search for other users so I can check their profile.                                                                 |
| US08    | View User Profile                      | Medium       | Leonor Couto     | As a Person, I want to view a user's profile so that I can know more about the user.                                                        | 
| US09    | View Recently Asked Questions          | Medium       | Rodrigo de Sousa | As a Person, I want to see the recently asked questions so that I can help others with urgent questions.                                    |
| US10    | View Question Details                  | Medium       | Afonso Castro    | As a Person, I want to view the details of a question so that I can understand the context and provide a better answer.                     |
| US11    | See Contacts                           | Medium       | Pedro Santos     | As a Person, I want to know the contacts and informations about the site before I start using it, so that I can get help if I need.         |

#### 2.2. Actor 2: Guest

| **ID**  | **Name**                               | **Priority** | **Responsible**  |**Description**                                                                                                                             |
|---------|----------------------------------------|--------------|------------------|--------------------------------------------------------------------------------------------------------------------------------------------|
| US12    | Create an account                      | High         | Rodrigo de Sousa | As a Guest, I want to be able to create an account so I can log in.                                                                        |
| US13    | Sign in                                | High         | Leonor Couto     | As a Guest, I want to be able to sign in to my account so I can be identified.                                                             |

#### 2.3. Actor 3: User

| **ID**  | **Name**                          | **Priority** | **Responsible**  |**Description**                                                                                                                      |
|---------|-----------------------------------|--------------|------------------|-------------------------------------------------------------------------------------------------------------------------------------|
| US14    | Log out                           | High         | Rodrigo de Sousa | As a User, I want to be able to log out so other people using the device don't use my account.                                      |
| US15    | Edit Profile                      | High       | Pedro Santos     | As a User, I want to be able to edit my profile so I can change my information.                                                      |  
| US16    | View Personal Feed                | High      | Afonso Castro    | As a User, I want to view my personal feed so I can see the questions and answers that are relevant to me.                          |
| US17    | Post a Question                   | High         | Afonso Castro    | As a User, I want to post a question so that others can provide answers to my query.                                                       |
| US18    | Respond to Question               | High         | Pedro Santos     | As a User, I want to be able to answer to questions that interest me so I can give my input.                                                                                             |
| US19    | View My Questions                 | High         | Leonor Couto     | As a User, I want to view my questions so I can see the answers and comments they received.                                      |
| US20    | View My Answers                   | High         | Pedro Santos     | As a User, I want to view my answers so I can see the votes and comments they received.                                          |
| US21    | Comment on Responses              | Medium         | Afonso Castro    | As a User, I want to be able to comment on any post's responses, so I can complete them with any information I think is relevant. |
| US22    | Vote on Questions            | Medium         | Leonor Couto     | As a User, I want to vote on questions so that I can help the community to find the most relevant questions.                                                                                   |
| US23    | View Answer Rankings        | Medium       | Leonor Couto     | As a User, I want to see how answers rank based on community votes so that I can check the most popular answers.                                                                          |
| US24    | Follow Tags                       | Medium         | Leonor Couto     | As a User, I want to subscribe to tags, so that I can get questions that I am interested in on my feed.                             |
| US25    | View Closed Questions             | Medium       | Afonso Castro    | As a User, I want to be able to view closed question feeds so I can learn from past discussions.                                    |
| US26    | Report a Question/Answer          | Medium       | Leonor Couto     | As a User, I want to be able to report Question/Answer that seem harmful or misjudged so that moderators can review the Question/Answer. |
| US27    | Delete Profile                     | Medium       | Rodrigo de Sousa | As a User, I want to be able to delete my profile so I don't have an account anymore.                                                |  
| US28    | Manage Posts                      | Medium       | Leonor Couto     | As a User, I want to be able to edit and delete my old posts, answers and comments, so they are not public anymore.                 |
| US29    | Change Password                   | Medium       | Leonor Couto     | As a User, I want to be able to change my password so I can ensure the security of my account.                                      | 
| US30    | Add and Change the Profile Picture | Medium       | Rodrigo de Sousa | As a User, I want to be able to add and change my profile picture so I can personalize my account and make it easily recognisable.   |  
| US31    | Follow Questions                  | Medium       | Pedro Santos     | As a User, I want to follow my favourite questions so I can receive updates and stay informed about new answers.                     |


#### 2.4. Actor 4: Poster

| **ID**  | **Name**                           | **Priority** | **Responsible**  |**Description**                                                                                                                               |
|---------|------------------------------------|--------------|------------------|----------------------------------------------------------------------------------------------------------------------------------------------|
| US32    | Set a Time Limit for Question      | High         | Leonor Couto     | As a Poster, I want to set a time limit for how long answers can be submitted to my question so the question closed when not needed anymore. |
| US33    | Edit own Question                  | High       | Pedro Santos     | As a Poster, I want to be able to edit my question after having already posted it so that I can fix my question.                              |
| US34    | Delete its own Question            | High       | Afonso Castro    | As a Poster, I want to be able to delete my question so I can remove it if it is no longer relevant or was posted by mistake.                |
| US35    | Close Question by Selecting Answer | Medium       | Rodrigo de Sousa | As a Poster, I want to close my question when I have received a satisfactory answer so no one else can answer.                               |
| US36    | Earn points                        | Medium       | Afonso Castro    | As a Poster, I want to earn some points if my question is popular so I go up in the rankings.                                                |

| US37    | Edit Tags                          | Medium       | Leonor Couto     | As a Poster, I want to edit my tags after posting a question, so that I can make sure the question fits the correct tags.                     |
| US38    | Answer to Question          | Medium         | Rodrigo de Sousa | As a Poster, I want to get notifications on the answers users send me, so that I can get my answers.                  |

#### 2.5. Actor 5: Responder

| **ID**  | **Name**                       | **Priority** | **Responsible**  |**Description**                                                                                                                                                                                |
|---------|--------------------------------|--------------|------------------|-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| US39    | Edit own Answer                | High       | Pedro Santos     | As a Responder, I want to be able to edit  my answer, so that I can make sure I get my point across clearly and can help.                                                                     |
| US40    | Delete own Answer              | High       | Rodrigo de Sousa | As a Responder, I want to be able to delete my answer, so that I can avoid duplicates or wrong answers.                                                                                       |
| US41    | See if Answer is Marked USEFUL | Medium         | Afonso Castro    | As a Responder, I want to see if my answer has been marked USEFUL by the poster, so I know if I have successfully helped the poster.                                                          |
| US42    | Earning points                 | Medium       | Rodrigo de Sousa | As a Responder, I want to earn points if I'm one the top 4 best answers and/or if the poster marks my answer as USEFUL so that I can increase my chances of being in the top 16 hall of fame. |
| US43    | Vote on Content             | High         | Pedro Santos     | As a Responder, I want to get notifications on the votes I get, so that I am aware of my aura.                           |

#### 2.6. Actor 6: Commenter

| **ID**  | **Name**                    | **Priority** | **Responsible**  |**Description**                                                                                                                         |
|---------|-----------------------------|--------------|------------------|----------------------------------------------------------------------------------------------------------------------------------------|
| US44    | Edit Comment                | Medium       | Leonor Couto     | As a Commenter, I want to edit my comment so I can correct mistakes or update my thoughts.                                             |
| US45    | Delete Comment              | Medium       | Rodrigo de Sousa | As a Commenter, I want to delete my comment so so I can remove it if it is no longer relevant or appropriate.                          |


#### 2.7. Actor 7: Voter

| **ID**  | **Name**                    | **Priority** | **Responsible**  | **Description**                                                                                                                                                                            |
|---------|-----------------------------|--------------|------------------|--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| US46    | Earning points              | Low          | Leonor Couto     | As a Voter, I want to earn some points for voting so that my time reading other people's posts is also rewarded points wise.                                                               |


#### 2.8. Actor 8: Moderator

| **ID**  | **Name**                        | **Priority** | **Responsible**  |**Description**                                                                                                                                                                                                       |
|---------|---------------------------------|--------------|------------------|----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| US48    | Issue Alerts on questions       | Medium         | Leonor Couto     | As a Moderator, I want to issue an alert when an question is found to be inappropriate or irrelevant to the community it was posted in, so that I can give users an experience that is aligned with their expectations. |
| US49    | Issue Alerts on answers         | Medium         | Pedro Santos     | As a Moderator, I want to issue an alert when an answer is found to be incorrect, even if it is marked USEFUL, so that I can inform future readers that the answer might not be correct.                                |
| US50    | Remove Harmful Content          | Medium         | Rodrigo de Sousa | As a Moderator, I want the ability to delete harmful or misleading content so that I can maintain the integrity of the platform.                                                                                        |
| US51    | Moderate users in the community | Medium         | Afonso Castro    | As a Moderator, I want the ability to moderate users in the community, having the ability to alert, and if necessary, to temporarily or permanently ban them so that I keep my community clean.                        |
| US52    | Check reported Answers          | Medium       | Rodrigo de Sousa | As a Moderator, I want to be able to analyse questions and answers that have been reported so that I can keep my community clean.                                                                                       |
| US53    | Edit Question Tags              | Medium       | Afonso Castro    | As a Moderator, I want to be able to edit question tags so I can improve the organisation and discoverability of content.                                                                                               |


#### 2.9. Actor 9. Admin

| **ID**  | **Name**                    | **Priority** | **Responsible**  |**Description**                                                                                                     |
|---------|-----------------------------|--------------|------------------|--------------------------------------------------------------------------------------------------------------------|
| US54    | Manage Tags          | Medium         | Afonso Castro    | As an admin, I want to be able to edit tags, so that I can change offensive content.             |
| US55    | Administrator Accounts          | Medium         | Rodrigo de Sousa | As an admin, I want to create other administrator accounts so that I can delegate tasks.             |
| US56    | Administer Accounts         | Medium         | Leonor Couto     | As an admin, I want to be able to search, create, and edit accounts, so that I can more easily control the platform.             |
| US57    | Block and Unblock Users        | Medium         | Pedro Santos     | As an admin, I want to be able to block and unblock users, so that I can punish users that don't follow the guidelines.             |
| US58    | Delete Users         | Medium         | Afonso Castro    | As an admin, I want to be able to delete users, so that I can remove harmful users.             |

---

### 3. Supplementary Requirements


#### 3.1. Business Rules

| **ID**  | **Name**                            | **Description**                                                                                                                                                     |
|---------|-------------------------------------|---------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| BR1     | Voting Integrity                    | Users can only vote once per answer. A vote may be changed, but not duplicated.                                                                                     |
| BR2     | Editing Integrity                   | Questions and answers edited after being posted should have a clear indication of the editions.                                                                     |
| BR3     | Post Closure Policy                 | Questions will close either when the selected time expires or when the poster marks an answer as USEFUL, whichever occurs first.                                    |
| BR4     | Reporting Answers                   | Users can report an answer they think is harmful or incorrect. After reaching a threshold of reports, the system alerts Admin for review.                           |
| BR5     | User can not auto-answer            | Users can not answer to their own posts, but can comment on other users' answers to their questions.                                                                |
| BR6     | User can not auto-vote              | Users can not vote to their own answers, but can vote on other users' answers to the questions.                                                                     |
| BR7     | Deleted User Contents               | Questions, answers and comments remain even after the user's account elimination, appearing as posted by an deleted account.                                        |
| BR8     | Posting Time Rules                  | The date of posting of an answer/comment must be greater than the question/answer that is responding to.                                                            | 
| BR9     | Editing Time Rules                  | The date of editing of a post (question, answer or comment) must be greater than the original post date.                                                            | 
| BR10    | User badges                         | User badges are dependent on the likes and dislikes received on his questions and answers, and also on actions made by the user (first question, first answer, etc).|


#### 3.2. Technical Requirements

| **ID**   | **Name**                      | **Description**                                                                                                                                                                          |
|----------|-------------------------------|------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| **TR1**  | **Responsive Design**         | **The platform must be accessible on desktop devices.**  Because we want the users to be able to use this regardless of the size of their screen.                                        |
| **TR2**  | **Notification System**       | **Users must receive notifications when someone responds to their question, comments on their answer, or issues an alert.** Because we want the users to be informed as soon as possible.|       
| **TR3**  | **Accessibility**             | **The platform must be accessible to everyone that follows the terms and conditions.** Because we want to receive anyone that promotes a healthy environment in our platform.            |
| TR4      |   Tags                        | Tags will group related questions by topic and theme.                                                                                                                                    |
| TR5      |   Urgency                     | Questions will be identified with the timeframe the question would need to be answered in.                                                                                               |
| TR6      |   Performance                 | The system should have response times shorter than 2s to ensure the user's attention.                                                                                                    |
| TR7      |   Robustness                  | The system must be prepared to handle and continue operating when runtime errors occur.                                                                                                  | 
| TR8      |   Scalability                 | The system must be prepared to deal with the growth in the number of users and their actions.                                                                                            |

#### 3.3. Restrictions

| **ID**  | **Name**                          | **Description**                                                                                                                       |
|---------|-----------------------------------|---------------------------------------------------------------------------------------------------------------------------------------|
| R1      | Anonymous Posting Not Allowed     | Users must be registered and logged in to post questions or answers.                                                                  |
| R2      | Maximum Time Limit for Questions  | A question can remain open for a maximum of 48 hours before it automatically closes.                                                  |
| R3      | Admin Alert Response Time         | Admins must review reported content within 24 hours to ensure swift removal of harmful content or alert activation.                   |


---

### 2. Wireframes

#### 2.1. Home Page

![Home Page](https://gitlab.up.pt/lbaw/lbaw2425/lbaw24112/raw/main/wiki/docs/ER/wireframes/HomePage.png?ref_type=heads)

```
A. -> Search Page UI06
B. -> Post Question Page UI04
C. -> Profile Page UI16
D. -> Question Page UI03 (Clicking will redirect the user to the Question's page)
E. -> Tag Page UI02 (Clicking will redirect the user to a page that lists all questions related to the tag)
F. -> Hall of Fame UI05 (Clicking will redirect the user to the Hall of Fame page)
G. -> Home Page UI01 
```  

#### 2.2. Post Page

![Post Page](https://gitlab.up.pt/lbaw/lbaw2425/lbaw24112/raw/main/wiki/docs/ER/wireframes/PostPage.png?ref_type=heads)

```
A. -> Home Page UI01   
B. -> Question Page UI03 (Clicking will redirect the user to the Question's page)
C. -> Hall of Fame UI05 (Clicking will redirect the user to the Hall of Fame page)
D. -> Profile Page UI16
E. -> Search Page UI06
F. -> Tag Page UI02 (Clicking will redirect the user to a page that lists all questions related to the tag)
```

#### 2.3. Profile Page

![Profile Page](https://gitlab.up.pt/lbaw/lbaw2425/lbaw24112/raw/main/wiki/docs/ER/wireframes/ProfilePage.png?ref_type=heads)

```
A. -> Search Page UI06
B. -> Post Question Page UI04
C. -> Profile Page UI16
D. -> Question Page UI03 (Clicking will redirect the user to the Question's page)
E. -> Tag Page UI02 (Clicking will redirect the user to a page that lists all questions related to the tag)
F. -> Hall of Fame UI05 (Clicking will redirect the user to the Hall of Fame page)
G. -> Main Page UI01   
```


## Revision history

Changes made to the first submission:
1. Update er (fixed BR8 and adding another BR) [2024-10-23]
2. Fixed Sitemap [2024-10-26]
3. Fixing wireframes' descriptions [2024-10-26]
4. Adding more info to wireframes' descriptions [2024-10-26]
5. Created Generic Person actor and Seperated Moderator and Admin actors [2024-10-27]
6. Edited User Stories + 10 User Stories [2024-10-27]

***
GROUP112, 08/10/2024

* Afonso Castro, up202208026@up.pt
* Leonor Couto, up202205796@up.pt
* Pedro Santos, up202205900@up.pt
* Rodrigo de Sousa, up202205751@up.pt (editor)
