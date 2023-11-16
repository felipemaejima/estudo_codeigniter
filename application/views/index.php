<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <table class="table text-center">
            <tr>
                <th>Nome</th>
                <th>Email</th>
            </tr>
        <?php foreach($users as $user) {?> 
            <tr>
                <td><?= $user['nome']?></td>
                <td><?= $user['email']?></td>
            </tr>
            <?php } ?>
        </table>

    </div>
</body>
</html>