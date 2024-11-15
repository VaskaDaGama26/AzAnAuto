<?php
session_start(); // Начинаем сессию

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Получаем данные из формы и очищаем
    $fio = htmlspecialchars(trim($_POST['fio']));
    $email = htmlspecialchars(trim($_POST['email']));
    $message = htmlspecialchars(trim($_POST['message']));

    // Валидация данных
    $errors = [];

    // Проверка ФИО
    if (empty($fio) || !preg_match("/^[А-Яа-яЁё\s]+$/u", $fio)) {
        $errors[] = "Введите корректное ФИО.";
    }

    // Проверка email
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Введите корректный адрес электронной почты.";
    }

    // Проверка сообщения
    if (empty($message) || strlen($message) < 10) {
        $errors[] = "Сообщение должно содержать минимум 10 символов.";
    }

    // Если есть ошибки, выводим их
    if (!empty($errors)) {
        echo implode("<br>", $errors);
    } else {
        // Данные для Telegram
        $token = '7880792506:AAHxwhhfcHr1_HgjK6SGxHAnvzQPYo5BqY4';  // Замените на токен вашего бота
        $chat_ids = ['8168844876', '386557013', '1275451772', '7674721403'];  // Массив chat_id для всех получателей
        $text = "Новое сообщение с сайта:\n\nФИО: $fio\nEmail: $email\nСообщение: $message";

        // URL для отправки сообщения в Telegram
        $url = "https://api.telegram.org/bot{$token}/sendMessage";

        // Параметры для отправки
        $data = [
            'text' => $text,
            'parse_mode' => 'HTML' // Можно использовать HTML-разметку
        ];

        $all_sent = true; // Флаг успешности отправки

        // Отправляем сообщение каждому пользователю из списка
        foreach ($chat_ids as $chat_id) {
            $data['chat_id'] = $chat_id;  // Устанавливаем chat_id для текущего пользователя
            
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            // Отправка сообщения и получение ответа
            $response = curl_exec($ch);
            $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            // Декодируем ответ
            $response_data = json_decode($response, true);

            // Проверка на успех для каждого пользователя
            if ($http_code != 200 || !isset($response_data['ok']) || !$response_data['ok']) {
                $all_sent = false;
                // Логирование ошибки в файл
                error_log("Ошибка при отправке сообщения пользователю $chat_id: " . $response_data['description'] . "\n", 3, "send_errors_log.log");
            }
        }

        // Проверка, если все сообщения успешно отправлены
        //if ($all_sent) {
            // Устанавливаем сообщение для уведомления
            $_SESSION['message'] = 'Ваше сообщение успешно отправлено!';
            header('Location: index.php#sectionContact');
        //} else {
            echo "Произошла ошибка при отправке сообщения. Пожалуйста, обратитесь к нам через предложенные контакты.";
        //}
    }
} else {
    echo "Неверный метод запроса.";
}
