<?php
    require_once $_SERVER['DOCUMENT_ROOT'] . "www/ulti/ulti.php";

    httpsRedirect();

    if(!checkSession())
    {
        $redirect = $GLOBALS['domain_url'] . "index.php";
        header("Location: $redirect");
    }

    session_id($_COOKIE['sessionId']);
    session_start();

?>

<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
    <title>Trang chủ</title>
    <meta name="description" content="">
    <meta name="author" content="">

    <link rel="stylesheet" type="text/css" href="/www/css/style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    
    <script src="https://kit.fontawesome.com/e5407c478d.js" crossorigin="anonymous"></script>
</head>
<body">
    <div class="menu-bar row">
        <div class="menu-bar-element col-9" id="home-button">
            <a href="/www/home.php"><i class="fas fa-home fa-lg fa-fw"></i></a>
        </div>
        <div class="menu-bar-element col" id="user-field">
            <?php 
                echo    '<div><a href="/www/user.php?userId='. $_SESSION['userId'] . '">
                            <i class="fas fa-user fa-lg fa-fw"></i> Xin chào ' . $_SESSION['userName'] .'
                        </a></div>';
            ?>
        </div>
    </div>
    <div class="container-fluid">
        <div class="table-control">
            <p>Theo dõi tình hình dịch bệnh</p>
            <nav class="navbar navbar-expand-lg navbar-light" style="position: inherit;">
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav country-list">
                        <li class="nav-item active" id="vn-button">
                            <a class="nav-link btn" onclick="showVNTable()" href="#">Việt Nam</a>
                        </li>
                        <li class="nav-item" id="world-button">
                            <a class="nav-link btn" onclick="showWorldTable()" href="#">Thế giới</a>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
        <div class="table-content">
            <?php 
                $files = scandir($_SERVER['DOCUMENT_ROOT'] . 'crawler/corona_tracking/', SCANDIR_SORT_DESCENDING);
                $newFile = $_SERVER['DOCUMENT_ROOT'] . 'crawler/corona_tracking/' . $files[0];

                $vnInfo = [];

                if(($handle = fopen($newFile, "r")) != FALSE) 
                {
                    // World table
                    echo '<table id="world-table"><tbody>';
                    $i = 0;
                    while (($row = fgetcsv($handle, 1000, ",")) !== FALSE) 
                    {
                        // Assign $vnInfo with array contain VN's Covid infos
                        if(array_search('Vietnam', $row))
                        {
                            $vnInfo = array_values($row);
                        }
                        if($i == 0)
                        {
                            echo '<tr>';
                            foreach ($row as $column) {
                                echo '<th>' . $column . '</th>';
                            }
                            echo '</tr>';
                        }
                        else
                        {
                            echo '<tr>';
                            $c = 0;
                            foreach ($row as $column) {
                                if($c == 0)
                                    echo '<td class="sort">' . $column . '</td>';
                                else if($c == 1)
                                    echo '<td class="alg-left" id="country-name">' . $column . '</td>';
                                else
                                    echo '<td class="alg-right">' . $column . '</td>';
                                $c++;
                            }
                            echo '</tr>';
                        }
                        $i++;
                    }
                    echo '</tbody></table>';

                    // Viet Nam table
                    echo '<table id="vn-table"><tbody>';
                    echo '<tr>';
                    echo    '<th>Tổng số ca</th>
                            <th>Số ca mới</th>
                            <th>Số ca tử vong</th>
                            <th>Ca tử vong mới</th>
                            <th>Số ca hồi phục</th>
                            <th>Ca hồi phục mới</th>';
                    echo '</tr>';
                    echo '<tr>';
                    for($c = 2; $c < 8; $c++)
                    {
                        echo '<td class="alg-right">' . $vnInfo[$c] . '</td>';
                    }
                    echo '</tr>';
                    echo '</tbody></table>';

                    fclose($handle);
                }
            ?>
        </div>
    </div>

    <script src="/www/js/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
    <script type="text/javascript">
        function showWorldTable() {
            document.getElementById('world-table').style.display = 'block';
            document.getElementById('vn-button').classList.remove('active');
            document.getElementById('world-button').classList.add('active');
        }

        function showVNTable() {
            document.getElementById('world-table').style.display = 'none';
            document.getElementById('vn-button').classList.add('active');
            document.getElementById('world-button').classList.remove('active');
        }
    </script>
</body>
</html>