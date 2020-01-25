<?php ?>

<div class="container">
    <div class="row">
        <div class="col-lg-9 m-auto text-center">
			<br>
    		<h2><?php echo "Hello ", isset($_SESSION['email']) ? $_SESSION['email'] : "Admin", "!";  ?> </h2>

			

    		<div id="addNewElementButton"><a href="admin/add">Add new element</a></div>
    		<div id="logoutButton"><a href="admin/logout">Logout</a></div>

    		<br>
    		<br>
    		<br>
    	</div>
    </div>
</div>