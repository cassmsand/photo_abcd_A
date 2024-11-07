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
                    <img class='img-fluid' src="images/about/samp3.jpg" alt="team image">
                </div>
                <div class="container">
                    <div class="about-header">
                        <h1>Issac Conner</h1>
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

            <div class="container about-bar" id="right">
                <div class="container">
                    <div class="about-header">
                        <h1>Bridget Everett</h1>
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
                <div class="container image-container">
                    <img class='img-fluid' src="images/about/samp4.jpg" alt="team image">
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