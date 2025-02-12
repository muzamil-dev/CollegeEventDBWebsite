## Term Project  
**COP 4710, Spring 2025**  
**Application: College Event Website**  

### Problem:  
Most universities in the country host events around campus and off campus. These events are organized by college students in most cases. Students are clustered into RSOs (Registered Student Organizations) by different organizations, clubs, and fraternities around campus. These events could be of different types: social, fundraising, tech talks, etc.  

Now, each university has a website where they post their events for the upcoming weeks. One needs to check the website to add each event to his/her calendar. These events are just official events and not all events around the university are included. Another limitation is that one has no way to track weekly events.  

### Project Description  
You are asked to implement a web-based application that solves these problems. Any student (user) may register with the application to obtain a user ID and a password. There are three user levels:  

- **Super Admin**: Creates a profile for a university (name, location, description, number of students, pictures, etc.).  
- **Admin**: Owns an RSO and may host events.  
- **Student**: Uses the application to look up information about various events.  

#### Features:
- **Admins** can create events with name, event category, description, time, date, location, contact phone, and contact email address.  
- A **location** should be set from a map (Bing, Google, OpenStreetMap) with name, latitude, longitude, etc.  
- To populate the database, one can use feeds (e.g., RSS, XML) from [events.ucf.edu](https://events.ucf.edu).  
- Each **Admin** is affiliated with one university and one or more RSOs.  
- A user can request to create a new RSO or join an existing one. A new RSO can be created with at least **four other students** with the same email domain (university), e.g., `@knights.ucf.edu`. One of them should be assigned as an administrator.  
- There are different types of events: **social, fundraising, tech talks, etc.**  
- Events can be **public, private, or RSO events**:
  - **Public events** can be seen by everyone.  
  - **Private events** can be seen only by students at the host university.  
  - **RSO events** can only be seen by members of the RSO.  
- **Public events** (not associated with an RSO) must be approved by the Super Admin.  
- After an event is published, users can **add, remove, and edit their comments**, as well as **rate the event** on a scale of **1-5 stars**.  
- The application should offer **social network integration**, e.g., posting from the application to Facebook or Google.  

#### User Roles:
- **Logged-in Students** can view all public events, private events at their university, and events of RSOs they are members of.  
- **Students cannot create events**, but they **can rate, comment, and edit (update) their comments** for any event.  

---

## To Be Provided:  
To help students design and implement the project properly, the following materials will be provided:  
1. A discussion of **candidate keys** for the entity **Event**.  
2. A **trigger** to enforce the constraint:  
   - **“The activation of an RSO requires at least five members”** (SQL-based).  
   - The provided code may need to be modified to work with different DBMSs.  
   - An example of this trigger that works on **MySQL (PHP-based)** will be given.  

---

## Technical Requirements:  

1. **Database Design Process**:  
   - Business operations/constraints  
   - ER-model  
   - Relational model  
   - Normalization  
   - Implementation  
   - Indexing  
   - Enforcing general constraints (e.g., triggers)  

2. The **database must include at least 5 relational tables**.  
3. The application must have a **browser-based interface** and be deployable on the internet.  
4. The website and database must support **multiple concurrent users**.  
5. **Sample data must be included**, such as:
   - 10 users  
   - 5 RSOs  
   - 20 events  
   - 10 comments  
   - 10 SQL queries  
6. **Allowed Programming Languages**:  
   - HTML, JavaScript, PHP, Java, CSS, C#  
   - Stored procedures  
   - **DBMSs**: Oracle, SQL Server, and MySQL  
   - Other languages and DBMSs are generally allowed, but **SQL design and implementation is mandatory**.  
7. All constraints must be enforced **using the database’s features** (e.g., triggers).  
8. **Advanced features** (optional but encouraged):
   - Event feeds from university event systems (e.g., [events.ucf.edu](https://events.ucf.edu))  
   - Social network integration  
   - Crash recovery policy/procedures  
   - Security features  
   - Index-only/composite search-key indices  

---

## Grading:  
- **Demo**: 50%  
- **Report**: 50%  

---

## Deliverables:  

- **Due Dates**: TBA  
- **Draft Design**:  
  - ER diagram (example design may be given and modified for use)  
  - Relational schemas  
  - Constraints enforcement (example code provided, modifications allowed)  

- **Final Report**:  
  - ER diagram  
  - Relational schemas  
  - Database creation code (`CREATE TABLE ...`, `INSERT ...`, `SELECT ...`, etc.)  
  - Software code (GUI, embedded SQL statements, etc.)  
  - Screenshots of interface and output  
  - Comments, observations, and lessons learned  

- **Demo**:  
  - Presentation to GTA via **Zoom** or **in-person**.  

- **Submission**:  
  - **One compressed file (.zip) submitted via Webcourses** containing:  
    - All files and source code  
    - The final report  

---

### **Note:**  
The instructor reserves the right to **modify** (add/drop) technical requirements, due dates, and grading weights. Additional relevant information such as **general constraint enforcement code** may be provided if necessary. **All changes will be announced via Webcourses.**  
