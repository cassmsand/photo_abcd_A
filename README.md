A Blogging Collection Dashboard (ABCD)

We are developing a web application called "Photo ABCD".

A. Features&nbsp;


1. Alphabetical and Chronological Blog Compilation:
- Users can compile blogs alphabetically (e.g., "A for Apple," "B for Ball", "Camping Adventures", ).
- Users can also view blogs in chronological order, based on the event date they input.&nbsp; (Older date shows up at the beginning)

2. Blog Post Creation: (can be created only by the registered / logged in users)

Here is the information we manage on each blog post.
- Creator: Email of the admin/user/logged in user creating the blog
- Title: Blog titles must start with a specific letter.
- Description: Users can write descriptions or stories to accompany the photos.
- Photo Upload: Option to upload multiple related photos. If there is no photo upload for a blog, the system will assign "default.png" from the images/default/default.png)
- Date of Event: Users input the event date for chronological sorting.
- Blog Creation Date: The timestamp on which the blog is created is automatically captured.
- Blog Modification Date: The timestamp on which the blog is update is automatically captured.
- Privacy Filter : By default, all the blogs are private. The users can mark the privacy setting to "public".

3. Customizable Alphabet Book:
- Users can create custom "Alphabet Books" by adding blogs for each letter of the alphabet.&nbsp;
- A progress bar to track completion of blogs for all 26 letters.
- A progress bar to show the counts of stories for each alphabet.

4. Chronicle View:
- Blogs can be displayed in a chronological format, similar to a photo timeline or family diary.

5. Search and Filter Options:
- Alphabetical Search: Quickly search for blogs by letter.
- Date Range Filter: Filter blogs based on a specific time frame.

6. Interactive Dashboard:
- (User) A user-friendly dashboard that shows all the blogs created, progress on alphabetical entries, and options for sorting.

- (Admin) A dashboard (fancy report) showing the counts of all the blogs created by all users.

7. Sharing and Collaboration:
- Private Sharing: By default, all the blogs are private.
- Public Display: Option to make specific blogs public if the user chooses.&nbsp;
- Power option: A user may make all his/her blogs public or private




8. Download or Print Feature:
- Users can export or print their entire Alphabet Book or chronological blog collection into a digital format (PDF).
- Note on PDF generation: Generating a HTML compilation (with page breaks) so that users can use browser print button to generate the PDF is acceptable.

9. Home Page -&nbsp; Home or ABCD icon hyperlink:

(As a visitor) The home page of "ABCD" shows all the public blogs sorted in reverse chronological order (latest one created shows up at the top)
(As a visitor) The home page shows the sorting options (by alphabet or chronological order)
(As a visitor) Clicking any Users name (which is displayed on the blog) will show all the blogs created by that particular user (For example: http://localhost/photoabcd/user_1 on localhost;&nbsp; &nbsp; &nbsp; &nbsp;http://www.photoabcd.com/user_x on remotehost)

10. Home Page -&nbsp; My Blogs:

(As a logged in user) My Blogs page shows all the blogs created by the logged in user.&nbsp;
(As a logged in user) My Blogs page shows all the blogs in visually appealing format (as a grid)
(As a logged in user) If the blog owner and logged in user are the same, then user will have edit or delete options on the blog
(As a logged in user) My Blogs page shows the sorting options (by alphabet or chronological order)

11. Administration:

One or more users may be designated as "admin"
By default, all the registered users role is "user".
If the admin user logs in, then "Administration" hyper-link shows up in the tool bar.
"Administration" shows these additional options
users - To show&nbsp; a jquery data table showing all the registered users
blogs&nbsp;- To show&nbsp; a jquery data table showing all the blogs created
reports - A simple table showing the summary of blogs
preferences - A name value pair table to show / edit the preferences of the site

12.Photo only display:

Users (and visitors and admins) may opt to see only photos in chronological order or alphabetical order.
Users are provided an option to see only the photo (by filtering out the text)&nbsp;
The photo should show the "blog title" as its caption.

13. Visual Appeal:

This application is primarily a photo blogger.
The web application must have visual appeal while displaying the blogs and photos.

14.Responsive Design :

Our "Photo ABCD" application is responsive
It must work on browsers, and hand-held devices (such as ipad and iphone)




B. User - System Interaction :
1. Visitor Flow:
http://localhost/photoabcd will show the visitor view of the web application (see #9 above)

2. Registered User Flow (see #10 above)

1. Sign-Up/Login: Easy sign-up process with email and password. (Optional capability: Getting the registration through social media or existing email like gmail).
2. Create a Blog: Choose a letter, write a blog post, add photos, and set the event date.
3. View and Sort: Users can toggle between "Alphabetical" and "Chronological" views.
4. Share: Share the blog with other by setting the privacy flag to 'public'
5. Compile: Automatically compile an Alphabet Book or a timeline of events, with the option to download or print.


3. Admin Flow (See #11 above):
1. Login as admin user
2. Access the 'administration' panel for additional capabilities. Administration" shows additional options (users management, blogs management, reports and summaries, preferences) shown.
3. Admin user is super-admin and he/she can remove the users or blogs as needed.




C. Deployment :
1. localhost:

The application shall work at http://localhost/photoabcd when deployed locally

2. remotehost:

Assumptions should not be taken regarding the name of the remote host project name.

The project may be installed as "photoabcd" or "abcd" or "abcd_photos", etc. So, you should not be referencing the domain name anywhere in your code.

3. bluehost:

The web application shall be deployed to bluehost. Each project team will be empowered to deploy the application to the bluehost. The final demonstrations will happen from the remotehost.

D. Technology:
database: MySQL
Server: PHP&nbsp;
Client: HTML, CSS (Bootstrap), JavaScript, JQuery

You are permitted to use other technology stacks satisfying these two constraints. [1] It should be open source and free [2] It should work on bluehost basic shared hosting option.

E. Tools:
GitHub: for hosting the code
Trello: For managing the project
XAMPP: for developing the web application
bluehost: for hosting the application
