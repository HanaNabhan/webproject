<?php include_once("adminComp/header.php");
// select data from admin users table ... 
$selected = $conn->query("SELECT * FROM admins");
$selected->execute();
$data = $selected->fetchAll(PDO::FETCH_ASSOC);
// echo "sdssss" ; 
?>

<head>
    <style>
        table {
            border: 2px aliceblue solid;
            /* position: absolute; */
            /* top: 30%;
            left: 20%;*/
            width: fit-content;
            border-collapse: separate;
        }

        th,
        td {
            padding: 10px;
            border: 2px aliceblue solid;
            text-align: center;
        }

        thead,
        tbody:nth-child(odd) {
            background-color: aliceblue;
        }

        .card {
            width: fit-content;
            height: fit-content;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-left: 34vw;
            margin-top: 18vh;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .card-content {
            padding: 20px;
            width: 100%;
        }

        .btn:active , .btn {
            display: inline-block;
            padding: 8px 12px;
            color: gainsboro;
            background-color: #0079dd;
            text-decoration: none;
            border-radius: 3px;
            margin-top: 10px;
        }
        .card-content div {
            margin-left: 66% ;
            /* margin: fit-content; */
        }
        .card-content div .btn {
            margin-top: 5%;
        }
        .mg {
            margin-bottom: 2% ;
        }
    </style>
</head>

<body>
    <div class="card">
        <div class="card-content">
            <div class="mg">
                <a href="adminRegister.php" class="btn">Create a new Admin</a>
            </div>
            <table>
                <thead>
                    <th>
                        #
                    </th>
                    <th>
                        username
                    </th>
                    <th>
                        email
                    </th>
                    <th>
                        status
                    </th>
                    <th>
                        Update
                    </th>
                    <th>
                        Delete
                    </th>
                </thead>
                <?php foreach ($data as $row) : ?>
                    <tbody>
                        <td>
                            <?php echo $row['id']; ?>
                        </td>
                        <td>
                            <?php echo $row['username'];  ?>
                        </td>
                        <td>
                            <?php echo $row['email'];  ?>
                        </td>
                        <?php if ($row['role'] == 0) : ?>
                            <td>
                                <?php echo 'SuperAdmin' ?>
                            </td>
                        <?php else : ?>
                            <td>
                                <?php echo 'Normal Admin' ?>
                            </td>
                        <?php endif; ?>
                        <td>
                            <a href="adminUpdate.php?id=<?php echo $row['id'] ; ?>" class="btn">Update</a>

                        </td>
                        <td>
                            <a href="adminDelete.php?id=<?php echo $row['id'] ; ?>" class="btn">Delete</a>

                        </td>
                    </tbody>
                <?php endforeach; ?>
            </table>
        </div>
    </div>

</body>

</html>




<?php include_once("adminComp/footer.php");
