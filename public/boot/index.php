<!DOCTYPE html>
<html lang="en" class="team">
<head>
    <link href="public/vendor/css/bootstrap/bootstrap.min.css" rel="stylesheet">
    <link href="public/themes/default/css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="public/vendor/css/vendor.css">
</head>
<body class="setup-prechecks">
<div class="x-wrapper">
    <div class="col-12 p-t-40 card-no-border">
        <div class="card">
            <div class="card-body">
                <div class="text-center"><h3 class="card-title">CRM</h3>
                    <h5>System Check</h5>
                    <div><img src="public/images/system-checks.png" width="300" alt="system checks failed"/></div>
                    <p class="card-text">The following (minimum system requirements) must be met before you can
                        continue." target="_blank">documentation</a> for details.</p>
                </div>
                <div class="m-t-20"></br></br><h5 class="text-info"> PHP Requirement</h5>
                    <table class="table table-bordered w-100"> <?php echo $messages_php; ?> '</table>
                    </br></br><h5 class="text-info"> Folder - Writable Permission</h5>
                    <table class="table table-bordered w-100"> <?php echo $messages_chmod ;?></table>
                </div>
                <div class="text-center"><a href="/" class="btn btn-info">Retry</a></div>
            </div>
        </div>
    </div>
</div>
</body>
<html>