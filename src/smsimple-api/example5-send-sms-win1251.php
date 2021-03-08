<?php

    require_once('./smsimple.config.php');
    require_once('./smsimple.class.php');

    header('Content-type: text/html; charset=windows-1251');

    $_POST['message'] = '���-�������� ������ � ������! ���������� � ����� smsimple.ru';
    
    $sms = new SMSimple(array(
        'url' => SMS_API,
        'username' => SMS_USERNAME,
        'password' => SMS_PASSWORD,
        'encoding' => 'windows-1251',  // !!! <- ��� �����: ���� �������� ������������ �� � ��������� utf-8, �� ����� ��������� "������� ���������", � ������ ������ ��� win-1251
    ));

    try {

        $sms->connect();
        $origins_list = $sms->origins();
        $message = '';
        $error = false;

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $message_id = $sms->send($_POST['origin_id'], $_POST['phone'], $_POST['message'], true);
            $message = '��������� ���������� (#'.(is_array($message_id)?join(', #',$message_id):$message_id).')';
        }

    }
    catch (SMSimpleException $e) {
        $error = true;
        $message = $e->getMessage();
    }

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
    <title>SMSimple API</title>
    <meta http-equiv="content-type" content="text/html; charset=WINDOWS-1251" />
    <link href="style.css" rel="stylesheet" type="text/css"/>
</head>
<body>

    <h2>��������� SMS</h2>

    <? if ($message) : ?>
        <p class="red"><?= htmlspecialchars($message) ?></p>
    <? endif ?>

    <? if (!$error) : ?>
        <form method="post" action="">
            <dl>
                <dt>������� �����������:</dt>
                <dd>
                    <select name="origin_id">
                        <? foreach ($origins_list as $origin) : ?>
                            <option value="<?= $origin['id'] ?>"><?= htmlspecialchars($origin['title']) ?></option>
                        <? endforeach ?>
                    </select>
                </dd>
                <dt>�������� ����������� (���� ��� ��������� ����� �������):</dt>
                <dd>
                    <input type="text" name="phone" size="50" value="<?= htmlspecialchars($_POST['phone']) ?>"/><br />
                    <span class="gray small">��������, 7-926-111-2233</span>
                </dd>
                <dt>���������:</dt>
                <dd>
                    <textarea name="message" cols="50" rows="6" readonly="readonly">���-�������� ������ � ������! ���������� � ����� smsimple.ru</textarea>
                </dd>
                <dt>&nbsp;</dt>
                <dd>
                    <input type="submit" value="������� SMS"/>
                </dd>
            </dl>
        </form>
    <? else : ?>
        <p><a href="">��������� ������ ���������</a></p>
    <? endif ?>

</body>
</html>