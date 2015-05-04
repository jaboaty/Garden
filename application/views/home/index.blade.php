<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title>Garden Admin Section</title>
	<meta name="viewport" content="width=device-width">
	<meta http-equiv="Content-Language" content="en" />
	<meta name="google" value="notranslate">
	{{ Asset::container('bootstrapper')->styles(); }}
	{{ Asset::container('bootstrapper')->scripts(); }}
	<style>
	body {
	    padding-top: 60px;
	    padding-bottom: 40px;
	}
	</style>

</head>
<body>
	<div class="wrapper">

		<div class="navbar navbar-fixed-top">
            <div class="navbar-inner">
                <div class="container">
                    <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </a>
                    <a class="brand" href="{{ URL::base(); }}">Kiva Garden</a>
                    <div class="nav-collapse collapse">
                        <ul class="nav pull-right">
                            <li><a href="{{ URL::base(); }}">Add New Projects</a></li>
                            <li><a href="{{ URL::to('borrowers'); }}">Tracked Borrowers</a></li>
                            <li><a href="{{ URL::to('update'); }}">Manual Update</a></li>
                            <li><a href="{{ URL::to('synch'); }}">Manual Synchronize</a></li>
                            <li><a href="{{ URL::to('export'); }}">Export</a></li>
                        </ul>
                    </div><!--/.nav-collapse -->

                </div>
            </div>
        </div>


        <div class="container">
			<?php if (isset($alert)): ?>
				<?php echo $alert; ?>
			<?php endif; ?>

			<?php if (isset($content)): ?>
				<?php echo $content; ?>
			<?php else: ?>
				There seems to be some kind of issue.
			<?php endif; ?>

		</div>
	</div>
</body>
</html>
