<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fio = htmlspecialchars(trim($_POST['fio']));
    $email = htmlspecialchars(trim($_POST['email']));
    $message = htmlspecialchars(trim($_POST['message']));

    $errors = [];

    if (empty($fio) || !preg_match("/^[А-Яа-яЁё\s]+$/u", $fio)) {
        $errors[] = "Введите корректное ФИО.";
    }

    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Введите корректный адрес электронной почты.";
    }

    if (empty($message) || strlen($message) < 10) {
        $errors[] = "Сообщение должно содержать минимум 10 символов.";
    }

    if (!empty($errors)) {
        echo implode("<br>", $errors);
    } else {
        $token = '';  // TGBot Token
        $chat_ids = [];  // Add TG IDs
        $text = "Новое сообщение с сайта:\n\nФИО: $fio\nEmail: $email\nСообщение: $message";

        $url = "https://api.telegram.org/bot{$token}/sendMessage";

        $data = [
            'text' => $text,
            'parse_mode' => 'HTML'
        ];

        $all_sent = true; 

        foreach ($chat_ids as $chat_id) {
            $data['chat_id'] = $chat_id; 
            
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            $response = curl_exec($ch);
            $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);
            
            $response_data = json_decode($response, true);

            if ($http_code != 200 || !isset($response_data['ok']) || !$response_data['ok']) {
                $all_sent = false;
                error_log("Ошибка при отправке сообщения пользователю $chat_id: " . $response_data['description'] . "\n", 3, "send_errors_log.log");
            }
        }
        //if ($all_sent) {
            $_SESSION['message'] = 'Ваше сообщение успешно отправлено!';
            header('Location: index.php#sectionContact');
        //} else {
            echo "Произошла ошибка при отправке сообщения. Пожалуйста, обратитесь к нам через предложенные контакты.";
        //}
    }
} else {
    echo "Неверный метод запроса.";
}
