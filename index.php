<?php
// Подключение к базе данных
include('db_connect.php');
// Список допустимых таблиц, соответствующих маркам автомобилей
$allowed_tables = ['Audi', 'Chevrolet', 'Ford', 'Hyundai', 'Infiniti', 'Lexus', 'Mercedes', 'Mitsubishi', 'Nissan', 'Others', 'Toyota'];
// Создание массива для хранения запросов
$queries = [];
// Формирование SQL-запросов для каждой таблицы
foreach ($allowed_tables as $table) {
    $queries[] = "SELECT '$table' AS Brand, Car_Name, Car_Img, Car_Year, Car_Litres, Car_Cylinders, Car_Seats, Car_Price FROM $table WHERE Car_Popular = '1'";
}
// Объединение всех запросов с помощью UNION
$final_query = implode(' UNION ', $queries) . " ORDER BY Brand ASC, Car_Name ASC";
// Выполнение объединенного SQL-запроса
$result = mysqli_query($connect, $final_query);
if (!$result) {
    die("Ошибка выполнения запроса: " . mysqli_error($connect));
}

$resultlogo = mysqli_query($connect, "SELECT * FROM `Cars`");
session_start();
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/vehicle.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/contacts.css">
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
                            <a href="#sectionAbout"><img src="img/AzAnAuto.svg" class="img-fluid" alt="AzAnAuto"></a>
                            <button class="navbar-toggler navbar-light border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                                <span class="navbar-toggler-icon"></span> <!-- This should display the hamburger icon -->
                            </button>
                
                            <div class="collapse navbar-collapse" id="navbarNav">
                                <ul class="navbar-nav me-auto">
                                    <li class="nav-item ms-32px">
                                        <a class="nav-link fs-22px ps-0 pe-0" href="#sectionAbout">Главная</a>
                                    </li>
                                    <li class="nav-item ms-32px">
                                        <a class="nav-link fs-22px ps-0 pe-0" href="#sectionCatalog">Каталог</a>
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
    
    <section id="sectionAbout" class="box section about mt-132px">
        <div class="container p-0">
            <div class="row">
                <div class="col-lg-5 col-md-12 d-flex align-items-center">
                    <div>
                        <h2 class="mb-3 fs-48px about_color">Ваш идеальный автомобиль — наша забота</h2>
                        <p class="text-start fs-28px about_color_p">Подбор и доставка авто из ОАЭ</p>
                    </div>
                </div>
                <div class="col-lg-7 col-md-12 d-flex" style="justify-content: flex-end;">
                    <img src="img/Lexus.svg" class="img-fluid br-16px" style="object-fit: cover;">
                </div>
            </div>
        </div>
    </section>

    <section id="sectionLogos" class="box mt-32px">
        <div class="container mb-42px">
            <div class="row d-flex justify-content-between" style="gap: 50px;">
                <div class="col-xl-3 col-md-6 col-sm-12 logo_car" style="padding:0; width:192px;">
                    <a><img src="img/logo1.svg" class="img-fluid" style="width:192px"></a>
                </div>
                <div class="col-xl-3 col-md-6 col-sm-12 logo_car" style="padding:0; width:192px;">
                    <a><img src="img/logo2.svg" class="img-fluid" style="width:192px"></a>
                </div>
                <div class="col-xl-3 col-md-6 col-sm-12 logo_car" style="padding:0; width:192px;">
                    <a><img src="img/logo3.svg" class="img-fluid" style="width:192px"></a>
                </div>
                <div class="col-xl-3 col-md-6 col-sm-12 logo_car" style="padding:0; width:192px;">
                    <a><img src="img/logo4.svg" class="img-fluid" style="width:192px"></a>
                </div>
                <div class="col-xl-3 col-md-6 col-sm-12 logo_car" style="padding:0; width:192px;">
                    <a><img src="img/logo5.svg" class="img-fluid" style="width:192px"></a>
                </div>
                <div class="col-xl-3 col-md-6 col-sm-12 logo_car" style="padding:0; width:192px;">
                    <a><img src="img/logo6.svg" class="img-fluid" style="width:192px"></a>
                </div>
                <div class="col-xl-3 col-md-6 col-sm-12 logo_car" style="padding:0; width:192px;">
                    <a><img src="img/logo7.svg" class="img-fluid" style="width:192px"></a>
                </div>
                <div class="col-xl-3 col-md-6 col-sm-12 logo_car" style="padding:0; width:192px;">
                    <a><img src="img/logo8.svg" class="img-fluid" style="width:192px"></a>
                </div>
                <div class="col-xl-3 col-md-6 col-sm-12 logo_car" style="padding:0; width:192px;">
                    <a><img src="img/logo9.svg" class="img-fluid" style="width:192px"></a>
                </div>
                <div class="col-xl-3 col-md-6 col-sm-12 logo_car" style="padding:0; width:192px;">
                    <a><img src="img/logo10.svg" class="img-fluid" style="width:192px"></a>
                </div>
            </div>
        </div>
    </section>

    <section id="sectionPopular" class="box mt-32px">
        <div class="container py-4">
            <div class="row">
                <div class="col-12 p-0">
                    <h2 class="text-left mb-32px services_color fs-32px">Популярное</h2>
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

    <section id="sectionCatalog" class="box mt-32px">
        <div class="container mb-42px">
            <div class="row mt-5">
                <div class="col-12 p-0">
                    <h2 class="text-left mb-32px services_color fs-32px">Каталог</h2>
                </div>
            </div>
            <div class="row d-flex justify-content-between" style="gap: 42px;">
                <?php while ($cars = mysqli_fetch_assoc($resultlogo)) { ?>
                    <div class="col-lg-2 col-md-3 col-sm-4 col-6 car_card" style="padding:0; width:192px;">
                        <a href="catalog.php?brand_name=<?php echo urlencode($cars['Cars_Name']); ?>" style="text-decoration: none; color:black;">
                            <img class="img-fluid" style="padding-bottom:24px;padding-top:12px;float: right;" src="data:image/webp;base64,<?php echo base64_encode($cars['Cars_Img']); ?>" alt="Car Image">
                            <div class="car_text" style="padding-left:12px;padding-bottom:12px"><?php echo htmlspecialchars($cars['Cars_Name']); ?></div>
                        </a>
                    </div>
                <?php } ?>
            </div>
            <div class="row mt-5">
                <div class="col-12 p-0 d-flex justify-content-end">
                    <a class="fs-22px button_cars" href="catalog.php?brand_name=Others">Прочие марки</a>
                </div>
            </div>
        </div>
    </section>

    <section id="sectionContact" class="box mt-64px mb-64px contacts">
        <div class="container">
            <div class="row">
                <div class="contacts-zone col-lg-5 col-md-12 mb-32px">
                    <a class="contacts-title fs-48px">Контакты</a>
                    <a class="contacts-subtitle fs-28px">Свяжитесь с нами!</a>
                    <div class="contacts-info fs-20px">
                        <!-- <a><img src="images/phone-icon.png" alt="Phone Icon">+973 1234 1234</a> -->
                        <a href="https://t.me/azanauto" class="contacts-badge fs-20px"><img src="img/telegram.png" alt="Telegram">@azanauto</a>
                    </div>
                </div>
                <div class="form-section col-lg-6 col-md-12">
                    <h2 class="mb-24px fs-48px contact_color text-end">Оставьте заявку</h2>
                    <form id="contactForm" method="post" action="send.php">
                        <div class="form-group">
                            <input type="text" id="fio" name="fio" placeholder="Введите ваше имя" required pattern="[А-Яа-яЁё\s]+" title="Введите корректное ФИО (только буквы и пробелы)">
                        </div>
                        <div class="form-group">
                            <input type="email" id="email" name="email" placeholder="Введите ваш e-mail" required pattern=".*@.*" title="Введите ваш e-mail">
                        </div>
                        <div class="form-group">
                            <textarea spellcheck="true" id="message" name="message" placeholder="Введите ваше сообщение..." required minlength="10"  title="Сообщение должно содержать минимум 10 символов"></textarea>
                        </div>
                        <?php if ($_SESSION['message']) {
                            echo '<a class="fs-18px message">'.$_SESSION['message'].'</a>';
                            }
                            unset($_SESSION['message']);
                        ?>
                        <button type="submit" class="fs-22px button_cars" onclick="myFunction()">Отправить</button>
                    </form>
                </div>
            </div>
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

