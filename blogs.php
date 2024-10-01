<?php include("includes/a_config.php");?>
<!DOCTYPE html>
<html>
<head>
	<?php include("includes/head-tag-contents.php");?>
</head>
<body>

<?php include("includes/design-top.php");?>
<?php include("includes/navigation.php");?>

<?php $blankIcon = '../photo_abcd_A/images/blankicon.jpg';?>

<div class="container" id="main-content">
	<h1>Blogs</h1>

		<!DOCTYPE html> 
		<html lang="en"> 
		<head> 
			<meta charset="UTF-8"> 
			<meta name="viewport" content="width=device-width, initial-scale=1.0"> 
			<title>Apples</title> 
			<link href="blogs.css" rel="stylesheet" type="text/css">

		</head> 
		<body> 
			<div id="postsContainer">
			</div>
		</body> 
		</html> 

	<script>
		const blogPosts = [
        	{userName: 'INSERT USERNAME HERE', userIcon: '../photo_abcd_A/images/blankicon.jpg', image: '../photo_abcd_A/images/apples.jpg', title: 'A is for Apple', description: 'APPLE APPLE APPLE'},
			{userName: 'INSERT USERNAME HERE', userIcon: '../photo_abcd_A/images/blankicon.jpg', image: '../photo_abcd_A/images/bananas.jpg', title: 'B is for Banana', description: 'BANANA BANANA BANANA'},
			{userName: 'INSERT USERNAME HERE', userIcon: '../photo_abcd_A/images/blankicon.jpg', image: '../photo_abcd_A/images/clementines.jpeg', title: 'C is for Clementine', description: 'CLEMENTINE CLEMENTINE CLEMENTINE'},
			{userName: 'INSERT USERNAME HERE', userIcon: '../photo_abcd_A/images/blankicon.jpg', image: '../photo_abcd_A/images/dragonfruit.jpg', title: 'D if for Dragonfruit', description: 'DRAGONFRUIT DRAGONFRUIT DRAGONFRUIT'},
			{userName: 'INSERT USERNAME HERE', userIcon: '../photo_abcd_A/images/blankicon.jpg', image: '../photo_abcd_A/images/eggplant.jpg', title: 'E is for Eggplant', description: 'EGGPLANT EGGPLANT EGGPLANT'},
			{userName: 'INSERT USERNAME HERE', userIcon: '../photo_abcd_A/images/blankicon.jpg', image: '../photo_abcd_A/images/fig.jpg', title: 'F is for Fig', description: 'FIG FIG FIG'},
			{userName: 'INSERT USERNAME HERE', userIcon: '../photo_abcd_A/images/blankicon.jpg', image: '../photo_abcd_A/images/grapefruit.jpg', title: 'G is for Grapefruit', description: 'GRAPEFRUIT GRAPEFRUIT GRAPEFRUIT'},
			{userName: 'INSERT USERNAME HERE', userIcon: '../photo_abcd_A/images/blankicon.jpg', image: '../photo_abcd_A/images/honeydew.jpg', title: 'H is for Honeydew', description: 'HONEYDEW HONEYDEW HONEYDEW'},
			{userName: 'INSERT USERNAME HERE', userIcon: '../photo_abcd_A/images/blankicon.jpg', image: '../photo_abcd_A/images/icaco.jpg', title: 'I is for Icaco', description: 'ICACO ICACO ICACO'},
			{userName: 'INSERT USERNAME HERE', userIcon: '../photo_abcd_A/images/blankicon.jpg', image: '../photo_abcd_A/images/jackfruit.jpg', title: 'J is for Jackfruit', description: 'JACKFRUIT JACKFRUIT JACKFRUIT'}
    	];

		const postsContainer = document.getElementById('postsContainer');
		const buttontext = '⚪ ⚪ ⚪';

		blogPosts.forEach(post => {
				// Create a new blog post container
				const blogContainer = document.createElement('div');
				blogContainer.className = 'blog-container'; // Add class for styling

				// Create blog user container
				const blogUserContainer = document.createElement('div');
				blogUserContainer.className = 'blog-user-container';
				
				// Create the user image
				const userImage = document.createElement('img');
				userImage.src = post.userIcon;
				userImage.alt = 'User Image';
				userImage.className = 'blog-user-image';

				// Create the username
				const username = document.createElement('p');
				username.className = 'blog-username';
				username.textContent = post.userName;

				// Create the user button
				const userbutton = document.createElement('button');
				userbutton.className = 'blog-userbutton';
				userbutton.textContent = buttontext;

				// Create the blog title
				const blogTitle = document.createElement('h2');
				blogTitle.className = 'blog-title';
				blogTitle.textContent = post.title;

				// Create an image container for the image and text
				const imageContainer = document.createElement('div');
				imageContainer.className = 'image-container';

				// Create the image element
				const img = document.createElement('img');
				img.src = post.image;
				img.alt = 'Blog Image';
				img.className = 'blog-photo';

				// Create a text element for the blog post description
				const blogDescription = document.createElement('p');
				blogDescription.className = 'blog-description';
				blogDescription.textContent = post.description;

				const blogSeperator = document.createElement('hr');
				blogSeperator.className = 'blog-seperator';

				blogUserContainer.appendChild(userImage);
				blogUserContainer.appendChild(username);
				blogUserContainer.appendChild(userbutton);

				imageContainer.appendChild(img);

				blogContainer.appendChild(blogUserContainer);
				blogContainer.appendChild(blogTitle);
				blogContainer.appendChild(imageContainer);
				blogContainer.appendChild(blogDescription);

				postsContainer.appendChild(blogContainer);
				postsContainer.appendChild(blogSeperator);
			});
	</script>
</div>

<?php include("includes/footer.php");?>

</body>
</html>