<?php
$CURRENT_PAGE = "About";
include_once("includes/db-conn.php");
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<?php include("includes/head-tag-contents.php");?>

<head>
    <link rel="stylesheet" href="css/about.css">
</head>

<body>
    <?php include("includes/top-bar.php");?>
    <section>
        <div class="container" id='main-body'>

            <div class="container about-bar row align-items-start" id="left">
                <div class="col-3">
                    <div class="container image-container">
                        <img class='img-fluid' src="images/about/cassie.jpg" alt="team image">
                    </div>
                </div>
                
                
                <div class="col-9">
                    <div class="container row">
                        <div class="about-header">
                            <h1 id="left">Cassie Sand</h1>
                        </div>

                        <div class="container about-content">
                            <p>
                                Cassie Sand was raised in Lakeville, Minnesota. After graduating from Lakeville North High School, she attended Simpson College located in Indianola, Iowa.
                                While in Iowa, she completed a double major in Business Management and Theatre Arts, graduating in 2020.
                                Upon entering the workforce, she chose to complete a second bachelors degree to pursue a career in software development.
                                She will be graduating in December 2024 with a Bachelor of Science degree in Computer Science from Metroplitan State University.
                                Her well-rounded background has proven essential to developing new creative solutions.
                            </p>
                        </div>
                    </div>
                </div>
                
            </div>

            <div class="container about-bar" id="left">
                <div class="container">

                    <div class="about-header">
                        <h1>Samuel Goergen</h1>
                    </div>
                    <div class="container about-content">
                        <p>
                            Sam is originally from Plymouth, Minnesota. After high school, he excelled in a sales career, generating around one million dollars in annual revenue for five consecutive years.
                            More recently, he's pivoted to software engineering, captivated by its potential to transform business and interactions.
                            In his free time, he likes to indulge in golf and frisbee golf, stay fit with weightlifting, and relax by watching football.
                            His passion for achievement shines through in everything he does, from coding to sports.
                        </p>
                    </div>
                </div>
                <div class="container image-container">
                    <img class='img-fluid' src="images/about/sam.jpg" alt="team image">
                </div>
            </div>

            <div class="container about-bar" id="left">
                <div class="container image-container">
                    <img class='img-fluid' src="images/about/justin.jpg" alt="team image">
                </div>
                <div class="container">
                    <div class="about-header">
                        <h1>Justin Her</h1>
                    </div>
                    <div class="container about-content">
                        <p>
                            Justin is a Minnesota native with a long standing relationship with computers and technology since his youth. As such,
                            after graduating from Eastern Gateway Community College in 2021, he sought to attain a Bachelor's Degree in Computer Science
                            and is set to graduate from Metropolitan State University in December, 2024. He is a member of Metrostate's Hmong Student 
                            Organization, and has participated in various activities with other student organizations. He is an avid PC gamer with experience
                            in game development (Unity) and modding. His prefrontal cortex is underdeveloped and given that no one is actually going to 
                            fact check this statement, this should be taken as factually, ethically, and metaphysically true unless corrected otherwise.
                        </p>
                    </div>
                </div>
            </div>

            <div class="container about-bar" id="right">
                <div class="container">
                    <div class="about-header">
                        <h1>Ryan Her</h1>
                    </div>
                    <div class="container about-content">
                        <p>
                            Ryan was born and raised in Saint Paul, Minnesota. He attended Blaine High School and graduated in 2019. Ryan attended Anoka Ramsey Community College and
                            then transferred to Metropolitan State University, majoring in Computer Science and is set to graduate in December 2024 with his Bachelors. In his free time
                            Ryan enjoys training in Muay Thai and watching Vikings football. Ryan has successfully completed a Software Engineering Internship with Securian Financial and aims 
                            to continue on this career path in tech.
                        </p>
                    </div>
                </div>
                <div class="container image-container">
                    <img class='img-fluid' src="images/about/ryanH.png" alt="team image">
                </div>
            </div>

            <div class="container about-bar" id="left">
                <div class="container image-container">
                    <img class='img-fluid' src="images/about/samp5.jpg" alt="team image">
                </div>

                <div class="container">
                    <div class="about-header">
                        <h1>Darryl Mathews</h1>
                    </div>
                    <div class="container about-content">
                        <p>
                            Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an
                            unknown
                            printer took a galley of type and scrambled it to make a type specimen book. It has survived
                            not only five centuries, but also the leap into electronic typesetting, remaining
                            essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets
                            containing Lorem Ipsum passages, and more recently with desktop publishing software like
                            Aldus PageMaker including versions of Lorem Ipsum.
                        </p>
                    </div>
                </div>
            </div>

        </div>
    </section>
    <?php include("includes/footer.php");?>
</body>

</html>