# calendar
Test task
To launch app:
Set your DB-connection config at file "calendar/app/DB.php":
    private $_host = "localhost";
    private $_username = "mysql";
    private $_password = "mysql";
    private $_database = "calendar";
Use "calendar.sql file" to upload MYSQL DB
You can:
  - Authorize as admin (nick: admin, pass: admin) or user (nick: user, pass: user)
  - Logout
  - "Add new event" button'll show form for adding events
  - Drag and drop any event to any other slot (except slots without date)
  - "Save changes" button'll send current location of events on scheduler
  - "Next month" button'll download and show calendar of next month with planned events
  - Moving mouse on one of events'll show information about this event (time, author, etc). Also here have to be "edition field" for administrator (not implemented yet)
A few bugs:
  - "Welcome" field and "Enter" button I forgot to make asynchronous and you have to refresh page so app can check new cookies
  - New location of events will be saved only for first shown month (I'v finished logic, but it was too late to share it with each month)
