# EAP: Architecture Specification and Prototype

 Our project aims to redefine what it means to be online and have questions. Our goal is to ensure that every user feels comfortable asking questions and confident that they will receive fast and constructive answers in a friendly environment. We will have a rating system to ensure only the best and most helpful answers according to the community get to the top.

---

## **A7: Web Resources Specification**

This artefact documents the architecture of the **4NSWERS** web application, detailing the catalog of web resources, their properties, and the format of JSON responses. This specification adheres to the OpenAPI standard using YAML.  
It includes CRUD (Create, Read, Update, Delete) operations for each resource implemented in the vertical prototype.

---

### **1. Overview**

An overview of the complete web application is presented, identifying the modules and their corresponding functionalities. The detailed web resources are included in the OpenAPI specification for each module.

#### **Modules**
- **M01: Authentication**  
  Manages user authentication, including registration, login, and logout processes. Provides secure access control to restricted features.

- **M02: Home and Navigation**  
  Organizes navigation across the application, offering pages like home, popular questions, urgent questions, new questions, personalized recommendations, and a Hall of Fame.

- **M03: Questions Management**  
  Enables users to create, view, edit, delete, and vote on questions. Questions serve as the central content type in the application.

- **M04: Answers Management**  
  Supports adding, editing, and deleting answers for questions. Includes features to vote on answers (aura votes) and track their impact.

- **M05: User Profiles**  
  Allows users to manage their profiles, including viewing profile details, editing personal information, and updating passwords.

- **M06: Search**  
  Provides search functionality to locate questions based on titles or body content, streamlining the discovery process for users.

- **M07: Voting System**  
  Includes the mechanisms for voting on both questions (yeah votes) and answers (aura votes), allowing users to interact with content.


---

### **2. Permissions**

The permissions define the conditions of access to resources based on the user’s role.

|**Identifier**| **Code** | **Role**                     | **Description**                                           |
|------|----------|------------------------------|-----------------------------------------------------------|
|**P1**| **PUB**  | Public                       | Guests without authentication. View-only permissions.     |
|**P2**| **USR**  | Authenticated User           | Registered users with privileges to interact with resources. |
|**P3**| **OWN**  | Owner                        | Users who own specific resources, e.g., their profile, posts. |
|**P4**| **ADM**  | Administrator                | System administrators with full control over resources.    |

### **3. OpenAPI Specification**


**Link to the OpenAPI file**: [a7_openapi.yaml](https://gitlab.up.pt/lbaw/lbaw2425/lbaw24112/-/blob/main/a7_openapi.yaml?ref_type=heads)

Here is an excerpt of the OpenAPI specification.

```yaml
openapi: 3.0.0
info:
  title: 4NSWERS API
  description: Comprehensive API for the collaborative Q&A platform "4NSWERS".
  version: 1.0.0
servers:
  - url: http://127.0.0.1:8000
    description: Local Development Server

tags:
  - name: "M01: Authentication"
  - name: "M02: Home and Navigation"
  - name: "M03: Questions Management"
  - name: "M04: Answers Management"
  - name: "M05: User Profiles"
  - name: "M06: Search"
  - name: "M07: Voting System"

paths:

  /login:
    get:
      summary: "Login Form"
      description: "Provide login form. Access: PUB"
      tags:
        - "M01: Authentication"
      responses:
        '200':
          description: "OK. Show Login UI"
    post:
      summary: "Login Action"
      description: "Process the login form. Access: PUB"
      tags:
        - "M01: Authentication"
      requestBody:
        required: true
        content:
          application/x-www-form-urlencoded:
            schema:
              type: object
              properties:
                email:
                  type: string
                password:
                  type: string
              required:
                - email
                - password
      responses:
        '302':
          description: "Redirect after login."
          headers:
            Location:
              schema:
                type: string

```

---


## A8: Vertical prototype

This artefact specifies the work done in the vertical prototype, including the implemented features, web resources, and the prototype itself.

### 1. Implemented Features

#### 1.1. Implemented User Stories

##### 1.1.1 High Priority

| **ID**  | **Name**                               | **Priority** | **Responsible**  |**Description**                                                                                                                              |
|---------|----------------------------------------|--------------|------------------|---------------------------------------------------------------------------------------------------------------------------------------------|
| US01    | Read a Question and respective Answers | High         | Afonso Castro     | As a Person, I want to read questions so that I can get answers to my doubts without having to create an account.                           | 
| US02    | Create an account                      | High         | Leonor Couto | As a Person, I want to be able to create an account so I can log in.                                                                        |
| US03    | Sign in                                | High         | Leonor Couto     | As a Person, I want to be able to sign in to my account so I can be identified.                                                             |
| US04    | Read Most Voted Questions              | High         | Pedro Santos | As a Person, I want to find the most voted questions so that I can find the most relevant and important ones first.                         |
| US12    | Create an account                      | High         | Leonor Couto | As a Guest, I want to be able to create an account so I can log in.                                                                        |
| US13    | Sign in                                | High         | Leonor Couto     | As a Guest, I want to be able to sign in to my account so I can be identified.                                                             |
| US14    | Log out                           | High         | Leonor Couto | As a User, I want to be able to log out so other people using the device don't use my account.                                      |
| US15    | Edit Profile                      | High       | Leonor Couto     | As a User, I want to be able to edit my profile so I can change my information.                                                      |  
| US16    | View Personal Feed                | High      | Pedro Santos    | As a User, I want to view my personal feed so I can see the questions and answers that are relevant to me.                          |
| US17    | Post a Question                   | High         | Leonor Couto    | As a User, I want to post a question so that others can provide answers to my query.                                                       |
| US18    | Respond to Question               | High         | Afonso Castro     | As a User, I want to be able to answer to questions that interest me so I can give my input.                                                                                             |
| US19    | View My Questions                 | High         | Leonor Couto     | As a User, I want to view my questions so I can see the answers and comments they received.                                      |
| US20    | View My Answers                   | High         | Leonor Couto     | As a User, I want to view my answers so I can see the votes and comments they received.                                          |
| US32    | Set a Time Limit for Question      | High         | Rodrigo de Sousa     | As a Poster, I want to set a time limit for how long answers can be submitted to my question so the question closed when not needed anymore. |
| US33    | Edit own Question                  | High       | Leonor Couto     | As a Poster, I want to be able to edit my question after having already posted it so that I can fix my question.                              |
| US34    | Delete its own Question            | High       | Leonor Couto    | As a Poster, I want to be able to delete my question so I can remove it if it is no longer relevant or was posted by mistake.                |
| US39    | Edit own Answer                | High       | Leonor Couto     | As a Responder, I want to be able to edit  my answer, so that I can make sure I get my point across clearly and can help.                                                                     |
| US40    | Delete own Answer              | High       | Leonor Couto | As a Responder, I want to be able to delete my answer, so that I can avoid duplicates or wrong answers.                                                                                |
| US43    | Vote on Content             | High         | Pedro Santos     | As a Responder, I want to get notifications on the votes I get, so that I am aware of my aura.                           |

##### 1.1.2 Medium Priority

| **ID**  | **Name**                               | **Priority** | **Responsible**  |**Description**                                                                                                                              |
|---------|----------------------------------------|--------------|------------------|---------------------------------------------------------------------------------------------------------------------------------------------|
| US06    | Search for Questions                   | Medium       | Rodrigo de Sousa    | As a Person, I want to search for questions similar to mine that have already been answered so I can find other answers to similar problems.|
| US09    | View Recently Asked Questions          | Medium       | Pedro Santos | As a Person, I want to see the recently asked questions so that I can help others with urgent questions.                                    |
| US10    | View Question Details                  | Medium       | Afonso Castro    | As a Person, I want to view the details of a question so that I can understand the context and provide a better answer.                     |
| US22    | Vote on Questions            | Medium         | Afonso Castro     | As a User, I want to vote on questions so that I can help the community to find the most relevant questions.                                                                                   |
| US25    | View Closed Questions             | Medium       | Rodrigo de Sousa    | As a User, I want to be able to view closed question feeds so I can learn from past discussions.                                    |                                          |  
| US28    | Manage Posts                      | Medium       | Leonor Couto     | As a User, I want to be able to edit and delete my old posts, answers and comments, so they are not public anymore.                 |
| US29    | Change Password                   | Medium       | Leonor Couto     | As a User, I want to be able to change my password so I can ensure the security of my account.                                      | 
| US30    | Add and Change the Profile Picture | Medium       | Leonor Couto | As a User, I want to be able to add and change my profile picture so I can personalize my account and make it easily recognisable.   |  
| US36    | Earn points                        | Medium       | Afonso Castro    | As a Poster, I want to earn some points if my question is popular so I go up in the rankings.                                                |
| US41    | See if Answer is Marked USEFUL | Medium         | Afonso Castro    | As a Responder, I want to see if my answer has been marked USEFUL by the poster, so I know if I have successfully helped the poster.                                                          |
| US42    | Earning points                 | Medium       | Afonso Castro | As a Responder, I want to earn points if I'm one the top 4 best answers and/or if the poster marks my answer as USEFUL so that I can increase my chances of being in the top 16 hall of fame. |



#### 1.2. Implemented Web Resources


### **Module M01: Authentication**

| Web Resource Reference | URL               |
| ----------------------- | ----------------- |
| R01: Login Form         | `/login`          |
| R02: Login Submit       | `/login`          |
| R03: Logout             | `/logout`         |
| R04: Registration Form  | `/register`       |
| R05: Registration Submit| `/register`       |


### **Module M02: Home and Navigation**

| Web Resource Reference | URL               |
| ----------------------- | ----------------- |
| R06: Home Page          | `/`               |
| R07: Popular Questions  | `/popular`        |
| R08: Urgent Questions   | `/urgent`         |
| R09: New Questions      | `/new`            |
| R10: For You Page       | `/foryou`         |
| R11: Hall of Fame Page  | `/hall-of-fame`   |


### **Module M03: Questions**

| Web Resource Reference   | URL                                |
| ------------------------- | ---------------------------------- |
| R12: View Question        | `/questions/{id}`                 |
| R13: Edit Question Form   | `/questions/{id}/edit`            |
| R14: Update Question      | `/questions/{id}/update`          |
| R15: Delete Question      | `/questions/{id}/delete`          |
| R16: New Question Form    | `/new-question`                   |
| R17: Submit New Question  | `/new-question`                   |
| R18: Upvote Question      | `/questions/{id}/vote`            |


### **Module M04: Answers**

| Web Resource Reference   | URL                                |
| ------------------------- | ---------------------------------- |
| R19: Post Answer          | `/answers`                        |
| R20: Edit Answer Form     | `/answers/{id}/edit`              |
| R21: Update Answer        | `/answers/{id}/update`            |
| R22: Delete Answer        | `/answers/{id}/delete`            |
| R23: Aura Vote Answer     | `/answer/{answerId}/vote`         |


### **Module M05: User Profiles**

| Web Resource Reference     | URL                           |
| --------------------------- | ----------------------------- |
| R24: View Profile           | `/profile`                   |
| R25: Edit Profile Form      | `/edit-profile`              |
| R26: Submit Profile Updates | `/edit-profile`              |
| R27: Edit Password Form     | `/edit-password-profile`     |
| R28: Submit Password Updates| `/edit-password-profile`     |

### **Module M06: Search**

| Web Resource Reference | URL       |
| ----------------------- | --------- |
| R29: Search Questions   | `/search` |


### **Module M07: Voting System**

| Web Resource Reference | URL                |
| ----------------------- | ------------------ |
| R30: Vote on an Answer  | `/vote`            |
| R31: Remove Vote        | `/vote/{id}`       |

--- 

### 2. Prototype

#### Instructions to run the project

Login to docker registry:
```
docker login gitlab.up.pt:5050
```

Run to start the docker containers:
```
docker run -d --name lbaw24112 -p 8001:80 gitlab.up.pt:5050/lbaw/lbaw2425/lbaw24112
```

Run to update the closed questions:
```
docker exec -it lbaw24112 php /var/www/artisan schedule:run
```

Open in browser:
```
http://localhost:8001
```

#### Credentials to login
```
Email: leonoremail@fake.com
Password: password123
```
#### Link to source code

The source code of our project is [here](https://gitlab.up.pt/lbaw/lbaw2425/lbaw24112/-/tree/eap?ref_type=tags)


---


## Revision history

Changes made to the first submission:
1. 

***
GROUP112, 26/11/2024

* Afonso Castro, up202208026@up.pt
* Leonor Couto, up202205796@up.pt
* Pedro Santos, up202205900@up.pt
* Rodrigo de Sousa, up202205751@up.pt (editor)