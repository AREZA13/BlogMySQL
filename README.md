# BlogMySQL
My first test blog without framework. PHP & MySQL

<h2 tabindex="-1" dir="auto">Installation and launch </h2>
<li>Using the terminal, go to the empty folder where you plan to place the project </li>
<li><code> git clone https://github.com/AREZA13/BlogMySQL.git </code>  or <code> git clone git@github.com:AREZA13/BlogMySQL.git </code></li>
<li><code> composer install </code> If composer is not installed on the system, we achieve execution of this command in another way </li>
<li>In the root folder, copy the .env.example file as a new file called .env (no need to change anything) </li>
<li><code> sudo chmod -R 777 logs/ </code></li>
<li><code> docker compose up -d </code></li>
<li> The site is available at the link: http://localhost:55000/  </li>


<h2 tabindex="-1" dir="auto"> Usage </h2>
<li> When you start Docker, the base is installed, with several articles for example </li>
<li> The main page displays a list of articles </li>
<li> When you click on the title of an article, a list of all articles opens </li>
<li> Registration is available. To register, just specify your username and password </li>
<li> Authorization available. Authorized users can log in by entering their username and password </li>
<li> Authorized users can publish, edit, and delete articles </li>
<li> Based on Bootstrap 5 </li>

<em> Example of a home page for an authorized user </em>

<img width="1656" alt="Screenshot 2023-11-20 at 1 39 20 PM" src="https://github.com/AREZA13/BlogMySQL/assets/88317106/29a3c57d-0e76-4730-8792-c043d5a5aaa7">

