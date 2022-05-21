<html>
<head>
    <title> Payment</title>
</head>
<body>
<center>
    <?php
    $vars['pay_to_email']="abcdef@gmail.com";
    $vars['status_url'] = 'http://myserver/response.php';
    $vars['language'] = 'EN';
    $vars['amount'] = '1';
    $vars['currency'] = 'USD';
    $vars['return_url_text'] = 'Return to response.php';
    $vars['return_url'] = 'http://myserver/response.php';
    $vars['cancel_url'] = 'http://myserver/response.php';
    $vars['detail1_description'] = 'Membership';
    ?>
    <form action="https://www.moneybookers.com/app/payment.pl" method="post">
        <?php foreach($vars as $key=>$var){ ?>
            <input type="text" name="<?=$key?>" value="<?=$var?>"/>
        <?php } ?>
        <input type="submit" value="Pay!"/>
    </form>
</center>
<script language='javascript'>document.redirect.submit();</script>
</body>
</html>