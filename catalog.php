<?php
// Подключение к базе данных
include('db_connect.php');
// Получаем brand_name из GET-параметра и экранируем для безопасности
$brand_name = isset($_GET['brand_name']) ? mysqli_real_escape_string($connect, $_GET['brand_name']) : '';

// Список допустимых таблиц, соответствующих маркам автомобилей
$allowed_tables = ['Audi', 'Chevrolet', 'Ford', 'Hyundai', 'Infiniti', 'Lexus', 'Mercedes', 'Mitsubishi', 'Nissan', 'Others', 'Toyota'];
// Если переданное название марки не совпадает с существующими таблицами, используем таблицу 'Others'
$table_name = in_array($brand_name, $allowed_tables) ? $brand_name : 'Others';
// SQL-запрос для получения данных из выбранной таблицы
$query = "SELECT Car_Name, Car_Img, Car_Year, Car_Litres, Car_Cylinders, Car_Seats FROM $table_name ORDER BY Car_Name ASC";
$result = mysqli_query($connect, $query);
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/vehicle.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <title>AzAnAuto</title>
    <link rel="icon" href="/img/AzAnLogo.png" type="image/png">
    <link rel="preload" href="/font/proximanova_bold.otf" as="font" type="font/otf" crossorigin>
    <link rel="preload" href="/font/proximanova_extrabold.otf" as="font" type="font/otf" crossorigin>
    <link rel="preload" href="/font/proximanova_light.otf" as="font" type="font/otf" crossorigin>
    <link rel="preload" href="/font/proximanova_regular.otf" as="font" type="font/otf" crossorigin>
    <link rel="preload" href="/script/animation.js" as="script">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>
<body>
    
    <header id="SectionHeader" class="header pt-3 bg-white fixed-top custom-underline">
        <div class="container text-center pb-3 px-0">
            <div class="row align-items-center">
                <div class="col-12">
                    <nav class="navbar navbar-expand-lg">
                        <div class="container-fluid text-center p-0">
                            <a href="./index.php"><img src="img/AzAnAuto.svg" class="img-fluid" alt="AzAnAuto"></a>
                            <button class="navbar-toggler navbar-light border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                                <span class="navbar-toggler-icon"></span> <!-- This should display the hamburger icon -->
                            </button>
                
                            <div class="collapse navbar-collapse" id="navbarNav">
                                <ul class="navbar-nav me-auto">
                                    <li class="nav-item ms-32px">
                                        <a class="nav-link fs-22px ps-0 pe-0" href="./index.php#sectionAbout">Главная</a>
                                    </li>
                                    <li class="nav-item ms-32px">
                                        <a class="nav-link fs-22px ps-0 pe-0" href="./index.php#sectionCatalog">Каталог</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="collapse navbar-collapse" id="navbarNav">
                                <ul class="navbar-nav ms-auto">
                                    <li class="nav-item ms-32px">
                                        <a class="fs-22px button_cars" href="#sectionContact">Оставить заявку</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </header>

    <section id="sectionPopular" class="box mt-132px">
        <div class="container py-4">
            <div class="row mb-3">
                <div class="col-12 p-0">
                    <a style="text-decoration:none" href="index.php" class="text-left back-button fs-18px"><span class="material-icons">arrow_back_ios</span>Назад</a>
                </div>
            </div>
            <div class="row">
                <div class="col-12 p-0">
                    <?php echo '<h2 class="text-left mb-32px services_color fs-32px">' . $table_name . '</h2>'?>
                </div>
            </div>
            <?php 
            // Проверяем, что запрос вернул результаты
            if ($result && mysqli_num_rows($result) > 0) {
                echo '<div class="row justify-content-start gy-4">';
                while ($car = mysqli_fetch_assoc($result)) {
                    echo '
                        <div class="col-md-4">
                            <div class="vehicle-card">
                                <img src="data:image/jpeg;base64,'. base64_encode($car['Car_Img']).  '" alt="' . htmlspecialchars($car['Car_Name']).'">
                                <div class="vehicle-details">
                                    <span class="vehicle-title" style="color:black;">' . htmlspecialchars($car['Car_Year']) .' '. htmlspecialchars($car['Car_Name']) . '</span>
                                    <div class="vehicle-info mt-2">
                                        <span class="badge"><span class="material-icons">airline_seat_recline_normal</span>' . htmlspecialchars($car['Car_Seats']) . '</span>
                                        <span class="badge"><span class="material-icons">opacity</span>' . htmlspecialchars($car['Car_Litres']) . 'L</span>
                                        <span class="badge">' . htmlspecialchars($car['Car_Cylinders']) . ' Cylinder</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    ';
                }
                echo '</div>';
            } 
            ?>
        </div>
    </section>
    

        
    <script src="script/jquery.min.js"></script>
    <script src="script/bootstrap.bundle.min.js"></script>
    <script src="script/animation.js"></script>
    <script>
        // Получаем все ссылки навигации
        const navLinks = document.querySelectorAll('.navbar-nav .nav-link');
    
        navLinks.forEach(link => {
            link.addEventListener('click', function() {
                // Закрываем бургер-меню
                const navbarCollapse = document.getElementById('navbarNav');
                const bsCollapse = new bootstrap.Collapse(navbarCollapse, {
                    toggle: false // Не переключаем состояние
                });
                bsCollapse.hide(); // Закрываем меню
            });
        });
    </script>
</body>
</html>



<?php
// Закрытие соединения с базой данных
mysqli_close($connect);
?>
