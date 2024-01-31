# DynamicSchoolWebsite
This is the dynamic version of the static school website

This project involves various files, some of which are organized into folders:

- **css Folder:**
  Contains all files for styling each webpage.

- **img Folder:**
  Contains images used for the welcome page and the backToTop button.

- **docs Folder:**
  Contains dummy files used for download on various required pages.

- **phpmailer Folder:**
  Contains files for sending emails to the course instructors. This package has been downloaded ready-made from the internet.

- **Root Directory:**
  All PHP files are included here.

### User Authentication Files:

- **index.php:**
  The main page of the website, prompting users to log in. Handles error messages and ensures valid form input. Initiates a session to transfer user roles to subsequent webpages.

- **authenticate.php:**
  Authenticates the user to ensure they exist in the database.

- **signup.php:**
  Implements the form for user registration, providing appropriate messages for various scenarios.

- **logout.php:**
  Ends the session started with the user login and redirects to the homepage.

### Other PHP Files:

- **navigation.php:**
  Implements the navigation bar on the left side of each page.

- **connect_db.php:**
  Handles the connection to the database, avoiding code repetition.

- **delete_entry.php:**
  Implements the deletion of entries from the database. Accessible only to users with the role of Instructor.

- **welcome.php:**
  Displays the welcome page after successful login.

- **announcements.php:**
  Displays all announcements in the database, allowing instructors to add/edit/delete announcements. Contains a link to the announcement_form.php page.

- **announcement_form.php:**
  Implements the form for adding or editing announcements dynamically.

- **communication.php:**
  Implements the page allowing users to contact instructors either through a web form or via a Gmail link.

- **send_email.php:**
  Handles the functionality of sending emails using PHPMailer.

- **documents.php:**
  Displays lesson documents, allowing instructors to add/edit/delete documents.

- **document_form.php:**
  Implements the form for adding or editing lesson documents dynamically.

- **homework.php:**
  Displays homework assignments, allowing instructors to add/edit/delete assignments.

- **homework_form.php:**
  Implements the form for adding or editing homework assignments dynamically.

- **users.php:**
  Displays a page for instructors to view and manage student users.

- **user_form.php:**
  Implements the form for adding or editing users, accessible only to instructors.

### Database Tables:

- **Announcements Table:**
  Contains announcements with unique IDs, dates, topics, and text.

- **Documents Table:**
  Contains lesson documents with unique IDs, titles, descriptions, and file links.

- **Homework Table:**
  Contains homework assignments with unique IDs, objectives, file links, deliverables, and due dates.

- **Users Table:**
  Contains user information with unique email IDs, names, surnames, passwords, and roles.

### User Access Instructions:

**Instructor:**
- Email: tutor01@example.com
- Password: tutor01

**Students:**
1. Email: student01@test.com
   Password: qwerty
2. Email: student02@example.com
   Password: qwertyu

**Website Link:**
[http://spyridom.webpages.auth.gr/3211partB]
