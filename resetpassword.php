<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/logsignstyle.css">
    <title>Reset your password</title>
    <!-- jQuery + Bootstrap JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
</head>

<body>

    <!-- Header -->
    <?php include('header.php'); ?>

    <!-- Login form -->
    <div class="App">
        <div class="vertical-center">
            <div class="inner-block">

                <form action="controllers/send-recovery-mail.php" method="post">
                    <h3>Reset password</h3>

                    <div class="form-group">
                        <label>Enter email to receive reset mail</label>
                        <input type="email" class="form-control" name="email" id="email"/>
                    </div>

                    <button type="submit" name="login" class="btn btn-outline-primary btn-lg btn-block">Send recovery mail</button>
                        
                </form>
            </div>
        </div>
    </div>

</body>

</html>