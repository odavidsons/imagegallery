<header class="p-2">
	<div class="container-fluid">
		<div class="d-flex flex-wrap justify-content-center justify-content-lg-start">
			<ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
				<li class="nav-item">
					<a class="nav-link text-light" href="index.php?page=home">Home</a>
				</li>
                <li class="nav-item">
					<a class="nav-link text-light" href="index.php?page=upload">Upload</a>
				</li>
                <li class="nav-item">
					<a class="nav-link text-light" href="index.php?page=search">Search</a>
				</li>
			</ul>
			<div class="text-end">
				<ul class="nav">
                <?php
                if (isset($_SESSION['username'])) {
                    ?>
					<li class="nav-item">
						<a class="nav-link text-light" href="index.php?page=profile">Profile</a>
					</li>
                    <li class="nav-item">
						<a class="nav-link text-light"><?php echo $_SESSION['username'] ?></a>
					</li>
					<li class="nav-item">
						<a class="nav-link text-light" href="index.php?page=logout"><span class='material-symbols-outlined'>logout</span> </a>
					</li>
                    <?php
                } else {
                    ?>
					<li class="nav-item">
						<a class="nav-link text-light">Guest Access</a>
					</li>
                    <li class="nav-item dropdown-center">
					<a class="nav-link dropdown-toggle text-light" href="#" data-bs-toggle="dropdown"
						aria-expanded="false">Session</a>
					<ul class="dropdown-menu">
						<li>
							<a class="dropdown-item text-dark"
								href="index.php?page=login">Login</a>
						</li>
						<li>
							<a class="dropdown-item text-dark"
								href="index.php?page=signup">Register</a>
						</li>
					</ul>
				    </li>
                    <?php
                }
                ?>
				</ul>
			</div>
		</div>
	</div>
</header>