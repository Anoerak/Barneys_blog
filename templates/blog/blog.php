 <div class="hero__container">
 	<h1>My Legendary Blog</h1>
 	<p>Welcome to the awesomest blog in the history of blogs, the one and only Barney Stinson's Blog!<br>
 		I am Barney Stinson, the ultimate ladies man, the bro to end all bros, and the master of the legendary
 		"Playbook."<br>
 		Here, I'll be sharing with you all my legendary moves, tips, and tricks to make your life more awesome.<br>
 		From dating and relationships, to work and career, to just living life to the fullest, I've got you
 		covered.<br>
 		So sit back, grab a beer, and get ready to level up your awesomeness.<br>
 		Let's make it legendary!</p>
 	<?php
		session_start();
		if (isset($_SESSION['logged_user']) && ($_SESSION['privileges']['privilege'] === 'admin')) : ?>
 		<a href="index.php?page=post&action=new" class="add__post__button purple__button">
 			Add a post
 		</a>
 	<?php endif; ?>
 </div>

 <section class="blog__container">

 	<aside>
 		<div class="searchbar">
 			<input type="text" name="search" placeholder="Search">
 		</div>
 		<div class="categories">
 			<h2>Blog Categories</h2>
 			<ul>
 				<a href="index.php?page=blog&option=Career">
 					<li>Career</li>
 				</a>
 				<a href="index.php?page=blog&option=Dating">
 					<li>Dating</li>
 				</a>
 				<a href="index.php?page=blog&option=Food">
 					<li>Food</li>
 				</a>
 				<a href="index.php?page=blog&option=Life">
 					<li>Life</li>
 				</a>
 				<a href="index.php?page=blog&option=Tech">
 					<li>Tech</li>
 				</a>
 				<a href="index.php?page=blog&option=Travel">
 					<li>Travel</li>
 				</a>
 			</ul>
 			<br>
 			<h2>Quick Navigation</h2>
 			<ul>
 				<a href="index.php?page=blog&option=all">
 					<li>View All</li>
 				</a>
 				<a href="index.php?page=blog&option=latest">
 					<li>Latest</li>
 				</a>
 				<a href="index.php?page=blog&option=popular">
 					<li>Most Popular</li>
 				</a>
 				<a href="index.php?page=blog&option=mostCommented">
 					<li>Most Commented</li>
 				</a>
 			</ul>
 			<br>
 			<h2>Other</h2>
 			<ul>
 				<a href="index.php?page=resume">
 					<li>My Bro-lific Resume</li>
 				</a>
 				<a href="index.php?page=rules">
 					<li>The Bro Code</li>
 				</a>
 			</ul>
 		</div>
 	</aside>

 	<article>
 		<?php foreach ($datas as $post) : ?>
 			<div class="card">
 				<div class="card__image">
 					<img src="<?= $post->picture ?>" alt="Card image" />
 					<div class="card__subtext">
 						<div class="card__infos">
 							<p class="card__author"><?= $post->author_username ?></p>
 							<p class="card__date"><?= $post->created_at ?></p>
 						</div>
 						<p class="card__category"><?= $post->category ?></p>
 					</div>
 				</div>
 				<div class="card__content">
 					<h3 class="card__title"><?= $post->title ?></h3>
 					<p class="card__text"><?= $post->content ?></p>
 					<a href="index.php?page=post&action=get&option=view&id=<?= $post->id ?>" class="purple__button">Read
 						more</a>
 				</div>
 			</div>
 		<?php endforeach; ?>

 	</article>

 </section>