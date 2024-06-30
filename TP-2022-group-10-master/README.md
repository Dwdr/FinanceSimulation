# CSC2002-Team10 (Team Project)

<a name="readme-top"></a>


<!-- PROJECT LOGO -->
<div align="center">
<h3 align="center">Financial Simulator</h3>
</div>


<!-- TABLE OF CONTENTS -->
<details>
  <summary>Table of Contents</summary>
  <ol>
    <li>
      <a href="#about-the-project">About The Project</a>
      <ul>
        <li><a href="#built-with">Built With</a></li>
      </ul>
    </li>
    <li>
      <a href="#getting-started">Getting Started</a>
      <ul>
        <li><a href="#installation">Installation</a></li>
      </ul>
    </li>
    <li><a href="#database-seeding">Database seeding</a></li>
    <li><a href="#run-server">Run server</a></li>
    <li><a href="#acknowledgements">Acknowledgements</a></li>
  </ol>
</details>


<!-- ABOUT THE PROJECT -->
## About The Project

The project is a dashboard that allows you to visualize financial information about stocks with a sentiment analysis of recent news related to the stock.

The dashboard is created using Laravel framework and uses web crawlers to gather data on the financial market and relevant news.

Future improvements can be made such as improving the simulation program, including new financial values such as mortgage rates and interest rates and including a AI/ML technology to do prediction analysis.


<p align="right">(<a href="#readme-top">back to top</a>)</p>


### Built With
[![Laravel][Laravel.php]][Laravel-url]
[![MySQL][MySQL.sql]][MySQL-url]
[![Visual Studio Code][VisualStudioCode.ms]][VisualStudioCode-url]

<p align="right">(<a href="#readme-top">back to top</a>)</p>


<!-- GETTING STARTED -->
## Getting Started

### Installation
<ol>
  <li>
    Clone the repository

    git clone git@https://github.com/UofG-CS/project-TP-group10.git
  </li>
  <li>
    Install <a href="https://www.apachefriends.org/download.html">XAMPP</a>
      <ul>
        <li>Start MySQL, ProFTFD and Apache Web Server</li>
        <li>Configure MySQL Port number in XAMPP to the preferred port (eg. 3308)</li>
      </ul>
  </li>
  <li>
    Install <a href="https://getcomposer.org/download/">Composer</a>
  </li>
  <li>
    Install <a href="https://nodejs.org/en/download/">node.js</a>
  </li>
  <li>Install dependencies using composer</li>
    <ul>
  <li>
    Goutte

    composer require fabpot/goutte
  </li>
  <li>
    Livewire

    composer require livewire/livewire
  </li>
  <li>
    Guzzle

    composer require guzzlehttp/guzzle:^7.0
  </li>
    </ul>

  <li>
    Copy the example env file and make the required configuration changes in the .env file

    cp .env.example .env
  </li>
</ol>

<p align="right">(<a href="#readme-top">back to top</a>)</p>


<!-- Database seeding-->
## Database seeding
<ol>
  <li> 
    Migrate the csv file into database

    php artisan migrate
  </li>
  <li>
    Run the database seeder and you're done

    php artisan db:seed
  </li>
</ol>

<p align="right">(<a href="#readme-top">back to top</a>)</p>


<!-- Run server -->
## Run server 
  
Run the laravel development server

    php artisan serve

<p align="right">(<a href="#readme-top">back to top</a>)</p>


<!-- ACKNOWLEDGMENTS -->
## Acknowledgements
- Chia Teck Fatt, Reagan <2102539@sit.singaporetech.edu.sg>
- Wong Darren <2101196@sit.singaporetech.edu.sg>
- Enrique Carlos Marcelo <2102740@sit.singaporetech.edu.sg>
- Heng Jun Hao <2101739@sit.singaporetech.edu.sg>
- Kenny Lim Ye Wei <2102764@sit.singaporetech.edu.sg>
- Teo Leng <2102311@sit.singaporetech.edu.sg>

<p align="right">(<a href="#readme-top">back to top</a>)</p>


<!-- MARKDOWN LINKS & IMAGES -->
<!-- https://www.markdownguide.org/basic-syntax/#reference-style-links -->
[Laravel.php]: https://img.shields.io/badge/Laravel-%5E8.0-red?style=for-the-badge&logo=laravel&logoColor=white
[Laravel-url]: https://laravel.com/
[MySQL.sql]: https://img.shields.io/badge/MySQL-005C84?style=for-the-badge&logo=mysql&logoColor=white
[MySQL-url]: https://www.mysql.com/
[VisualStudioCode.ms]: https://img.shields.io/badge/Visual_Studio_Code-0078D4?style=for-the-badge&logo=visual%20studio%20code&logoColor=white
[VisualStudioCode-url]: https://code.visualstudio.com/
