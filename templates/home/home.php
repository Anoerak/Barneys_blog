 <div class="hero__container">
 	<h1>Welcome to the legendary blog of Barney Stinson!</h1>
 	<p>First, be advise that all texts in this blog are written by <a href="https://chat.openai.com/">Open ChatGPT by
 			openAI</a>.</p>
 	<p>As an introduction, let's start with 'what is a blog??' 😉</p>
 	<p>A blog, short for "weblog," is a type of website that features regularly updated content, often written in a
 		personal or informal style.<br>
 		Blogs first emerged in the late 1990s and early 2000s, and quickly gained popularity as a way for individuals
 		and organizations to share their thoughts and ideas with a wide audience.<br>
 		One of the things that made blogs so awesome was that they democratized the process of publishing and sharing
 		information.<br>
 		Before blogs, the only way to reach a large audience with your writing was to go through traditional
 		gatekeepers, such as publishers or media outlets.<br>
 		With a blog, anyone with an internet connection and a basic understanding of how to create a website could
 		publish their own content and reach a global audience.<br>
 		This led to a proliferation of diverse voices and perspectives, and helped to usher in an era of citizen
 		journalism and online activism.</p>
 </div>

 <section class="home__container">

 	<aside>
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